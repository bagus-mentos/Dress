@extends('layouts.app')
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
@endpush
@section('content')
<style>
    .select2 {
        width: 100%;
    }
    .select2-container .select2-selection--single {
        height: 40px !important;
    }

    div.inline { float:left;margin-right: 40px;margin-top: 30px }
    .clearBoth { clear:both; }
</style>

<div class="container-fluid">
    
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Product</h1>
    <form method="POST" action="{{ $action }}" enctype="multipart/form-data">
        @csrf
        @if (isset($product))
        @method('PUT')
        @endif
        
        <div class="card shadow mb-4 mt-4">
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Form {{ isset($data)?'Ubah':'Tambah' }} Product </h6>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="font-weight-bold">Sub Category</label>
                    <select name="idr_subcategory" class="form-control select2-basic-single @error('idr_subcategory') is-invalid @enderror" aria-required="true" aria-invalid="false">
                        <option value="">-- Pilih Data --</option>
                        @foreach ($subCategory as $res)
                        <option value="{{ $res->idr_subcategory }}" {{ old('idr_subcategory', isset($product) ? $product->idr_subcategory : '') == $res->idr_subcategory ? 'selected' : '' }}>{{ $res->name }}</option>
                        @endforeach
                    </select>
                    @error('idr_subcategory')
                    <p style="width: 100%;font-size: 80%;color: #e3342f;">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Fabric</label>
                    <select name="idr_fabric"  class="form-control select2-basic-single @error('idr_fabric') is-invalid @enderror" aria-required="true" aria-invalid="false">
                        <option value="">-- Pilih Data --</option>
                        @foreach ($fabric as $res)
                        <option value="{{ $res->idr_fabric }}" {{ old('idr_fabric', isset($product) ? $product->idr_fabric : '') == $res->idr_fabric ? 'selected' : '' }}>{{ $res->name }}</option>
                        @endforeach
                    </select>
                    @error('idr_fabric')
                    <p style="width: 100%;font-size: 80%;color: #e3342f;">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Collection</label>
                    <select name="idr_collection"  class="form-control select2-basic-single @error('idr_collection') is-invalid @enderror" aria-required="true" aria-invalid="false">
                        <option value="">-- Pilih Data --</option>
                        @foreach ($collection as $res)
                        <option value="{{ $res->idr_collection }}" {{ old('idr_collection', isset($product) ? $product->idr_collection : '') == $res->idr_collection ? 'selected' : '' }}>{{ $res->name }}</option>
                        @endforeach
                    </select>
                    @error('idr_collection')
                    <p style="width: 100%;font-size: 80%;color: #e3342f;">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Size</label>
                    <select name="idr_size"  class="form-control select2-basic-single @error('idr_size') is-invalid @enderror" aria-required="true" aria-invalid="false">
                        <option value="">-- Pilih Data --</option>
                        @foreach ($size as $res)
                        <option value="{{ $res->idr_size }}" {{ old('idr_size', isset($product) ? $product->idr_size : '') == $res->idr_size ? 'selected' : '' }}>{{ $res->name }}</option>
                        @endforeach
                    </select>
                    @error('idr_size')
                    <p style="width: 100%;font-size: 80%;color: #e3342f;">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
        <div class="card shadow mb-4 mt-4">
            <div class="card-body">
                <div class="form-group">
                    <label class="font-weight-bold">Nama</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', isset($product) ? $product->name : '') }}" placeholder="Input Name">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Code</label>
                    <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ old('code', isset($product) ? $product->code : '') }}" placeholder="Input code">
                    @error('code')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Price</label>
                    <input type="text" name="price" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', isset($product) ? $product->price : '') }}" placeholder="Input price">
                    @error('price')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Color</label>
                    <div id="cp2" class="input-group colorpicker-component"> 
                      <input type="text" value="#00AABB" class="form-control" /> 
                      <span class="input-group-addon"><i></i></span>
                    </div>
                </div>
                {{-- <div class="form-group">
                    <label class="font-weight-bold">Color</label>
                    <input type="text" name="color" class="form-control @error('color') is-invalid @enderror" value="{{ old('color', isset($product) ? $product->color : '') }}" placeholder="Input color">
                    @error('color')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div> --}}
                
            </div>
        </div>
        <div class="card shadow mb-4 mt-4">
            <div class="card-body">
                
                <div class="form-group">
                    <label class="font-weight-bold">Condition</label>
                    <input type="text" name="condition" class="form-control @error('condition') is-invalid @enderror" value="{{ old('condition', isset($product) ? $product->condition : '') }}" placeholder="Input condition">
                    @error('condition')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">

                    <label class="font-weight-bold">Notes</label>
                    {{-- <input type="text" name="notes" class="form-control @error('notes') is-invalid @enderror" value="{{ old('notes', isset($product) ? $product->notes : '') }}" placeholder="Input notes"> --}}
                    <textarea name="notes" class="form-control @error('notes') is-invalid @enderror" value="{{ old('notes', isset($product) ? $product->notes : '') }}" placeholder="Input notes" rows="5"></textarea>
                    @error('notes')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
        </div>

        <div class="card shadow mb-4 mt-4">
            <div class="card-body" align="center">
                
                <div class="inline" >
                    <div class="form-group" align="center">
                        <label class="font-weight-bold">Gambar 1</label><br/>
                        <img id="img1" src="https://assets.tokopedia.net/assets-tokopedia-lite/v2/icarus/kratos/8d58e463.svg" style="width:200px;height:300px;"/>
                        <input accept="image/*" type='file' id="imgInp1" class="form-control @error('pic1') is-invalid @enderror" name="pic1" />
                    </div>
                </div>
                <div class="inline" >
                    <div class="form-group" align="center">
                        <label class="font-weight-bold">Gambar 2</label><br/>
                        <img id="img2" src="https://assets.tokopedia.net/assets-tokopedia-lite/v2/icarus/kratos/8d58e463.svg" style="width:200px;height:300px;"/>
                        <input accept="image/*" type='file' id="imgInp2" class="form-control @error('pic2') is-invalid @enderror" name="pic2" />
                    </div>
                </div>
                <div class="inline" >
                    <div class="form-group" align="center">
                        <label class="font-weight-bold">Gambar 3</label><br/>
                        <img id="img3" src="https://assets.tokopedia.net/assets-tokopedia-lite/v2/icarus/kratos/8d58e463.svg" style="width:200px;height:300px;"/>
                        <input accept="image/*" type='file' id="imgInp3" class="form-control @error('pic3') is-invalid @enderror" name="pic3" />
                    </div>
                </div>
                <div class="inline" >
                    <div class="form-group" align="center">
                        <label class="font-weight-bold">Gambar 4</label><br/>
                        <img id="img4" src="https://assets.tokopedia.net/assets-tokopedia-lite/v2/icarus/kratos/8d58e463.svg" style="width:200px;height:300px;"/>
                        <input accept="image/*" type='file' id="imgInp4" class="form-control @error('pic4') is-invalid @enderror" name="pic4" />
                    </div>
                </div>
                
