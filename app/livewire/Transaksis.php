<?php

namespace App\Livewire;

use Exception;
use App\Models\transaksi;
use App\Models\bibit;
use Livewire\Component;
use App\Models\Detiltransaksi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

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
        ->with("databibit",bibit::where('stock','>','0')->get())
        ->with("dataDetiltransaksi",Detiltransaksi::where('transaksi_id','=',$transaksi->id)->get());
    }

    public function store()
    {
        $this->validate([
            
            'bibit_id'=>'required'
        ]);
        $transaksi=transaksi::select('*')->where('user_id','=',Auth::user()->id)->orderBy('id','desc')->first();
        $this->transaksi_id=$transaksi->id;
        $bibit=bibit::where('id','=',$this->bibit_id)->get();
        $price=$bibit[0]->price;
        Detiltransaksi::create([
            'transaksi_id'=>$this->transaksi_id,
            'bibit_id'=>$this->bibit_id,
            'qty'=>$this->qty,
            'price'=>$price
        ]);
        
        
        $total=$transaksi->total;
        $total=$total+($price*$this->qty);
        transaksi::where('id','=',$this->transaksi_id)->update([
            'total'=>$total
        ]);
        $this->bibit_id=NULL;
        $this->qty=1;

    }

    public function delete($Detiltransaksi_id)
    {
        $Detiltransaksi=Detiltransaksi::find($Detiltransaksi_id);
        $Detiltransaksi->delete();

        //update total
        $Detiltransaksi=Detiltransaksi::select('*')->where('transaksi_id','=',$this->transaksi_id)->get();
        $total=0;
        foreach($Detiltransaksi as $od){
            $total+=$od->qty*$od->price;
        }
        
        try{
            transaksi::where('id','=',$this->transaksi_id)->update([
                'total'=>$total
            ]);
        }catch(Exception $e){
            dd($e);
        }
    }
    
    public function receipt($id)
    {
        $Detiltransaksi = Detiltransaksi::select('*')->where('transaksi_id','=', $id)->get();
        //dd ($detiltransaksi);
        foreach ($Detiltransaksi as $od) {
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