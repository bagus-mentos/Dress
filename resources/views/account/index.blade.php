@extends('layouts.app')
@push('styles')
@include('layouts.components.css')
@endpush
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">User</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4 mt-4">
        <div class="card-header py-3">
            <div class="d-sm-flex align-items-center justify-content-between ">
                <h6 class="m-0 font-weight-bold text-primary">DataTables </h6>

                <a href="{{route('account.create')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Add Record</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table-1" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>#</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

</div>
@endsection
@push('scripts')
@include('layouts.components.js')
<script type="text/javascript">
    $(function() {

        var table = $('#table-1').DataTable({
            bDestroy: true
            , processing: true
            , serverSide: true
            , ajax: "{{ route('account.getAccount') }}"
            , columns: [{
                    data: 'DT_RowIndex'
                    , className: "text-center"
                }
                , {
                    data: 'name'
                }
                , {
                    data: 'email'
                }
                , {
                    data: 'email'
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
