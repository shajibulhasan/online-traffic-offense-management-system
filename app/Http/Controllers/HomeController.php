<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
     public function dashboard()
    {
        return view('welcome');
    }

public function offenseListPdf($driver_id)
{
    $driver = DB::table('users')
        ->where('id', $driver_id)
        ->where('role', 'user')
        ->first();

    if (!$driver) {
        abort(404, 'Driver not found');
    }

    $offenses = DB::table('offense_list')
        ->join('users as officers', 'offense_list.officer_id', '=', 'officers.id')
        ->where('offense_list.driver_id', $driver_id)
        ->select(
            'offense_list.*',
            'officers.name as officer_name'
        )
        ->orderBy('offense_list.created_at', 'desc')
        ->get();

    $total_point = $offenses->sum('point');
    $total_fine  = $offenses->sum('fine');

    $pdf = Pdf::loadView('pdf.offense_list', compact(
        'driver',
        'offenses',
        'total_point',
        'total_fine'
    ))->setPaper('a4', 'portrait');

    return $pdf->download('offense-list-'.$driver->id.'.pdf');
}


}
