<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OfficerController extends Controller
{
    public function trafficOfficer()
    {
        return view('Officer.TraficOfficer');
    }
}
