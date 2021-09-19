<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\mMember;
use App\Http\Controllers\logController;
class AsetController extends Controller
{
    public function penyusutan()
    {
      if (!mMember::akses('PENYUSUTAN', 'aktif')) {
        return redirect('error-404');
      }
    	return view('manajemenaset/penyusutan/penyusutan');
    }
    public function history()
    {
      if (!mMember::akses('HISTORY', 'aktif')) {
        return redirect('error-404');
      }
    	return view('manajemenaset/history/history');
    }
    public function irventarisasi()
    {
      if (!mMember::akses('IRVENTARISASI', 'aktif')) {
        return redirect('error-404');
      }
    	return view('manajemenaset/irventarisasi/irventarisasi');
    }
}
