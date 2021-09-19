<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

class laporanController extends Controller
{
    public function get(){
      $data = DB::table('d_quotation')
                  ->leftjoin('d_sales_order', 'so_ref', '=', 'q_nota')
                  ->leftjoin('d_work_order', 'wo_ref', '=', 'q_nota')
                  ->leftjoin('d_delivery', 'd_so', '=', 'so_nota')
                  ->where('so_active', 'Y')
                  ->orderBy('so_date', 'DESC')
                  ->get();

      return view('laporan.index', compact('data'));
    }
}
