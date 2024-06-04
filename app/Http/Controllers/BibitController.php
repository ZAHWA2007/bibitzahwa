<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\bibit;

class bibitController extends Controller
{
    //
    public function index()
{
    $bibit=bibit::all();
    return view('bibit.index',[
        "title"=>"bibit",
        "data"=> $bibit
    ]);
}
public function create():View
{
    return view('bibit.create')->with([
        "title"=>"Tambah Data bibit",

    ]);
}
public function store(Request $request): RedirectResponse
{
    $request->validate([
        "nama"=>"required",
        "description"=>"required",
        "stock"=>"required",
        "price"=>"nullable",

    ]); 

    bibit::create($request->all());
    return redirect()->route('bibit.index')->with('success','Data bibit Berhasil Ditambahkan');
}
    public function edit(bibit $bibit):View
{
    return view('bibit.edit',compact('bibit'))->with([
        "title" => "Ubah Data bibit",
        // "data"=>Category::all()

    ]);
}
public function update(bibit $bibit, Request $request): RedirectResponse
{
    $request->validate([
        "nama"=>"required",
        "description"=>"required",
        "stock"=>"required",
        "price"=>"nullable",
    
    ]);
    $bibit->update($request->all());
    return redirect()->route('bibit.index')->with('update','Data bibit Berhasil Diubah');
}
public function show():View
{
    $bibit=bibit::all();
    return view('bibit.show')->with([
        "title" => "Tampil Data bibit",
        "data"=>$bibit
    ]);
}
public function destroy($id): RedirectResponse
{
    bibit::where('id',$id)->delete();
    return redirect()->route('bibit.index')->with('deleted','Data bibit Berhasil Dihapus');
}
}