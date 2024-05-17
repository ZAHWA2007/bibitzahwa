<?php

namespace App\Livewire;


use App\Models\Transaksi;
use App\Models\Detiltransaksi;
use App\Models\Bibit;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Livewire\Component;

class Transaksis extends Component
{
    public $total;
    public $transaksi_id;
    public $bibit_id;
    public $qty=1;
    public $uang;
    public $kembali;

    public function render()
    {
       $transaksi=transaksi::select('*')->where('user_id','=',Auth::user()->id)->orderBy('id','desc')->first();

       $this->total=$transaksi->total;
       $this->kembali=$this->uang-$this->total;
       return view('livewire.transaksis')
       ->with("data",$transaksi)
       ->with("dataBibit",Bibit::where('stock','>','0')->get())
       ->with("dataDetiltransaksi",Detiltransaksi::where('transaksi_id','=',$transaksi->id)->get());
    }

    public function store()
    {
        $this->validate([

            'bibit_id'=>'required'
        ]);
        $transaksi=Transaksi::select('*')->where('user_id','=',Auth::user()->id)->orderBy('id','desc')->first();
        $this->transaksi_id=$transaksi->id;
        $bibit=Bibit::where('id','=',$this->bibit_id)->get();
        $harga=$bibit[0]->price;
        detiltransaksi::create([
            'transaksi_id'=>$this->transaksi_id,
            'bibit_id'=>$this->bibit_id,
            'qty'=>$this->qty,
            'price'=>$harga
        ]);

        $total=$transaksi->total;
        $total=$total+($harga*$this->qty);
        transaksi::where('id','=',$this->order_id)->update([
            'total'=>$total
        ]);
        $this->transaksi_id=NULL;
        $this->qty=1;
    }

    public function delete($detiltransaksi_id)
    {
        $detiltransaksi=Detiltransaksi::find($detiltransaksi_id);
        $detiltransaksi->delete();

        //update total
        $detiltransaksi=Detiltransaksi::select('*')->where('transaksi_id','=',$this->transaksi_id)->get();
        $total=0;
        foreach($detiltransaksi as $od){
            $total+=$od->qtv*$od->price;
        }

        try{
            Transaksi::where('id','=',$this->transaksi_id)->update([
                'total'=>$total
            ]);
        }catch(Exception $e){
            dd($e);
        }
    }

    public function receipt($id)
    {
        $detiltransaksi = detiltransaksi::select('*')->where('transaksi_id','=', $id)->get();
        //dd ($detiltransaksi);
        foreach ($detiltransaksi as $od) {
            $stocklama = bibit::select('stock')->where('id','=', $od->bibit_id)->sum('stock');
            $stock = $stocklama - $od->qty;
            try {
                bibit::where('id','=', $od->bibit_id)->update([
                    'stock' => $stock
                ]);
            } catch (Exception $e) {
                dd($e);
            }
        }
        return Redirect::route('cetakReceipt')->with(['id' => $id]);

    }
}

