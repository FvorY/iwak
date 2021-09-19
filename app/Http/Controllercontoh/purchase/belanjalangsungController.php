<?php

namespace App\Http\Controllers\purchase;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Barang;
use Yajra\Datatables\Datatables;
use DB;
use Carbon\Carbon;
use App\mMember;
use App\Http\Controllers\logController;
class belanjalangsungController extends Controller
{
   public function belanjalangsung()
    {
      if (!mMember::akses('BELANJA LANGSUNG', 'aktif')) {
        return redirect('error-404');
      }
        $data = DB::table('d_belanja_langsung')
                ->join('m_vendor', 's_kode', '=', 'dbl_vendor')
                ->select('dbl_id', 'dbl_code', 's_company', 's_name', 'dbl_total_net')
                ->get();

        $custom = DB::table('d_belanja_langsung_custom')
                    ->get();

        return view('purchase/belanjalangsung/belanjalangsung', compact('data', 'custom'));
    }
    public function tambah_belanjalangsung(Request $request)
    {
      if (!mMember::akses('BELANJA LANGSUNG', 'tambah')) {
        return redirect('error-404');
      }
        $vendor = DB::table('m_vendor')->get();

        $item = DB::table('m_item')->leftjoin('i_stock_gudang','i_stock_gudang.sg_iditem','=','m_item.i_Code')->get();

        return view('purchase/belanjalangsung/tambah',compact('vendor','item'));
    }

    public function edit(Request $request)
    {
      if (!mMember::akses('BELANJA LANGSUNG', 'ubah')) {
        return redirect('error-404');
      }
        $id = $request->id;

        $vendor = DB::table('m_vendor')->get();

        $item = DB::table('m_item')->leftjoin('i_stock_gudang','i_stock_gudang.sg_iditem','=','m_item.i_Code')->get();

        $dbl = DB::table('d_belanja_langsung')
                ->join('m_vendor', 's_kode', '=', 'dbl_vendor')
                ->where('dbl_id', $request->id)
                ->get();

        $dbldt = DB::table('d_belanja_langsung_dt')
                  ->where('dbldt_ref', $dbl[0]->dbl_code)
                  ->join('m_item', 'i_code', '=', 'dbldt_item')
                  ->join('d_unit', 'u_id', '=', 'i_unit')
                  ->get();

        return view('purchase/belanjalangsung/edit',compact('dbldt','dbl','vendor','item','id'));

    }


    public function hub_suplier(Request $request)
    {

    }

