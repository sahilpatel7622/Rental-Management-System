@extends('layouts.admin')

@section('title','Payments')
@section('page','Payments')

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

    .btn-sm{
        border-radius:8px;
        padding:6px 10px;
    }

    .modal-header{
        background:#2563eb;
        color:#fff;
    }

    .btn-close{
        filter:invert(1);
    }

    .detail-table th{
        width:220px;
        background:#f8fafc;
        color:#374151;
    }
</style>

<div class="card shadow-sm border-0">

    <div class="card-header bg-white d-flex justify-content-between align-items-center">
        <div>
            <h5 class="mb-0 fw-bold">Payment Management</h5>
            <small class="text-muted">View all booking payments</small>
        </div>
    </div>

    <div class="card-body">

        <table id="paymentTable" class="table table-bordered table-hover align-middle w-100">
            <thead>
                <tr>
                    <th width="80">ID</th>
                    <th>User</th>
                    <th>Property</th>
                    <th>Amount</th>
                    <th>Method</th>
                    <th>Status</th>
                    <th width="100">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach($payments as $payment)
                    <tr>
                        <td>
                            <span class="text-success fw-bold">
                                #{{ $payment->id }}
                            </span>
                        </td>

                        <td>{{ $payment->user->name ?? 'N/A' }}</td>

                        <td>{{ $payment->booking->property->title ?? 'N/A' }}</td>

                        <td>₹{{ number_format($payment->amount, 2) }}</td>

                        <td>{{ $payment->payment_method }}</td>

                        <td>
                            <a href="{{ route('admin.payment.status', $payment->id) }}"
                            class="btn btn-sm
                            {{ $payment->payment_status == 'success' ? 'btn-success' : 'btn-warning' }}">
                                {{ ucfirst($payment->payment_status) }}
                            </a>
                        </td>

                        <td>
                            <button type="button"
                                class="btn btn-sm btn-primary"
                                data-bs-toggle="modal"
                                data-bs-target="#paymentModal{{ $payment->id }}">
                                <i class="fa-solid fa-eye"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</div>

@foreach($payments as $payment)

<div class="modal fade" id="paymentModal{{ $payment->id }}" tabindex="-1">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">
                <h5 class="mb-0">Payment Details</h5>

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <table class="table table-bordered detail-table mb-0">

                    <tr>
                        <th>User Name</th>
                        <td>{{ $payment->user->name ?? 'N/A' }}</td>
                    </tr>

                    <tr>
                        <th>Property</th>
                        <td>{{ $payment->booking->property->title ?? 'N/A' }}</td>
                    </tr>

                    <tr>
                        <th>Booking ID</th>
                        <td style="color: green">#{{ $payment->booking_id }}</td>
                    </tr>

                    <tr>
                        <th>Amount</th>
                        <td>₹{{ number_format($payment->amount, 2) }}</td>
                    </tr>

                    <tr>
                        <th>Payment Method</th>
                        <td>{{ $payment->payment_method }}</td>
                    </tr>

                    <tr>
                        <th>Payment Status</th>
                        <td>{{ ucfirst($payment->payment_status) }}</td>
                    </tr>

                    <tr>
                        <th>Paid On</th>
                        <td>{{ $payment->created_at->format('d M Y h:i A') }}</td>
                    </tr>

                </table>

            </div>

        </div>

    </div>

</div>

@endforeach

@endsection

@push('scripts')

<script>
$(function () {

    $('#paymentTable').DataTable({
        processing: true,
        serverSide: false,
        responsive: true,
        autoWidth: false,
        pageLength: 10,

        language: {
            search: "Search:",
            lengthMenu: "_MENU_ Entries per page",
            processing: "Loading payments...",
            emptyTable: "No Payment Found"
        }
    });

});
</script>

@endpush