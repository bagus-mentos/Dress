@extends('layouts.app')
@push('styles')
@include('layouts.components.css')
@endpush
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Product</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4 mt-4">
        <div class="card-header py-3">
            <div class="d-sm-flex align-items-center justify-content-between ">
                <h6 class="m-0 font-weight-bold text-primary"> </h6>
                <a href="{{route('product.create')}}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-plus fa-sm text-white-50"></i> Tambah</a>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="table-1" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th width='10px'>No</th>
                            <th>Category</th>
                            <th>Sub Category</th>
                            <th>Fabric</th>
                            <th>Collection</th>
                            <th>Size</th>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Notes</th>
                            <th>Condition</th>
                            {{-- <th>Color</th> --}}
                            <th>Pic1</th>
                            <th>Pic2</th>
                            <th>Pic3</th>
                            <th>Pic4</th>
                            <th>#</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="imagemodal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
                    <img src="" class="imagepreview" style="width: 100%;">
                </div>
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
            , ajax: "{{ route('product.getProduct') }}"
            , columns: [{
                    data: 'DT_RowIndex'
                    , className: "text-center"
                }
                , {
                    data: 'category'
                }
                , {
                    data: 'subCategory'
                }
                , {
                    data: 'fabric'
                }
                , {
                    data: 'collection'
                }
                , {
                    data: 'size'
                }
                , {
                    data: 'code'
                }
                , {
                    data: 'name'
                }
                , {
                    data: 'price'
                }
                , {
                    data: 'notes'
                }
                , {
                    data: 'condition'
                }
                , {
                    data: "pic1"
                    ,className: "text-center", render: function(data) {
                        if(data != null) {
                        return "<a href='#' class='pop'><img src=\"products/" + data + "\" height=\"50\"/></a>"
                         }else{ return "-"}
                    }
                }
                , {
                    data: "pic2"
                    , className: "text-center",render: function(data) {
                        if(data != null) {
                        return "<a href='#' class='pop'><img src=\"products/" + data + "\" height=\"50\"/></a>"
                         }else{ return "-"}
                    }
                }
                , {
                    data: "pic3"
                    , className: "text-center",render: function(data) {
                        if(data != null) {
                        return "<a href='#' class='pop'><img src=\"products/" + data + "\" height=\"50\"/></a>"
                         }else{ return "-"}
                    }
                }
                , {
                    data: "pic4"
                    , className: "text-center",render: function(data) {
                        if(data != null) {
                        return "<a href='#' class='pop'><img src=\"products/" + data + "\" height=\"50\"/></a>"
                         }else{ return "-"}
                    }
                }
                , {
                    data: 'action'
                    , name: 'action'
                    , orderable: false
                    , searchable: false
                }
            , ]
        });

        $("body").on("click", ".pop", function(e) {
            $('.imagepreview').attr('src', $(this).find('img').attr('src'));
            $('#imagemodal').modal('show');
        });
    });

</script>
@endpush