{{-- 
                <div class="form-group">
                    <label class="custom-file-upload">Gambar 1
                        <input type="file" class="form-control @error('pic1') is-invalid @enderror" name="pic1">
                    </label>
                    @error('pic1')
                    <div class="alert alert-danger mt-2">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Gambar 2</label>
                    <input type="file" class="form-control @error('pic2') is-invalid @enderror" name="pic2">
                    @error('pic2')
                    <div class="alert alert-danger mt-2">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Gambar 3</label>
                    <input type="file" class="form-control @error('pic3') is-invalid @enderror" name="pic3">
                    @error('pic3')
                    <div class="alert alert-danger mt-2">
                        {{ $message }}
                    </div>
                    @enderror
                </div> 
                <div class="form-group">
                    <label class="font-weight-bold">Gambar 4</label>
                    <input type="file" class="form-control @error('pic4') is-invalid @enderror" name="pic4">
                    @error('pic4')
                    <div class="alert alert-danger mt-2">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
--}}
            </div>
        </div>
            <div class="card-footer text-right">
                <a href="{{ route('product.index') }}" class="btn btn-info icon-left"><i class="fas fa-arrow-left mr-1"></i>Back</a>
                <button class="btn btn-primary"><i class="far fa-save mr-1"></i>Submit</button>
            </div>
        </form>
    
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.6/css/bootstrap-colorpicker.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-2.2.2.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.3.6/js/bootstrap-colorpicker.js"></script>

<script>
    $(document).ready(function() {
        $('.select2-basic-single').select2();
    });
    imgInp1.onchange = evt => {
        const [file] = imgInp1.files
        if (file) {
            img1.src = URL.createObjectURL(file)
        }
    }
    imgInp2.onchange = evt => {
        const [file] = imgInp2.files
        if (file) {
            img2.src = URL.createObjectURL(file)
        }
    }
    imgInp3.onchange = evt => {
        const [file] = imgInp3.files
        if (file) {
            img3.src = URL.createObjectURL(file)
        }
    }
    imgInp4.onchange = evt => {
        const [file] = imgInp4.files
        if (file) {
            img4.src = URL.createObjectURL(file)
        }
    }
</script>
<script type="text/javascript">
    $('#cp2').colorpicker();
</script>
@endpush
