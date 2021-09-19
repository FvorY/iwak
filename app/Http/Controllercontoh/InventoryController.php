<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use Carbon\Carbon;

use App\mMember;

use App\Http\Controllers\logController;

use keuangan;

class InventoryController extends Controller
{
    public function barangmasuk()
    {
    	return view('inventory/barangmasuk/barangmasuk');
    }
    public function process_po()
    {
        return view('inventory/barangmasuk/process_po');
    }
    public function barangkeluar()
    {
      if (!mMember::akses('PENGELUARAN BARANG', 'aktif')) {
        return redirect('error-404');
      }
      $data = DB::table('m_item')
                ->join('d_unit', 'u_id', '=', 'i_unit')
                ->get();

    	return view('inventory/barangkeluar/barangkeluar', compact('data'));
    }
    public function kartu_stok(Request $request)
    {
          $request->id = decrypt($request->id);

          $kode = "";

          $querykode = DB::select(DB::raw("SELECT MAX(MID(pb_code,4,3)) as counter, MAX(MID(pb_code,7,2)) as bulan, MAX(MID(pb_code,9)) as tahun FROM d_pengeluaran_barang"));

          if (count($querykode) > 0) {
            if ($querykode[0]->bulan != date('m') || $querykode[0]->tahun != date('Y')) {
                $kode = "001";
            } else {
              foreach($querykode as $k)
                {
                  $tmp = ((int)$k->counter)+1;
                  $kode = sprintf("%03s", $tmp);
                }
            }
          } else {
            $kode = "001";
          }

          $finalkode = 'IO-' . $kode . date('m') . date('Y');

          $item = DB::table('m_item')
                  ->where('i_id', $request->id)
                  ->get();

          $mutasi = DB::table('i_stock_mutasi')
                      ->where('sm_item', $item[0]->i_code)
                      ->get();

        return view('inventory/barangkeluar/kartu_stok', compact('finalkode', 'item', 'mutasi'));
    }
    public function simpankartu(Request $request){
      if (!mMember::akses('PENGELUARAN BARANG', 'tambah')) {
        return redirect('error-404');
      }
      DB::beginTransaction();
      try {

        // return json_encode($request->all());

        $hpp = 0;
        $checkstock = DB::table('i_stock_gudang')
                        ->where('sg_iditem', $request->pbd_item)
                        ->select('sg_qty')
                        ->get();

        if ($checkstock[0]->sg_qty < $request->pbd_qty) {
          return response()->json([
            'status' => 'stock kurang'
          ]);
        } else {
          $pbid = DB::table('d_pengeluaran_barang')
                  ->max('pb_id');

          if ($pbid == null) {
            $pbid = 1;
          } else {
            $pbid += 1;
          }

          DB::table('d_pengeluaran_barang')
              ->insert([
                'pb_id' => $pbid,
                'pb_code' => $request->pb_code,
                'pb_receive_from' => $request->pbd_receive_from,
                'pb_date' => Carbon::parse($request->pb_date)->format('Y-m-d'),
                'pb_insert' => Carbon::now('Asia/Jakarta')
              ]);

          $pbdid = DB::table('d_pengeluaran_barang_dt')
                  ->max('pbd_id');

          if ($pbdid == null) {
            $pbdid = 1;
          } else {
            $pbdid += 1;
          }

          DB::table('d_pengeluaran_barang_dt')
              ->insert([
                  'pbd_id' => $pbdid,
                  'pbd_code' => $request->pb_code,
                  'pbd_receive_from' => $request->pbd_receive_from,
                  'pbd_item' => $request->pbd_item,
                  'pbd_qty' => $request->pbd_qty,
                  'pbd_insert' => Carbon::now('Asia/Jakarta')
              ]);

            $stock = DB::table('i_stock_gudang')
                  ->join('i_stock_mutasi', 'sm_id', '=', 'sg_id')
                  ->select('i_stock_gudang.*', 'i_stock_mutasi.*', DB::raw('(sm_qty - sm_use) as sm_sisa'))
                  ->where('i_stock_gudang.sg_iditem','=', $request->pbd_item)
                  ->where(DB::raw('(sm_qty - sm_use)'), '>', 0)
                  ->get();

              $permintaan = $request->pbd_qty;

              DB::table('i_stock_gudang')
              ->where('sg_id', $stock[0]->sm_id)
              ->where('sg_iditem', $stock[0]->sm_item)
              ->update([
                'sg_qty' => $stock[0]->sg_qty - $permintaan
              ]);

          for ($j=0; $j < count($stock); $j++) {
            //Terdapat sisa permintaan

            $detailid = DB::table('i_stock_mutasi')
                      ->max('sm_iddetail');

             if ($permintaan > $stock[$j]->sm_sisa && $permintaan != 0) {

               DB::table('i_stock_mutasi')
                  ->where('sm_id', '=', $stock[$j]->sm_id)
                  ->where('sm_iddetail', '=', $stock[$j]->sm_iddetail)
                  ->update([
                    'sm_use' => $stock[$j]->sm_qty,
                    'sm_sisa' => 0
                  ]);

              $permintaan = $permintaan - $stock[$j]->sm_sisa;

                DB::table('i_stock_mutasi')
                  ->insert([
                    'sm_id' => $stock[$j]->sm_id,
                    'sm_iddetail' => $detailid + 1,
                    'sm_item' => $request->pbd_item,
                    'sm_description' => $request->pbd_receive_from,
                    'sm_qty' => $stock[$j]->sm_sisa,
                    'sm_use' => 0,
                    'sm_sisa' => $stock[$j]->sm_sisa,
                    'sm_hpp' => $stock[$j]->sm_hpp,
                    'sm_ref' => $request->pb_code,
                    'sm_deliveryorder' => $stock[$j]->sm_deliveryorder
                  ]);

                  $hpp += ($stock[$j]->sm_hpp * $stock[$j]->sm_sisa);

             } elseif ($permintaan <= $stock[$j]->sm_sisa && $permintaan != 0) {
                //Langsung Eksekusi

                $detailid = DB::table('i_stock_mutasi')
                          ->max('sm_iddetail');

                DB::table('i_stock_mutasi')
                   ->where('sm_id', '=', $stock[$j]->sm_id)
                   ->where('sm_iddetail', '=', $stock[$j]->sm_iddetail)
                   ->update([
                     'sm_use' => $permintaan + $stock[$j]->sm_use,
                     'sm_sisa' => $stock[$j]->sm_sisa - $permintaan
                   ]);

                 DB::table('i_stock_mutasi')
                   ->insert([
                     'sm_id' => $stock[$j]->sm_id,
                     'sm_iddetail' => $detailid + 1,
                     'sm_item' => $request->pbd_item,
                     'sm_description' => $request->pbd_receive_from,
                     'sm_qty' => $permintaan,
                     'sm_use' => 0,
                     'sm_sisa' => $permintaan,
                     'sm_hpp' => $stock[$j]->sm_hpp,
                     'sm_ref' => $request->pb_code,
                     'sm_deliveryorder' => $stock[$j]->sm_deliveryorder
                   ]);

                  $hpp += ($stock[$j]->sm_hpp * $permintaan);
                  $permintaan = 0;
                  $j = count($stock) + 1;
             }
          }
        }



        // Tambahan Dirga

          $akunPersediaan = DB::table('dk_akun')
                  ->where('ak_id', function($query) use ($request){
                    $query->select('i_akun_persediaan')->from('m_item')
                          ->where('i_code', $request->pbd_item)->first();
                  })->first();

          $akunBeban = DB::table('dk_akun')
                  ->where('ak_id', function($query) use ($request){
                    $query->select('i_akun_beban')->from('m_item')
                          ->where('i_code', $request->pbd_item)->first();
                  })->first();

          if(!$akunBeban || !$akunPersediaan){
            return response()->json([
              'status' => 'gagal. Permbukuan Pada Jurnal Tidak Bisa Dilakukan, Harap Segera Hubungi Developer.',
            ]);
          }

          $detail = [];

          $detail[$akunBeban->ak_id] = [
              'jrdt_akun'   => $akunBeban->ak_id,
              'jrdt_value'  => str_replace('-', '', $hpp),
              'jrdt_dk'   => 'D'
          ];

          $detail[$akunPersediaan->ak_id] = [
              'jrdt_akun'   => $akunPersediaan->ak_id,
              'jrdt_value'  => str_replace('-', '', $hpp),
              'jrdt_dk'   => 'K'
          ];

          keuangan::jurnal()->addJurnal($detail, Carbon::parse($request->pb_date)->format('Y-m-d'), $request->pb_code, 'Pengeluaran Barang - '.$request->pbd_receive_from, 'MM', modulSetting()['onLogin'], true);

          // return json_encode($detail);

          // return $hpp;

        // Selesai Dirga

          logController::inputlog('Pengeluaran Barang', 'Insert', $request->pb_code);

          DB::commit();
          return response()->json([
            'status' => 'berhasil'
          ]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
          'status' => 'gagal '.$e
        ]);
      }

    }
    public function print_kartu_stok(Request $request)
    {
      if (!mMember::akses('PENGELUARAN BARANG', 'print')) {
        return redirect('error-404');
      }
        $request->id = decrypt($request->id);
        $data = DB::table('m_item')
                  ->leftjoin('d_unit', 'u_id', '=', 'i_unit')
                  ->leftjoin('i_stock_mutasi', 'sm_item', '=', 'i_code')
                  ->where('i_code', $request->id)
                  ->get();


        $cardno = DB::table('d_pengeluaran_barang_dt')
                    ->where('pbd_item', $request->id)
                    ->select('pbd_code')
                    ->first();

                    logController::inputlog('Pengeluaran Barang', 'Print', $request->id);

        return view('inventory/barangkeluar/print_kartu_stok', compact('data', 'cardno'));
    }
    public function barcode()
    {
    	return view('inventory/barcode/barcode');
    }
    public function maintenance()
    {
    	return view('inventory/maintenance/maintenance');
    }
    public function opname()
    {
    	return view('inventory/opname/opname');
    }
    public function suratpinjambarang()
    {
    	return view('inventory/suratpinjambarang/suratpinjambarang');
    }
}
