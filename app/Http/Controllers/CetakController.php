<?php

namespace App\Http\Controllers;
use App\Models\Order;
use Illuminate\View\View;
use App\Models\Detiltransaksi;

class CetakController extends Controller
{
    //

    public function receipt():View
    {
        $id=session()->get('id');

        $transaksi=Transaksi::find($id);
        //dd($transaksi)
        $detiltransaksi=detiltransaksi::where('transaksi_id',$id)->get();
        return view('penjualan.receipt')->with([
            'datatransaksi'=>$transaksi,
            'datadetiltransaksi'=>$detiltransaksi
        ]);
    }
}
