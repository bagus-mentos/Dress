@extends('layouts.app')
@push('styles')
@include('layouts.components.css')
@endpush
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Order</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4 mt-4">
        <div class="card-header py-3">
            <div style="text-align: right">
                <h6 class="m-0 font-weight-bold text-primary"> </h6>
                <a href="{{route('order.create')}}" class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah Order</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table-1" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Product</th>
                            <th>Customer</th>
                            <th>Rent Start Date</th>
                            <th>Rent End Date</th>
                            <th style="width: 10%">Down Payment</th>
                            <th style="width: 10%">Price</th>
                            <th style="width: 10%">Discount</th>
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
    <div class="card shadow mb-4 mt-4">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Calendar</h6>
        </div>
            <div style="width: 40%;margin-left: 30px;margin-top: 30px;margin-bottom: 30px;" id="calendar"></div>  
        
    </div> 
</div>
@endsection
@push('scripts')
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js'></script>
    <script> 
        document.addEventListener('DOMContentLoaded', function () {
            var calendarEl = document.getElementById('calendar');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                displayEventTime: false,
                initialView: 'dayGridMonth',
                events: @json($events),
            });
            calendar.render();
        });
    </script>
@endpush
@push('scripts')
@include('layouts.components.js')
<script type="text/javascript">
    $(function() {
        var table = $('#table-1').DataTable({
            bDestroy: true
            , processing: true
            , serverSide: true
            , ajax: "{{ route('order.getOrder') }}"
            , columns: [{
                    data: 'DT_RowIndex'
                    , className: "text-center"
                }
                , {
                    data: 'productName'
                }
                , {
                    data: 'customerName'
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
                }
                , {
                    data: 'price'
                    , className: "text-right"
                }
                , {
                    data: 'discount'
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
@endpush
