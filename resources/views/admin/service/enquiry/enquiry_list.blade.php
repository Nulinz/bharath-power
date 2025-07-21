@extends('admin.service.layouts.app')
@section('title', 'Enquiry List')
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="row mb-xl-3 mb-2">
                <div class="d-none d-sm-block col-auto">
                    <h3><strong>Service Enquiry List</strong></h3>
                </div>
            </div>

            <div class="row">
                {{-- report tabs --}}
                <div class="col-md-12 col-xl-12">
                    {{-- Acting driver Details --}}
                    <div class="card mb-3">

                        <div class="d-flex align-items-center justify-content-between border-bottom p-3">

                            <div class="row">
                                <div class="col-md-4">
                                    <label class="form-label">Assign To</label>
                                    <select id="assignFilter" class="form-select">
                                        <option value="">All</option>
                                        @foreach ($enquiry->pluck('usr_name')->unique() as $assign)
                                            <option value="{{ $assign }}">{{ $assign }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Lead Cycle</label>
                                    <select id="leadCycleFilter" class="form-select">
                                        <option value="">All</option>
                                        @foreach ($enquiry->pluck('lead_cycle')->unique() as $cycle)
                                            <option value="{{ $cycle }}">{{ $cycle }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label">Date</label>
                                    <input type="date" id="dateFilter" class="form-control">
                                </div>
                            </div>

                            <a href="{{ route('admin.service.enquiry.add_enquiry') }}" class="btn btn-primary btn-md"><i class="fa fa-fw fa-plus align-middle"></i> Add Enquiry</a>

                        </div>

                        <div class="card-body">
                            <table id="datatables-reponsive" class="table-striped table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Enq no</th>
                                        <th>Name</th>
                                        <th>Contact</th>
                                        <th>Address</th>
                                        <th>Group</th>
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>Assign to</th>
                                        <th>Lead Cycle</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody class="">

                                    @foreach ($enquiry as $eq)
                                        <tr onclick="window.location='{{ route('admin.service.enquiry.enquiry_view', $eq->id) }}'" style="cursor: pointer;">

                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $eq->enq_no }}</td>
                                            <td>{{ $eq->name }}</td>
                                            <td>{{ $eq->contact }}</td>
                                            <td>{{ $eq->enq_address }}</td>
                                            <td>{{ $eq->group_name }}</td>
                                            <td>{{ $eq->product_name }}</td>
                                            <td>{{ $eq->quantity }}</td>
                                            <td>{{ $eq->usr_name }}</td>
                                            <td>{{ $eq->lead_cycle }}</td>
                                            <td>

                                                @if ($eq->status === 'completed')
                                                    <span class="badge badge-success-light">Completed</span>
                                                @elseif ($eq->status === 'cancelled')
                                                    <span class="badge badge-danger-light">Cancelled</span>
                                                @else
                                                    <span class="badge badge-warning-light">Pending</span>
                                                @endif
                                            </td>
                                            <td>{{ date('d-m-Y', strtotime($eq->created_at)) }}</td>
                                            {{-- <td>
                                               

                                                {{-- <a href="del_enquiry"> --}}
                                            {{-- <i class="fa fa-arrow-up-right-from-square  text-dark ms-2"></i></a> --}}
                                            {{-- </td> --}}
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>

    {{-- SUCCESS TOAST --}}
    @if (session('message'))
        <div aria-live="polite" aria-atomic="true" class="position-relative" style="z-index: 1100;">
            <div class="toast-container position-fixed end-0 top-0 p-3">
                <div class="toast align-items-center text-bg-success show border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session('message') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white m-auto me-2" data-bs-dismiss="toast" aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    {{-- <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Datatables Responsive
            $("#datatables-reponsive").DataTable({
                responsive: true,
                "ordering": true
            });
        });
    </script> --}}
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            let table = $('#datatables-reponsive').DataTable({
                responsive: true,
                ordering: true
            });

            // Custom filtering function
            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                let assign = $('#assignFilter').val().toLowerCase();
                let lead = $('#leadCycleFilter').val().toLowerCase();
                let filterDate = $('#dateFilter').val(); // yyyy-mm-dd
                let rowAssign = data[8]?.toLowerCase() || '';
                let rowLead = data[9]?.toLowerCase() || '';
                let rowDate = data[11]?.trim(); // dd-mm-yyyy

                // Convert dd-mm-yyyy → yyyy-mm-dd
                let parts = rowDate.split('-');
                let rowDateFormatted = parts.length === 3 ? `${parts[2]}-${parts[1]}-${parts[0]}` : '';

                let assignMatch = !assign || rowAssign === assign;
                let leadMatch = !lead || rowLead === lead;
                let dateMatch = !filterDate || rowDateFormatted === filterDate;

                return assignMatch && leadMatch && dateMatch;
            });

            // Trigger redraw on change
            $('#assignFilter, #leadCycleFilter, #dateFilter').on('change', function() {
                table.draw();
            });
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toastEl = document.getElementById('successToast');
            // var toast = new bootstrap.Toast(toastEl);
            // toast.show();
        });
    </script>
@endsection()
