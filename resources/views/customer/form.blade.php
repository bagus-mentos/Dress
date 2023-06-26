@extends('layouts.app')
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Customer</h1>
    <div class="card shadow mb-4 mt-4">
        <form method="POST" action="{{ $action }}">
            @csrf
            @if (isset($customer))
            @method('PUT')
            @endif
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Form {{ isset($data)?'Ubah':'Tambah' }} Customer </h6>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="font-weight-bold">Nama</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', isset($customer) ? $customer->name : '') }}" placeholder="Input Name">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Phone Number</label>
                    <input type="text" name="phonenumber" class="form-control @error('phonenumber') is-invalid @enderror" value="{{ old('phonenumber', isset($customer) ? $customer->phonenumber : '') }}" placeholder="Input Phone Number ">
                    @error('phonenumber')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Address</label>
                    <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address', isset($customer) ? $customer->address : '') }}" placeholder="Input Address">
                    @error('address')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
            </div>
            <div class="card-footer text-right">
                <a href="{{ route('customer.index') }}" class="btn btn-info icon-left"><i class="fas fa-arrow-left mr-1"></i>Back</a>
                <button class="btn btn-primary"><i class="far fa-save mr-1"></i>Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection
