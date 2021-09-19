<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\mMember;
use App\Http\Controllers\logController;
class FinanceController extends Controller
{
    public function reporting()
    {
      if (!mMember::akses('REPORTING', 'aktif')) {
        return redirect('error-404');
      }
    	return view('finance/reporting/reporting');
    }
    public function evaluating()
    {
      if (!mMember::akses('EVALUATING', 'aktif')) {
        return redirect('error-404');
      }
    	return view('finance/evaluating/evaluating');
    }
    public function costmanajemen()
    {
      if (!mMember::akses('COST MANAJEMEN', 'aktif')) {
        return redirect('error-404');
      }
    	return view('finance/costmanajemen/costmanajemen');
    }
    public function bookkeeping()
    {
      if (!mMember::akses('BOOKKEEPING', 'aktif')) {
        return redirect('error-404');
      }
    	return view('finance/bookkeeping/bookkeeping');
    }
    public function transaksi_kas()
    {
        return view('finance/bookkeeping/transaksi_kas');
    }
    public function transaksi_bank()
    {
        return view('finance/bookkeeping/transaksi_bank');
    }
    public function transaksi_memorial()
    {
        return view('finance/bookkeeping/transaksi_memorial');
    }
}
