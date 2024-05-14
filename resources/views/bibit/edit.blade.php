@extends('layouts.template') 
@section('judulh1','Admin - bibit') 
 
@section('konten') 
<div class="col-md-6"> 
    @if ($errors->any()) 
    <div class="alert alert-danger"> 
        <strong>Whoops!</strong> There were some problems with your input.<br><br> 
        <ul> 
            @foreach ($errors->all() as $error) 
            <li>{{ $error }}</li> 
            @endforeach 
        </ul> 
    </div> 
    @endif 
 
    <div class="card card-warning"> 
        <div class="card-header"> 
            <h3 class="card-title">Ubah Data bibit</h3> 
        </div> 
        <!-- /.card-header --> 
        <!-- form start --> 
        <form action="{{ route('bibit.update',$bibit->id) }}" method="POST"> 
            @csrf 
            @method('PUT') 
            <div class=" card-body"> 

                <div class="form-group"> 
                    <label for="nama">Nama bibit</label> 
                    <input type="text" class="form-control" id="nama" name="nama" placeholder="{{$bibit->nama}}"  
                    value="{{$bibit->nama}}"> 
                </div> 
                <div class="form-group"> 
                    <label for="stock">Stok</label> 
                    <input type="number" class="form-control" id="stock" name="stock" value="{{$bibit->stock}}"> 
                </div> 
 
                
                <div class="form-group"> 
                    <label for="harga">Harga</label> 
                    <input type="number" class="form-control" id="harga" name="harga" value="{{$bibit->harga}}"> 
                </div> 
                <div class=" form-group"> 
                    <label for="description">Deskripsi</label> 
                    <textarea id="description" name="description" class=" form-control"  rows="4">{{ $bibit->description }}</textarea> 
                </div> 
            </div> 
            <!-- /.card-body --> 
 
            <div class="card-footer"> 
            <button type="submit" class="btn btn-warning floatright">Ubah</button> 
            </div> 
        </form> 
    </div> 
 
 
</div> 
 
 
@endsection 
