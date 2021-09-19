<?php

namespace App\Http\Controllers\inventory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use DB;
use Carbon\carbon;
use App\mMember;
use App\Http\Controllers\logController;
class stock_opnameController extends Controller
{

	 public function stockopname()
	 {
		 if (!mMember::akses('STOCK OPNAME', 'aktif')) {
			 return redirect('error-404');
		 }
	 	 	$data = DB::table('i_stock_opname')
								->get();

    	return view('inventory/opname/opname', compact('data'));
	 }
	 public function detail(Request $request){
		 $data = DB::table('i_stock_opname')
		 					->where('so_id', $request->id)
							->join('i_stock_opname_dt', 'sodt_code', '=', 'so_code')
							->join('m_item', 'i_code', '=', 'sodt_item')
							->get();

		return response()->json($data);
	 }
	 public function datatable_stockgudang()
	 {
      $list = DB::select("SELECT * from i_stock_gudang left join m_item on m_item.i_code = i_stock_gudang.sg_iditem");
          // return $list;
      $data = collect($list);

      return Datatables::of($data)

              ->addColumn('detail', function ($data) {
                        return '<button data-toggle="modal" onclick="detail(this)"  class="btn btn-outline-primary btn-sm">Detail</button>';
              })
              ->rawColumns(['aksi','detail','confirmed','status'])
          ->make(true);
	 }
   public function create_stockopname(Request $request)
   {
   	   $kode = DB::table('i_stock_opname')->max('so_id');
   	   if ($kode == null) {
   	   	$kode = 1;
   	   }else{
   	   	$kode += 1;
   	   }
	   $index = str_pad($kode, 3, '0', STR_PAD_LEFT);
       $date = date('my');
   	   $nota = 'SOP-'.$index.'/'.$date;

	   $data = DB::table('i_stock_gudang')->leftjoin('m_item','m_item.i_code','=','i_stock_gudang.sg_iditem')->get();
   	   $item = DB::table('m_item')->get();
       return view('inventory/opname/create_opname',compact('item','data','nota'));
   }
   public function cari_stockopname(Request $request)
   {
   	  // dd($request->all());
	   	if ($request->id == 'all' ) {
	   	  	$data = DB::table('i_stock_gudang')->leftjoin('m_item','m_item.i_code','=','i_stock_gudang.sg_iditem')->get();
		}else{
	   	  	$data = DB::table('i_stock_gudang')->leftjoin('m_item','m_item.i_code','=','i_stock_gudang.sg_iditem')->where('sg_iditem','=',$request->id)->get();
		}
		// return $data;

		return view('inventory/opname/cari_stockopname',compact('data'));

   }
   public function save_stockopname(Request $request)
   {
     DB::beginTransaction();
     try {

			 $idopname = DB::table('i_stock_opname')
										->max('so_id');

			if ($idopname == null) {
				$idopname = 1;
			} else {
				$idopname += 1;
			}

		 DB::table('i_stock_opname')
				->insert([
					'so_id' => $idopname,
					'so_code' => $request->so_code,
					'so_bulan' => Carbon::parse($request->so_date)->format('Y-m-d'),
					'so_status' => 'N',
					'so_create_at' => Carbon::now('Asia/Jakarta')
				]);

       for ($i=0; $i < count($request->so_real); $i++) {

          if ($request->so_real[$i] > 0) {

             $iddtopname = DB::table('i_stock_opname_dt')
                            ->max('sodt_id');

            if ($iddtopname == null) {
              $iddtopname = 1;
            } else {
              $iddtopname += 1;
            }

            DB::table('i_stock_opname_dt')
                ->insert([
                  'sodt_id' => $iddtopname,
                  'sodt_code' => $request->so_code,
                  'sodt_item' => $request->so_item[$i],
                  'sodt_system' => $request->so_system[$i],
                  'sodt_real' => $request->so_real[$i],
                  'sodt_status_item' => $request->so_status_item[$i],
                  'sodt_status_total' => $request->so_status_total[$i],
                  'sodt_description' => $request->so_description[$i],
                  'sodt_create_at' => Carbon::now('Asia/Jakarta')
                 ]);

          }
       }

			 logController::inputlog('Stock Opname', 'Insert', $request->so_code);

       DB::commit();
       return response()->json([
         'status' => 'berhasil'
       ]);
     } catch (\Exception $e) {
       DB::commit();
       return response()->json([
         'status' => 'gagal'
       ]);
     }


   }

   public function print_opname(Request $request){
		 $data = DB::table('i_stock_opname')
		 					->where('so_id', $request->id)
							->join('i_stock_opname_dt', 'sodt_code', '=', 'so_code')
							->join('m_item', 'i_code', '=', 'sodt_item')
							->get();

    return view('inventory.opname.print_opname', compact('data'));
   }