    public function simpan(Request $request){
      if (!mMember::akses('BELANJA LANGSUNG', 'tambah')) {
        return redirect('error-404');
      }
      DB::beginTransaction();
      try {
        $id = DB::table('d_belanja_langsung')
              ->max('dbl_id');

        if ($id < 0) {
          $id = 0;
        }

        $kode = DB::table('d_belanja_langsung')->max('dbl_id');
            if ($kode == null) {
                $kode = 1;
            }else{
                $kode += 1;
            }

        $index = str_pad($kode, 3, '0', STR_PAD_LEFT);
        $date = date('my');
        $nota = 'BL-'.$index.'/'.$request->dbl_vendor.'/'.$date;

        $request->po_subtotal = str_replace('.','',$request->po_subtotal);
        $request->dbldt_tax = str_replace('.','',$request->dbldt_tax);
        $request->total_net = str_replace('.','',$request->total_net);

        $request->po_subtotal = str_replace(',','',$request->po_subtotal);
        $request->dbldt_tax = str_replace(',','',$request->dbldt_tax);
        $request->total_net = str_replace(',','',$request->total_net);

        DB::table('d_belanja_langsung')
          ->insert([
            'dbl_id' => $id + 1,
            'dbl_code' => $nota,
            'dbl_vendor' => $request->dbl_vendor,
            'dbl_date' => Carbon::parse($request->dbl_date)->format('Y-m-d'),
            'dbl_ship_to' => $request->dbl_ship_to,
            'dbl_ship_method' => $request->dbl_shippinethod,
            'dbl_ship_term' => $request->dbl_shipp_term,
            'dbl_delivery_date' => Carbon::parse($request->dbl_shipp_date)->format('Y-m-d'),
            'dbl_created_at' => Carbon::now('Asia/Jakarta'),
            'dbl_total' => (double)$request->po_subtotal,
            'dbl_tax' => (double)$request->dbldt_tax,
            'dbl_total_net' => (double)$request->total_net
          ]);

          for ($i=0; $i < count($request->kode); $i++) {
            $iddt = DB::table('d_belanja_langsung_dt')
                    ->max('dbldt_id');

            if ($iddt < 0) {
              $iddt = 0;
            }

            if ($request->tax[0] == null) {
              DB::table('d_belanja_langsung_dt')
                ->insert([
                  'dbldt_id' => $iddt + 1,
                  'dbldt_ref' => $nota,
                  'dbldt_item' => $request->kode[$i],
                  'dbldt_qty' => (double)$request->qty[$i],
                  'dbldt_unit_price' => (double)$request->price[$i],
                  'dbldt_line_total' => (double)$request->total[$i],
                  'dbldt_created_at' => Carbon::now('Asia/Jakarta'),
                ]);

                $data = DB::table('i_stock_gudang')
                        ->Where('sg_iditem', $request->kode[$i])
                        ->get();

                $datacount = DB::table('i_stock_gudang')
                        ->Where('sg_iditem', $request->kode[$i])
                        ->count();

                if ($datacount == 0) {
                  $id = DB::table('i_stock_gudang')
                        ->max('sg_id');

                  if ($id < 0) {
                    $id = 0;
                  }

                  DB::table('i_stock_gudang')
                    ->insert([
                      'sg_id' => $id + 1,
                      'sg_iditem' => $request->kode[$i],
                      'sg_qty' => $request->qty[$i],
                      'sg_harga' => (double)$request->total[$i],
                      'sg_insert' => Carbon::now('Asia/Jakarta')
                    ]);

                } else {
                  DB::table('i_stock_gudang')
                    ->where('sg_iditem', $data[0]->sg_iditem)
                    ->update([
                      'sg_qty' => $request->qty[$i] + $data[0]->sg_qty,
                      'sg_harga' => $request->qty[$i] * (double)$request->price[$i],
                      'sg_update' => Carbon::now('Asia/Jakarta')
                    ]);
                }

                $iddetail = DB::table('i_stock_mutasi')
                      ->where('sm_id', $id + 1)
                      ->max('sm_iddetail');

                if ($iddetail < 0) {
                  $iddetail = 0;
                }

                DB::table('i_stock_mutasi')
                  ->insert([
                    'sm_id' => $id + 1,
                    'sm_iddetail' => $iddetail + 1,
                    'sm_item' => $request->kode[$i],
                    'sm_hpp' => (double)$request->price[$i],
                    'sm_qty' => $request->qty[$i],
                    'sm_use' => 0,
                    'sm_sisa' => $request->qty[$i],
                    'sm_description' => 'BELANJA LANGSUNG',
                    'sm_ref' => $nota,
                    'sm_insert' => Carbon::now('Asia/Jakarta')
                  ]);
            } else {
              if ($request->tax[$i] != 'undefined') {
                DB::table('d_belanja_langsung_dt')
                  ->insert([
                    'dbldt_id' => $iddt + 1,
                    'dbldt_ref' => $nota,
                    'dbldt_item' => $request->kode[$i],
                    'dbldt_qty' => (double)$request->qty[$i],
                    'dbldt_unit_price' => (double)$request->price[$i],
                    'dbldt_line_total' => (double)$request->total[$i],
                    'dbldt_ppn' => (double)$request->tax[$i],
                    'dbldt_created_at' => Carbon::now('Asia/Jakarta'),
                  ]);

                  $data = DB::table('i_stock_gudang')
                          ->Where('sg_iditem', $request->kode[$i])
                          ->get();

                  $datacount = DB::table('i_stock_gudang')
                          ->Where('sg_iditem', $request->kode[$i])
                          ->count();

                  if ($datacount == 0) {
                    $id = DB::table('i_stock_gudang')
                          ->max('sg_id');

                    if ($id < 0) {
                      $id = 0;
                    }

                    DB::table('i_stock_gudang')
                      ->insert([
                        'sg_id' => $id + 1,
                        'sg_iditem' => $request->kode[$i],
                        'sg_qty' => $request->qty[$i],
                        'sg_harga' => (double)$request->total[$i],
                        'sg_insert' => Carbon::now('Asia/Jakarta')
                      ]);

                  } else {
                    DB::table('i_stock_gudang')
                      ->where('sg_iditem', $data[0]->sg_iditem)
                      ->update([
                        'sg_qty' => $request->qty[$i] + $data[0]->sg_qty,
                        'sg_harga' => $request->qty[$i] * (double)$request->price[$i],
                        'sg_update' => Carbon::now('Asia/Jakarta')
                      ]);
                  }

                  $iddetail = DB::table('i_stock_mutasi')
                        ->where('sm_id', $id + 1)
                        ->max('sm_iddetail');

                  if ($iddetail < 0) {
                    $iddetail = 0;
                  }

                  DB::table('i_stock_mutasi')
                    ->insert([
                      'sm_id' => $id + 1,
                      'sm_iddetail' => $iddetail + 1,
                      'sm_item' => $request->kode[$i],
                      'sm_hpp' => (double)$request->price[$i],
                      'sm_qty' => $request->qty[$i],
                      'sm_use' => 0,
                      'sm_sisa' => $request->qty[$i],
                      'sm_description' => 'BELANJA LANGSUNG',
                      'sm_ref' => $nota,
                      'sm_insert' => Carbon::now('Asia/Jakarta')
                    ]);
              } else {

                DB::table('d_belanja_langsung_dt')
                  ->insert([
                    'dbldt_id' => $iddt + 1,
                    'dbldt_ref' => $nota,
                    'dbldt_item' => $request->kode[$i],
                    'dbldt_qty' => $request->qty[$i],
                    'dbldt_unit_price' => (double)$request->price[$i],
                    'dbldt_line_total' => (double)$request->total[$i],
                    'dbldt_created_at' => Carbon::now('Asia/Jakarta'),
                  ]);

                  $data = DB::table('i_stock_gudang')
                          ->Where('sg_iditem', $request->kode[$i])
                          ->get();

                  $datacount = DB::table('i_stock_gudang')
                          ->Where('sg_iditem', $request->kode[$i])
                          ->count();

                  if ($datacount == 0) {
                    $id = DB::table('i_stock_gudang')
                          ->max('sg_id');

                    if ($id < 0) {
                      $id = 0;
                    }

                    DB::table('i_stock_gudang')
                      ->insert([
                        'sg_id' => $id + 1,
                        'sg_iditem' => $request->kode[$i],
                        'sg_qty' => $request->qty[$i],
                        'sg_harga' => (double)$request->total[$i],
                        'sg_insert' => Carbon::now('Asia/Jakarta')
                      ]);

                  } else {
                    DB::table('i_stock_gudang')
                      ->where('sg_iditem', $data[0]->sg_iditem)
                      ->update([
                        'sg_qty' => $request->qty[$i] + $data[0]->sg_qty,
                        'sg_harga' => $request->qty[$i] * (double)$request->price[$i],
                        'sg_update' => Carbon::now('Asia/Jakarta')
                      ]);
                  }

                  $iddetail = DB::table('i_stock_mutasi')
                        ->where('sm_id', $id + 1)
                        ->max('sm_iddetail');

                  if ($iddetail < 0) {
                    $iddetail = 0;
                  }

                  DB::table('i_stock_mutasi')
                    ->insert([
                      'sm_id' => $id + 1,
                      'sm_iddetail' => $iddetail + 1,
                      'sm_item' => $request->kode[$i],
                      'sm_hpp' => (double)$request->price[$i],
                      'sm_qty' => $request->qty[$i],
                      'sm_use' => 0,
                      'sm_sisa' => $request->qty[$i],
                      'sm_description' => 'BELANJA LANGSUNG',
                      'sm_ref' => $nota,
                      'sm_insert' => Carbon::now('Asia/Jakarta')
                    ]);
              }
            }

          }

          logController::inputlog('Belanja Langsung', 'Insert', $nota);

        DB::commit();
        return response()->json([
          'status' => 'berhasil'
        ]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
          'status' => 'gagal'
        ]);
      }
    }

    public function hapus(Request $request){
      if (!mMember::akses('BELANJA LANGSUNG', 'hapus')) {
        return redirect('error-404');
      }
      DB::beginTransaction();
      try {

        $data = DB::table('d_belanja_langsung')
                  ->where('dbl_id', $request->id)
                  ->get();

        $detail = DB::table('d_belanja_langsung_dt')
                  ->where('dbldt_ref', $data[0]->dbl_code)
                  ->get();

        DB::table('d_belanja_langsung')
          ->where('dbl_id', $request->id)
          ->delete();

        DB::table('d_belanja_langsung_dt')
          ->where('dbldt_ref', $data[0]->dbl_code)
          ->delete();

        DB::table('i_stock_mutasi')
          ->where('sm_description', 'BELANJA LANGSUNG')
          ->where('sm_ref', $data[0]->dbl_code)
          ->delete();

        for ($i=0; $i < count($detail); $i++) {
          $stock = DB::table('i_stock_gudang')
            ->where('sg_iditem', $detail[0]->dbldt_item)
            ->get();

          if ($stock[0]->sg_qty - $detail[$i]->dbldt_qty == 0) {
            DB::table('i_stock_gudang')
              ->where('sg_iditem', $detail[0]->dbldt_item)
              ->delete();
          } else {
            DB::table('i_stock_gudang')
              ->where('sg_iditem', $detail[0]->dbldt_item)
              ->update([
                'sg_qty' => $stock[0]->sg_qty - $detail[$i]->dbldt_qty,
                'sg_harga' => $stock[0]->sg_qty * $detail[$i]->dbldt_unit_price
              ]);
          }
        }

        logController::inputlog('Belanja Langsung', 'Hapus', $data[0]->dbl_code);

        DB::commit();
        return response()->json([
          'status' => 'berhasil'
        ]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
          'status' => 'gagal'
        ]);
      }

    }

    public function detail(Request $request){
      $data = DB::table('d_belanja_langsung')
              ->join('d_belanja_langsung_dt', 'dbldt_ref', '=', 'dbl_code')
              ->join('m_item', 'i_code', '=', 'dbldt_item')
              ->join('d_unit', 'u_id', '=', 'i_unit')
              ->where('dbl_id', $request->id)
              ->get();

      return response()->json($data);
    }

    public function update(Request $request){
      if (!mMember::akses('BELANJA LANGSUNG', 'ubah')) {
        return redirect('error-404');
      }
      DB::beginTransaction();
      try {

        $data = DB::table('d_belanja_langsung')
                  ->where('dbl_id', $request->id)
                  ->get();

        DB::table('d_belanja_langsung')
          ->where('dbl_id', $request->id)
          ->delete();

        DB::table('d_belanja_langsung_dt')
          ->where('dbldt_ref', $data[0]->dbl_code)
          ->delete();

        DB::table('i_stock_mutasi')
          ->where('sm_description', 'BELANJA LANGSUNG')
          ->where('sm_ref', $data[0]->dbl_code)
          ->delete();

        DB::table('i_stock_gudang')
          ->where('sg_iditem', $data[0]->dbl_code)
          ->delete();

        $id = $request->id;

        if ($id < 0) {
          $id = 0;
        }

        $nota = $data[0]->dbl_code;

        $request->po_subtotal = str_replace('.','',$request->po_subtotal);
        $request->dbldt_tax = str_replace('.','',$request->dbldt_tax);
        $request->total_net = str_replace('.','',$request->total_net);

        DB::table('d_belanja_langsung')
          ->insert([
            'dbl_id' => $id,
            'dbl_code' => $nota,
            'dbl_vendor' => $request->dbl_vendor,
            'dbl_date' => Carbon::parse($request->dbl_date)->format('Y-m-d'),
            'dbl_ship_to' => $request->dbl_ship_to,
            'dbl_ship_method' => $request->dbl_shippinethod,
            'dbl_ship_term' => $request->dbl_shipp_term,
            'dbl_delivery_date' => Carbon::parse($request->dbl_shipp_date)->format('Y-m-d'),
            'dbl_created_at' => Carbon::now('Asia/Jakarta'),
            'dbl_total' => $request->po_subtotal,
            'dbl_tax' => $request->dbldt_tax,
            'dbl_total_net' => $request->total_net
          ]);

          for ($i=0; $i < count($request->kode); $i++) {
            $iddt = DB::table('d_belanja_langsung_dt')
                    ->max('dbldt_id');

            if ($iddt < 0) {
              $iddt = 0;
            }

            if ($request->tax[0] == null) {
              DB::table('d_belanja_langsung_dt')
                ->insert([
                  'dbldt_id' => $iddt + 1,
                  'dbldt_ref' => $nota,
                  'dbldt_item' => $request->kode[$i],
                  'dbldt_qty' => $request->qty[$i],
                  'dbldt_unit_price' => $request->price[$i],
                  'dbldt_line_total' => $request->total[$i],
                  'dbldt_created_at' => Carbon::now('Asia/Jakarta'),
                ]);

                $id = DB::table('i_stock_mutasi')
                      ->max('sm_id');

                  if ($id < 0) {
                    $id = 0;
                  }

                $iddetail = DB::table('i_stock_mutasi')
                      ->where('sm_id', $id + 1)
                      ->max('sm_iddetail');

                if ($iddetail < 0) {
                  $iddetail = 0;
                }

                DB::table('i_stock_mutasi')
                  ->insert([
                    'sm_id' => $id + 1,
                    'sm_iddetail' => $iddetail + 1,
                    'sm_item' => $request->kode[$i],
                    'sm_hpp' => (double)$request->price[$i],
                    'sm_qty' => $request->qty[$i],
                    'sm_use' => 0,
                    'sm_sisa' => $request->qty[$i],
                    'sm_description' => 'BELANJA LANGSUNG',
                    'sm_ref' => $nota,
                    'sm_insert' => Carbon::now('Asia/Jakarta')
                  ]);
            } else {
              if ($request->tax[$i] != 'undefined') {
                DB::table('d_belanja_langsung_dt')
                  ->insert([
                    'dbldt_id' => $iddt + 1,
                    'dbldt_ref' => $nota,
                    'dbldt_item' => $request->kode[$i],
                    'dbldt_qty' => $request->qty[$i],
                    'dbldt_unit_price' => $request->price[$i],
                    'dbldt_line_total' => $request->total[$i],
                    'dbldt_ppn' => $request->tax[$i],
                    'dbldt_created_at' => Carbon::now('Asia/Jakarta'),
                  ]);

                  $id = DB::table('i_stock_mutasi')
                        ->max('sm_id');

                    if ($id < 0) {
                      $id = 0;
                    }

                  $iddetail = DB::table('i_stock_mutasi')
                        ->where('sm_id', $id + 1)
                        ->max('sm_iddetail');

                  if ($iddetail < 0) {
                    $iddetail = 0;
                  }

                  DB::table('i_stock_mutasi')
                    ->insert([
                      'sm_id' => $id + 1,
                      'sm_iddetail' => $iddetail + 1,
                      'sm_item' => $request->kode[$i],
                      'sm_hpp' => (double)$request->price[$i],
                      'sm_qty' => $request->qty[$i],
                      'sm_use' => 0,
                      'sm_sisa' => $request->qty[$i],
                      'sm_description' => 'BELANJA LANGSUNG',
                      'sm_ref' => $nota,
                      'sm_insert' => Carbon::now('Asia/Jakarta')
                    ]);
              } else {
                DB::table('d_belanja_langsung_dt')
                  ->insert([
                    'dbldt_id' => $iddt + 1,
                    'dbldt_ref' => $nota,
                    'dbldt_item' => $request->kode[$i],
                    'dbldt_qty' => $request->qty[$i],
                    'dbldt_unit_price' => $request->price[$i],
                    'dbldt_line_total' => $request->total[$i],
                    'dbldt_created_at' => Carbon::now('Asia/Jakarta'),
                  ]);

                  $id = DB::table('i_stock_mutasi')
                        ->max('sm_id');

                    if ($id < 0) {
                      $id = 0;
                    }

                  $iddetail = DB::table('i_stock_mutasi')
                        ->where('sm_id', $id + 1)
                        ->max('sm_iddetail');

                  if ($iddetail < 0) {
                    $iddetail = 0;
                  }

                  DB::table('i_stock_mutasi')
                    ->insert([
                      'sm_id' => $id + 1,
                      'sm_iddetail' => $iddetail + 1,
                      'sm_item' => $request->kode[$i],
                      'sm_hpp' => (double)$request->price[$i],
                      'sm_qty' => $request->qty[$i],
                      'sm_use' => 0,
                      'sm_sisa' => $request->qty[$i],
                      'sm_description' => 'BELANJA LANGSUNG',
                      'sm_ref' => $nota,
                      'sm_insert' => Carbon::now('Asia/Jakarta')
                    ]);
              }
            }
            $data = DB::table('i_stock_gudang')
                    ->Where('sg_iditem', $request->kode[$i])
                    ->get();

            $datacount = DB::table('i_stock_gudang')
                    ->Where('sg_iditem', $request->kode[$i])
                    ->count();

            if ($datacount == 0) {
              $id = DB::table('i_stock_gudang')
                    ->max('sg_id');

              if ($id < 0) {
                $id = 0;
              }

              DB::table('i_stock_gudang')
                ->insert([
                  'sg_id' => $id + 1,
                  'sg_iditem' => $request->kode[$i],
                  'sg_qty' => $request->qty[$i],
                  'sg_harga' => (double)$request->total[$i],
                  'sg_insert' => Carbon::now('Asia/Jakarta')
                ]);

            } else {
              DB::table('i_stock_gudang')
                ->where('sg_iditem', $data[0]->sg_iditem)
                ->update([
                  'sg_qty' => $request->qty[$i] + $data[0]->sg_qty,
                  'sg_harga' => $request->qty[$i] * (double)$request->price[$i],
                  'sg_update' => Carbon::now('Asia/Jakarta')
                ]);
            }
          }

          logController::inputlog('Belanja Langsung', 'Update', $nota);

        DB::commit();
        return response()->json([
          'status' => 'berhasil'
        ]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
          'status' => 'gagal'
        ]);
      }
    }

    public function custom(){
      return view('purchase.belanjalangsung.custom');
    }

    public function customsimpan(Request $request){
      if (!mMember::akses('BELANJA LANGSUNG', 'tambah')) {
        return redirect('error-404');
      }
      DB::beginTransaction();
      try {

        $idcustom = DB::table('d_belanja_langsung_custom')
                      ->max("blc_id");

        if ($idcustom < 0) {
          $idcustom = 0;
        }

        $index = str_pad($idcustom + 1, 3, '0', STR_PAD_LEFT);
        $date = date('my');
        $nota = 'BLC-'.$index.'/'.$date;

        $request->po_subtotal = str_replace('.','', $request->po_subtotal);
        $request->dbldt_tax = str_replace('.','', $request->dbldt_tax);
        $request->total_net = str_replace('.','', $request->total_net);

        DB::table('d_belanja_langsung_custom')
            ->insert([
              'blc_id' => $idcustom + 1,
              'blc_code' => $nota,
              'blc_shop_name' => strtoupper($request->storename),
              'blc_date' => Carbon::parse($request->dbl_date)->format('Y-m-d'),
              'blc_subtotal' => $request->po_subtotal,
              'blc_tax' => $request->dbldt_tax,
              'blc_totalnet' => $request->total_net,
              'blc_insert' => Carbon::now('Asia/Jakarta')
            ]);

        for ($i=0; $i < count($request->nama); $i++) {
          $idcustomdt = DB::table('d_belanja_langsung_custom_dt')
                          ->max('blcd_id');

          if ($idcustomdt < 0) {
            $idcustomdt = 0;
          }


          $price = str_replace('.','',$request->price[$i]);
          $total = str_replace('.','',$request->total[$i]);

          DB::table('d_belanja_langsung_custom_dt')
              ->insert([
                'blcd_id' => $idcustomdt + 1,
                'blcd_ref' => $nota,
                'blcd_item' => strtoupper($request->nama[$i]),
                'blcd_qty' => $request->qty[$i],
                'blcd_price' => $price,
                'blcd_total' => $total,
                'blcd_insert' => Carbon::now('Asia/Jakarta')
              ]);

              $checkitem = DB::table('d_item_custom')
                              ->where('ic_name', strtoupper($request->nama[$i]))
                              ->get();

              if (empty($checkitem)) {
                $itemid = DB::table('d_item_custom')
                            ->max('ic_id');

                $price = str_replace('.','',$request->price[$i]);

                DB::table('d_item_custom')
                  ->insert([
                    'ic_id' => $itemid + 1,
                    'ic_name' => strtoupper($request->nama[$i]),
                    'ic_price' => $price,
                    'ic_insert' => Carbon::now('Asia/Jakarta')
                  ]);
              }
        }

        logController::inputlog('Belanja Langsung Custom', 'Insert', $nota);

        DB::commit();
        return response()->json([
          'status' => 'berhasil'
        ]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
          'status' => 'gagal'
        ]);
      }

    }

    public function autocomplete(Request $request){
      $keyword = $request->term;

      $data = DB::table('d_item_custom')
                ->where('ic_name', 'LIKE', '%'.strtoupper($keyword).'%')
                ->get();

                $results = [];

            if ($data == null) {
                $results[] = ['id' => null, 'label' => 'Tidak ditemukan data terkait'];
            } else {

                foreach ($data as $query) {
                    $results[] = ['id' => $query->ic_price, 'label' => $query->ic_name];
                }
            }

            return response()->json($results);
    }

    public function customhapus(Request $request){
      if (!mMember::akses('BELANJA LANGSUNG', 'hapus')) {
        return redirect('error-404');
      }
      DB::beginTransaction();
      try {

        $data = DB::table('d_belanja_langsung_custom')
                  ->where('blc_id', $request->id)
                  ->get();

        DB::table('d_belanja_langsung_custom')
              ->where('blc_id', $request->id)
              ->delete();

        DB::table('d_belanja_langsung_custom_dt')
              ->where('blcd_ref', $data[0]->blc_code)
              ->delete();

              logController::inputlog('Belanja Langsung Custom', 'Hapus', $data[0]->dbl_code);

        DB::commit();
        return response()->json([
          'status' => 'berhasil'
        ]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
          'status' => 'gagal'
        ]);
      }

    }

    public function customedit(Request $request){
      if (!mMember::akses('BELANJA LANGSUNG', 'ubah')) {
        return redirect('error-404');
      }
      $id = $request->id;

      $custom = DB::table('d_belanja_langsung_custom')
                ->where('blc_id', $request->id)
                ->get();

      $customdt = DB::table('d_belanja_langsung_custom_dt')
                    ->where('blcd_ref', $custom[0]->blc_code)
                    ->get();

      return view('purchase.belanjalangsung.customedit', compact('custom', 'customdt', 'id'));
    }

    public function customupdate(Request $request){
      if (!mMember::akses('BELANJA LANGSUNG', 'ubah')) {
        return redirect('error-404');
      }
      DB::beginTransaction();
      try {

        $data = DB::table('d_belanja_langsung_custom')
                  ->where('blc_id', $request->id)
                  ->get();

        DB::table('d_belanja_langsung_custom')
              ->where('blc_id', $request->id)
              ->delete();

        DB::table('d_belanja_langsung_custom_dt')
              ->where('blcd_ref', $data[0]->blc_code)
              ->delete();

        $index = str_pad($request->id + 1, 3, '0', STR_PAD_LEFT);
        $date = date('my');
        $nota = 'BLC-'.$index.'/'.$date;

        $request->po_subtotal = str_replace('.','', $request->po_subtotal);
        $request->dbldt_tax = str_replace('.','', $request->dbldt_tax);
        $request->total_net = str_replace('.','', $request->total_net);

        DB::table('d_belanja_langsung_custom')
            ->insert([
              'blc_id' => $request->id,
              'blc_code' => $nota,
              'blc_shop_name' => strtoupper($request->storename),
              'blc_date' => Carbon::parse($request->dbl_date)->format('Y-m-d'),
              'blc_subtotal' => $request->po_subtotal,
              'blc_tax' => $request->dbldt_tax,
              'blc_totalnet' => $request->total_net,
              'blc_insert' => Carbon::now('Asia/Jakarta')
            ]);

        for ($i=0; $i < count($request->nama); $i++) {
          $idcustomdt = DB::table('d_belanja_langsung_custom_dt')
                          ->max('blcd_id');

          if ($idcustomdt < 0) {
            $idcustomdt = 0;
          }


          $price = str_replace('.','',$request->price[$i]);
          $total = str_replace('.','',$request->total[$i]);

          DB::table('d_belanja_langsung_custom_dt')
              ->insert([
                'blcd_id' => $idcustomdt + 1,
                'blcd_ref' => $nota,
                'blcd_item' => strtoupper($request->nama[$i]),
                'blcd_qty' => $request->qty[$i],
                'blcd_price' => $price,
                'blcd_total' => $total,
                'blcd_insert' => Carbon::now('Asia/Jakarta')
              ]);

              $checkitem = DB::table('d_item_custom')
                              ->where('ic_name', strtoupper($request->nama[$i]))
                              ->get();

              if (empty($checkitem)) {
                $itemid = DB::table('d_item_custom')
                            ->max('ic_id');

                $price = str_replace('.','',$request->price[$i]);

                DB::table('d_item_custom')
                  ->insert([
                    'ic_id' => $itemid + 1,
                    'ic_name' => strtoupper($request->nama[$i]),
                    'ic_price' => $price,
                    'ic_insert' => Carbon::now('Asia/Jakarta')
                  ]);
              }
        }

        logController::inputlog('Belanja Langsung Custom', 'Update', $nota);

        DB::commit();
        return response()->json([
          'status' => 'berhasil'
        ]);
      } catch (\Exception $e) {
        DB::rollback();
        return response()->json([
          'status' => 'gagal'
        ]);
      }
    }
}
