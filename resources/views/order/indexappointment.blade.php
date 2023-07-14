@extends('layouts.app')
@push('styles')
@include('layouts.components.css')
@endpush
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Appointment</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4 mt-4">
        <div class="card-header py-3">
            <div style="text-align: right">
                <h6 class="m-0 font-weight-bold text-primary"> </h6>
                <a href="{{route('order.createAppointment')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Buat Appointment</a>
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
                            <th>Appointment Time</th>
                            <th>Notes</th>
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
                initialView: 'timeGridWeek',
                headerToolbar: {
                    left: 'prev,next',
                    center: 'title',
                    right: 'timeGridWeek,timeGridDay' // user can switch between the two
                },
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
            , ajax: "{{ route('order.getAppointment') }}"
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
                    data: 'appointment_date'
                }
                , {
                    data: 'notes'
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
