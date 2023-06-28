@extends('layouts.app')
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">User</h1>
    <div class="card shadow mb-4 mt-4">
        <form method="POST" action="{{ $action }}">
            @csrf
            @if (isset($account))
            @method('PUT')
            @endif
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Form {{ isset($account)?'Ubah':'Tambah' }} User </h6>
            </div>
            <div class="card-body">
                <div class="form-group">
                    <label class="font-weight-bold">Nama</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', isset($account) ? $account->name : '') }}" placeholder="Input Name">
                    @error('name')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Email</label>
                    <input type="text" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email', isset($account) ? $account->email : '') }}" placeholder="Input Email">
                    @error('email')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                @if(!$hide)

                <div class="form-group">
                    <label class="font-weight-bold">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" value="{{ old('password', isset($account) ? $account->password : '') }}" placeholder="Input Password">
                    @error('password')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                @endif
            </div>
            <div class="card-footer text-right">
                <a href="{{ route('account.index') }}" class="btn btn-info icon-left"><i class="fas fa-arrow-left mr-1"></i>Back</a>
                <button class="btn btn-primary"><i class="far fa-save mr-1"></i>Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection
