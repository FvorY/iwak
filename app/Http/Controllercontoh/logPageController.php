<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;

use App\mMember;

use App\Http\Controllers\logController;

class logPageController extends Controller
{
    public function index() {
      if (!mMember::akses('LOG ACTIVITY', 'aktif')) {
        return redirect('error-404');
      }

      $data = DB::table('d_log')
                ->get();

        return view('log.index', compact('data'));
    }
}