	 public function approve(Request $request){
		 DB::beginTransaction();
		 try {

			 $opname = DB::table('i_stock_opname')
			 							->where('so_id', $request->id)
										->first();

			 DB::table('i_stock_opname')
					 ->where('so_code', '=', $opname->so_code)
					 ->update([
						 'so_status' => 'Y'
					 ]);

			 $info = DB::table('i_stock_opname')
					 ->join('i_stock_opname_dt', 'sodt_code', '=', 'so_code')
					 ->where('so_code', '=', $opname->so_code)
					 ->get();

					for ($i=0; $i < count($info); $i++) {
						$item = $info[$i]->sodt_item;
						$qty_sistem = (int)$info[$i]->sodt_system;
						$qty_real = (int)$info[$i]->sodt_real;
						$sisa = (int)$info[$i]->sodt_system - (int)$info[$i]->sodt_real;
						$sekarang = Carbon::now('Asia/Jakarta');

						$mutasi = DB::table('i_stock_gudang')
								->join('i_stock_mutasi', 'sm_id', '=', 'sg_id')
								->select('i_stock_gudang.*', 'i_stock_mutasi.*', DB::raw('(sm_qty - sm_use) as sm_sisa'))
								->where('sg_iditem', '=', $item)
								->whereRaw("sm_description = 'PENERIMAAN BARANG' OR sm_description = 'INPUT STOCK MANUAL' OR sm_description = 'BELANJA LANGSUNG' OR sm_description = 'STOCK OPNAME LEBIH'")
								->where('sm_qty', '>', 'sm_use')
								->get();

								if ((int)$sisa > 0){
										//========= mengurangi stock
										for ($i = 0; $i < count($mutasi); $i++){
												if ((int)$mutasi[$i]->sm_sisa >= (int)$sisa){
														DB::table('i_stock_mutasi')
																->where('sm_id', '=', $mutasi[$i]->sm_id)
																->where('sm_iddetail', '=', $mutasi[$i]->sm_iddetail)
																->update([
																		'sm_use' => (int)$mutasi[$i]->sm_use + (int)$sisa,
																	 	'sm_sisa' => (int)$mutasi[$i]->sm_sisa - (int)$sisa,
																]);

														$getdetailid = DB::table('i_stock_mutasi')
																->where('sm_id', '=', $mutasi[$i]->sm_id)
																->max('sm_iddetail');

														$detailid = $getdetailid + 1;

														DB::table('i_stock_mutasi')
																->insert([
																		'sm_id' => $mutasi[$i]->sm_id,
																		'sm_iddetail' => $detailid,
																		'sm_item' => $mutasi[$i]->sm_item,
																		'sm_hpp' => $mutasi[$i]->sm_hpp,
																		'sm_description' => 'STOCK OPNAME KURANG',
																		'sm_qty' => (int)$sisa,
																		'sm_use' => '0',
																	 	'sm_sisa' => (int)$sisa,
																		'sm_ref' => $request->so_code,
																		'sm_deliveryorder' => $mutasi[$i]->sm_ref,
																	 	'sm_insert' => Carbon::now('Asia/Jakarta')
																]);

														DB::table('i_stock_gudang')
																->where('sg_id', '=', $mutasi[$i]->sg_id)
																->update([
																		'sg_qty' => DB::raw('sg_qty - ' . (int)$sisa)
																]);

														$sisa = 0;
														$i = count($mutasi);
												} elseif ((int)$mutasi[$i]->sm_sisa < (int)$sisa){
														$sisa = (int)$sisa - (int)$mutasi[$i]->sm_qty;

														DB::table('i_stock_mutasi')
																->where('sm_id', '=', $mutasi[$i]->sm_id)
																->where('sm_iddetail', '=', $mutasi[$i]->sm_iddetail)
																->update([
																		'sm_use' => (int)$mutasi[$i]->sm_qty,
																	 'sm_sisa' => 0,
																]);

														$getdetailid = DB::table('i_stock_mutasi')
																->where('sm_id', '=', (int)$mutasi[$i]->sm_id)
																->max('sm_iddetail');

														$detailid = $getdetailid + 1;

														DB::table('i_stock_mutasi')
																->insert([
																		'sm_id' => $mutasi[$i]->sm_id,
																		'sm_iddetail' => $detailid,
																		'sm_item' => $mutasi[$i]->sm_item,
																		'sm_hpp' => $mutasi[$i]->sm_hpp,
																		'sm_description' => 'STOCK OPNAME KURANG',
																		'sm_qty' => (int)$mutasi[$i]->sm_qty,
																		'sm_use' => '0',
																	 'sm_sisa' => (int)$mutasi[$i]->sm_qty,
																		'sm_ref' => $request->so_code,
																		'sm_deliveryorder' => $mutasi[$i]->sm_ref,
																	 'sm_insert' => Carbon::now('Asia/Jakarta')
																]);

														DB::table('i_stock_gudang')
																->where('sg_id', '=', $mutasi[$i]->sg_id)
																->update([
																		'sg_qty' => DB::raw('(sg_qty - ' . (int)$mutasi[$i]->sm_qty. ')')
																]);
												}
										}
								} elseif ($sisa < 0){
										//======== menambah stock
										$sisa = abs($sisa);
										$counter = count($mutasi) - 1;

										$getdetailid = DB::table('i_stock_mutasi')
												->where('sm_id', '=', $mutasi[0]->sm_id)
												->max('sm_iddetail');

										$detailid = $getdetailid + 1;

										DB::table('i_stock_mutasi')
												->insert([
														'sm_id' => $mutasi[0]->sm_id,
														'sm_iddetail' => $detailid,
														'sm_item' => $mutasi[0]->sm_item,
														'sm_hpp' => $mutasi[0]->sm_hpp,
														'sm_description' => 'STOCK OPNAME LEBIH',
														'sm_qty' => (int)$sisa,
														'sm_use' => '0',
														'sm_sisa' => (int)$sisa,
														'sm_ref' => $request->so_code,
														'sm_deliveryorder' => $mutasi[0]->sm_ref,
													 'sm_insert' => Carbon::now('Asia/Jakarta')
												]);

										DB::table('i_stock_gudang')
										->where('sg_id', (int)$mutasi[0]->sg_id)
												->update([
														'sg_qty' => DB::raw('(sg_qty + ' .(int)$sisa. ')')
												]);
								}
					}

			DB::commit();
			return response()->json([
				'status' => 'berhasil'
			]);
		 } catch (Exception $e) {
		 	DB::rollback();
			return response()->json([
				'status' => 'gagal'
			]);
		 }
	 }
}
