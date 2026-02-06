<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Auth;

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
        $totalOffenseCount = DB::table('offense_list')->count();
        $userOffenseCount = DB::table('offense_list')
            ->where('driver_id', auth()->user()->id)
            ->count();
        return view('home', compact('totalOffenseCount', 'userOffenseCount'));
    }
     public function dashboard()
    {

        if (Auth::check()) {
            $totalOffenseCount = DB::table('offense_list')->count();
            $userOffenseCount = DB::table('offense_list')
                ->where('driver_id', auth()->user()->id)
                ->count();
            return view('welcome', compact('totalOffenseCount', 'userOffenseCount'));
        } else {
            return redirect()->route('login');
        }

    }

public function offenseListPdf($driver_id)
{
    $driver = DB::table('users')
        ->where('id', $driver_id)
        ->where('role', 'user')
        ->first();

    if (!$driver) {
        abort(404);
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

    $qrData = url('/verify-report/'.$driver->id);

    $qrUrl = "https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=" . urlencode($qrData);

    $qrImage = base64_encode(file_get_contents($qrUrl));

    $pdf = PDF::loadView('pdf.offense_list', compact(
        'driver',
        'offenses',
        'total_point',
        'total_fine',
        'qrImage'
    ))->setPaper('a4', 'portrait');
    
    return $pdf->stream('offense-list.pdf');
    }



}
