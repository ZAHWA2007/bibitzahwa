<?php

namespace App\Http\Controllers;

use App\Models\bibit;
use App\Models\Pelanggan;
use App\Models\User;
use App\Models\Transaksi;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function welcome()
    {
        $bibit = bibit::count();
        $pelanggan = Pelanggan::count();
        $user = User::count();
        $detiltransaksi = Transaksi::count();

        $tanggal_awal = date('Y-m-01');
        $tanggal_akhir = date('Y-m-d');

        $data_tanggal = array();
        $data_pendapatan = array();

        while (strtotime($tanggal_awal) <= strtotime($tanggal_akhir)) {
            $data_tanggal[] = (int) substr($tanggal_awal, 8, 2);

            $total_transaksi = Transaksi::where('created_at', 'LIKE', "%$tanggal_awal%")->sum('total');

            $pendapatan = $total_transaksi;
            $data_pendapatan[] += $pendapatan;

            $tanggal_awal = date('Y-m-d', strtotime("+1 day", strtotime($tanggal_awal)));
        }

        return view('welcome',[
            "pelanggan"=> $pelanggan,
            "bibit"=> $bibit,
            "user"=> $user,
            "detiltransaksi" => Transaksi::paginate(5),
            "title"=>"welcome"
        ]);
        
    }

    
}


