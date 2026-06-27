@extends('layouts.admin')

@section('title','Users')
@section('page','Users')

@section('content')

<style>
    .card{
        border-radius:16px;
        overflow:hidden;
    }

    .card-header{
        padding:18px 22px;
        border-bottom:1px solid #e5e7eb;
    }

    .card-body{
        padding:22px;
    }

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
</style>

<div class="card shadow-sm border-0">

    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0 fw-bold">Users Management</h5>
            <small class="text-muted">View and manage registered users</small>
        </div>
    </div>

    <div class="card-body">

        <table class="table table-bordered table-hover yajra-datatable w-100">
            <thead>
                <tr>
                    <th width="80">ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th width="180">Number</th>
                    <th width="120">Status</th>
                    <th width="100">Action</th>
                </tr>
            </thead>
        </table>

    </div>

</div>

@endsection

@push('scripts')

<script>
$(function () {

    $('.yajra-datatable').DataTable({
        processing: true,
        serverSide: false,   
        responsive: true,
        autoWidth: false,
        pageLength: 10,
        // lengthMenu: [[10,25,50,100],[10,25,50,100]],
        // pagingType: "simple_numbers",
        // ordering: true,
        // searching: true,
        // info: true,
        // lengthChange: true,

        ajax: "{{ route('admin.users') }}",

        columns: [
            {data:'id', name:'id',searchable:false,
            render:function(data){
                return '<span class="text-success fw-bold">#' + data + '</span>';}
            },
            {data:'name', name:'name'},
            {data:'email', name:'email'},
            {data:'phone', name:'phone'},
            {data:'status', name:'status', orderable:false, searchable:false},
            {data:'action', name:'action', searchable:false, orderable:false}
        ],

        language: {
            search: "Search:",
            lengthMenu: "_MENU_ Entries per page",
            processing: "Loading users..."
        }
    });

});
</script>

@endpush