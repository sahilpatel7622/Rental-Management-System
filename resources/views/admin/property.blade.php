@extends('layouts.admin')

@section('title','Property')
@section('page','Property')

@section('content')

<style>
    .card{ border-radius:16px; overflow:hidden; }
    .card-header{ padding:18px 22px; border-bottom:1px solid #e5e7eb; }
    .card-body{ padding:22px; }

    table.dataTable{
        border-collapse:collapse !important;
        width:100% !important;
    }

    table.dataTable thead th{
        background:#2563eb !important;
        color:#fff !important;
        font-weight:600;
        padding:14px 12px !important;
        border-color:#2563eb !important;
    }

    table.dataTable tbody td{
        padding:13px 12px !important;
        vertical-align:middle;
        border-color:#e5e7eb !important;
        white-space:nowrap;
    }

    table.dataTable tbody tr:hover{
        background:#f8fafc !important;
    }

    .dt-search input,
    .dataTables_filter input{
        border-radius:10px !important;
        border:1px solid #d1d5db !important;
        padding:7px 12px !important;
        margin-left:8px;
        outline:none;
    }

    .dt-length select,
    .dataTables_length select{
        border-radius:10px !important;
        border:1px solid #d1d5db !important;
        padding:6px 30px 6px 10px !important;
        outline:none;
    }

    .dt-info,
    .dataTables_info{
        color:#6b7280;
        font-size:14px;
        margin-top:12px;
    }

    .dt-paging .page-link,
    .dataTables_paginate .paginate_button{
        border-radius:8px !important;
        margin:0 3px;
    }

    .badge{
        padding:7px 12px;
        border-radius:20px;
        font-weight:600;
    }

    .btn-sm{
        border-radius:8px;
        padding:6px 10px;
    }

    .dt-paging-button.first,
    .dt-paging-button.last,
    .dt-paging-button.previous,
    .dt-paging-button.next{
        display:none !important;
    }

    .property-img{
        width:60px;
        height:45px;
        object-fit:cover;
        border-radius:8px;
    }

    .modal-content{
        border-radius:16px;
        border:0;
    }

    .modal-header{
        border-bottom:1px solid #e5e7eb;
    }

    .modal-footer{
        border-top:1px solid #e5e7eb;
    }

    .form-control{
        border-radius:10px;
        padding:9px 12px;
    }
</style>

<div class="card shadow-sm border-0">

    <div class="card-header bg-white d-flex justify-content-between align-items-center">

        <div>
            <h5 class="mb-0 fw-bold">Property Management</h5>
            <small class="text-muted">View and manage property</small>
        </div>

        <button type="button"
                class="btn btn-primary btn-sm"
                id="addBtn">
            <i class="fa fa-plus"></i> Add Property
        </button>

    </div>

    <div class="card-body">

        <table class="table table-bordered table-hover yajra-datatable w-100">
            <thead>
                <tr>
                    <th width="70">ID</th>
                    <th width="100">Image</th>
                    <th>Title</th>
                    <th>Location</th>
                    <th width="150">Rent Price</th>
                    <th width="120">Status</th>
                    <th width="120">Action</th>
                </tr>
            </thead>
        </table>

    </div>

</div>

<div class="modal fade" id="propertyModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">

            <form id="propertyForm"
                  action="{{ route('admin.property.store') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="property_id" id="property_id" value="{{ old('property_id') }}">

                <div class="modal-header">
                    <h3 class="modal-title fw-bold" id="modalTitle">Add Property</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Title</label>
                            <input type="text"
                                   name="title"
                                   id="title"
                                   value="{{ old('title') }}"
                                   class="form-control @error('title') is-invalid @enderror"
                                   placeholder="Enter property title">

                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Location</label>
                            <input type="text"
                                   name="location"
                                   id="location"
                                   value="{{ old('location') }}"
                                   class="form-control @error('location') is-invalid @enderror"
                                   placeholder="Enter location">

                            @error('location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Rent Price</label>
                            <input type="number"
                                   name="rent_price"
                                   id="rent_price"
                                   value="{{ old('rent_price') }}"
                                   class="form-control @error('rent_price') is-invalid @enderror"
                                   placeholder="Enter rent price">

                            @error('rent_price')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status"
                                    id="status"
                                    class="form-control @error('status') is-invalid @enderror">
                                <option value="available" {{ old('status') == 'available' ? 'selected' : '' }}>Available</option>
                                <option value="rented" {{ old('status') == 'rented' ? 'selected' : '' }}>Rented</option>
                            </select>

                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Image</label>
                            <input type="file"
                                   name="image"
                                   class="form-control @error('image') is-invalid @enderror">

                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description"
                                      id="description"
                                      class="form-control @error('description') is-invalid @enderror"
                                      rows="3"
                                      placeholder="Enter description">{{ old('description') }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                        Close
                    </button>

                    <button type="submit" class="btn btn-primary btn-sm" id="submitBtn">
                        Save Property
                    </button>
                </div>

            </form>

        </div>
    </div>
</div>

@endsection

@push('scripts')

<script>
$(function () {

    $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        autoWidth: false,
        pageLength: 10,

        ajax: "{{ route('admin.property') }}",

        columns: [
            {
                data:'id',
                name:'id',
                render:function(data){
                    return '<span class="text-success fw-bold">#' + data + '</span>';
                }
            },
            {data:'image', name:'image', width:'100px', searchable:false, orderable:false},
            {data:'title', name:'title'},
            {data:'location', name:'location'},
            {data:'rent_price', name:'rent_price', width:'150px'},
            {data:'status', name:'status', width:'120px', searchable:false, orderable:false},
            {data:'action', name:'action', width:'120px', searchable:false, orderable:false}
        ],

        language: {
            search: "Search:",
            lengthMenu: "_MENU_ Entries per page",
            processing: "Loading property..."
        }
    });

    $('#addBtn').click(function () {
        $('#modalTitle').text('Add Property');

        $('#submitBtn')
            .text('Save Property')
            .removeClass('btn-warning')
            .addClass('btn-primary');

        $('#propertyForm').attr('action', "{{ route('admin.property.store') }}");
        $('#propertyForm')[0].reset();
        $('#property_id').val('');

        // Clear previous validation errors
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        let modal = new bootstrap.Modal(document.getElementById('propertyModal'));
        modal.show();
    });

    $(document).on('click', '.edit-btn', function () {
        let id = $(this).data('id');

        $('#modalTitle').text('Edit Property');

        $('#submitBtn')
            .text('Update Property')
            .removeClass('btn-primary')
            .addClass('btn-warning');

        $('#propertyForm').attr('action', '/admin/property/update/' + id);

        $('#title').val($(this).data('title'));
        $('#location').val($(this).data('location'));
        $('#rent_price').val($(this).data('rent_price'));
        $('#description').val($(this).data('description'));
        $('#status').val($(this).data('status'));
        $('#property_id').val(id);

        // Clear previous validation errors
        $('.is-invalid').removeClass('is-invalid');
        $('.invalid-feedback').remove();

        let modal = new bootstrap.Modal(document.getElementById('propertyModal'));
        modal.show();
    });

    @if ($errors->any())
        let oldId = "{{ old('property_id') }}";
        if (oldId) {
            $('#modalTitle').text('Edit Property');
            $('#submitBtn')
                .text('Update Property')
                .removeClass('btn-primary')
                .addClass('btn-warning');
            $('#propertyForm').attr('action', '/admin/property/update/' + oldId);
        } else {
            $('#modalTitle').text('Add Property');
            $('#submitBtn')
                .text('Save Property')
                .removeClass('btn-warning')
                .addClass('btn-primary');
            $('#propertyForm').attr('action', "{{ route('admin.property.store') }}");
        }

        let errorModal = new bootstrap.Modal(document.getElementById('propertyModal'));
        errorModal.show();
    @endif

});
</script>

@endpush