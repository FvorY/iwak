<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\mMember;
class ASSController extends Controller
{
    public function tandaterima()
    {
    	return view('aftersales/tandaterima/tandaterima');
    }
    public function proses_tandaterima()
    {
        return view('aftersales/tandaterima/proses_tandaterima');
    }
    public function repairreport()
    {
    	return view('aftersales/repairreport/repairreport');
    }
    public function repairorder()
    {
    	return view('aftersales/repairorder/repairorder');
    }
    public function rencanatindakan()
    {
    	return view('aftersales/rencanatindakan/rencanatindakan');
    }
    public function kebutuhanbiaya()
    {
    	return view('aftersales/kebutuhanbiaya/kebutuhanbiaya');
    }
}
