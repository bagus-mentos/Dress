@extends('layouts.app')
@push('styles')
@include('layouts.components.css')
@endpush
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
    @if (isset($customer))
    <div class="card shadow mb-4 mt-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Order History</h6>
        </div>
        <div class="card-header py-3">
            <div class="d-sm-flex align-items-center justify-content-between ">
                <h6 class="m-0 font-weight-bold text-primary"> </h6>

                <a href="{{route('order.createc', $customer->idr_customer)}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table-1" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Product</th>
                            <th>Rent Start Date</th>
                            <th>Rent End Date</th>
                            <th style="width: 10%">Down Payment</th>
                            <th style="width: 10%">Price</th>
                            <th style="width: 10%">Remaining</th>
                            <th>Notes</th>
                            <th>Status</th>
                            <th>#</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>

    </div>
    @endif
</div>
@endsection
@push('scripts')
@include('layouts.components.js')
@if (isset($customer))
<script type="text/javascript">
    $(function() {
        var table = $('#table-1').DataTable({
            bDestroy: true
            , processing: true
            , serverSide: true
            , ajax: {
                url: "{{ route('order.getOrderByCustomer') }}", 
                data: { 
                    idr_customer: {{ $customer->idr_customer }}
                    }
            }
            , columns: [{
                    data: 'DT_RowIndex'
                    , className: "text-center"
                }
                , {
                    data: 'productName'
                }
                , {
                    data: 'rent_start_date'
                }
                , {
                    data: 'event_date'
                }
                , {
                    data: 'downpayment'
                    , className: "text-right"
                }, {
                    data: 'price'
                    , className: "text-right"
                }
                , {
                    data: 'remaining'
                    , className: "text-right"
                }
                , {
                    data: 'notes'
                }
                , {
                    data: 'idr_status'
                }
                , {
                    data: 'action'
                    , name: 'action'
                    , orderable: false
                    , searchable: false
                }
            , ]
        });
    });

</script>
@endif
@endpush
