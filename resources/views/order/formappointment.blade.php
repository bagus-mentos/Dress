@extends('layouts.app')
@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<style>
    .select2 {
        width: 100%;
    }

    .select2-container .select2-selection--single {
        height: 40px !important;
    }

    div.inline {
        float: left;
        margin-right: 40px;
        margin-top: 30px
    }

    .clearBoth {
        clear: both;
    }

</style>
@endpush
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Order</h1>
    <div class="card shadow mb-4 mt-4">
        <form method="POST" action="{{ $action }}">
            @csrf
            @if (isset($order))
            @method('PUT')
            @endif
            <div class="card-header">
                <h6 class="m-0 font-weight-bold text-primary">Form {{ isset($data)?'Ubah':'Tambah' }} Order </h6>
            </div>
            <div class="card-body">
                @if (isset($order))
                <input type="hidden" name="idt_order" value="{{$order->idt_order}}"/>
                @endif
                <div class="form-group">
                    <label class="font-weight-bold">Product</label>
                    <select name="idr_product" id='category' class="form-control select2 select2-basic-single @error('idr_product') is-invalid @enderror" aria-required="true" aria-invalid="false">
                        <option value="">-- Pilih Data --</option>
                        @foreach ($product as $res)
                        <option value="{{ $res->idr_product }}" {{ old('idr_product', isset($order) ? $order->idr_product : '') == $res->idr_product ? 'selected' : '' }}>{{ $res->name }}</option>
                        @endforeach
                    </select>
                    @error('idr_product')
                    <p style="width: 100%;font-size: 80%;color: #e3342f;">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Customer</label>
                    <select name="idr_customer" id='category' class="form-control select2 select2-basic-single @error('idr_customer') is-invalid @enderror" aria-required="true" aria-invalid="false">
                        <option value="">-- Pilih Data --</option>
                        @foreach ($customer as $res)
                        <option value="{{ $res->idr_customer }}" {{ old('idr_customer', isset($order) ? $order->idr_customer : '') == $res->idr_customer ? 'selected' : '' }}>{{ $res->name }}</option>
                        @endforeach
                    </select>
                    @error('idr_customer')
                    <p style="width: 100%;font-size: 80%;color: #e3342f;">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="font-weight-bold">Appointment Time</label>
                    <input type="datetime-local" name="appointment_date" class="form-control @error('appointment_date') is-invalid @enderror" value="{{ old('appointment_date', isset($order) ? $order->appointment_date : '') }}">
                    @error('rent_start_date')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label class="font-weight-bold">Notes</label>
                    <input type="text" name="notes" class="form-control @error('notes') is-invalid @enderror" value="{{ old('notes', isset($order) ? $order->notes : '') }}" placeholder="Input notes">
                    @error('notes')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                
            </div>
            <div class="card-footer text-right">
                <a href="{{ route('appointment') }}" class="btn btn-info icon-left"><i class="fas fa-arrow-left mr-1"></i>Back</a>
                <button class="btn btn-primary"><i class="far fa-save mr-1"></i>Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function() {
        $('.select2-basic-single').select2();
    });

</script>
@endpush
