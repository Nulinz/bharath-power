@extends('user.layouts.app')
@section('title', 'Report')
@section('content')
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"> --}}

    <main class="content">
        <div class="container-fluid p-0">
            <div class="row mb-2 mb-xl-3">
                <div class="col-auto d-none d-sm-block">
                    <h3><strong>Report</strong></h3>
                </div>
            </div>

            <div class="row">
                {{-- report tabs --}}
                <div class="col-md-12 col-xl-12">
                    {{-- Acting driver Details --}}
                    <div class="card mb-3">
                        <div class="border-bottom p-3">
                            <form method="GET" action="{{ route('user.reports.index') }}" class="d-flex flex-wrap gap-2">
                                <div class="flex-fill">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" class="form-control w-100" name="start_date"
                                        value="{{ request('start_date') }}">
                                </div>

                                <div class="flex-fill">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" class="form-control w-100" name="end_date"
                                        value="{{ request('end_date') }}">
                                </div>

                                <div class="flex-fill">
                                    <label for="product_group" class="form-label">Product Group</label>
                                    <select class="form-control w-100" name="product_group">
                                        <option value="">All</option>
                                        @foreach ($groups as $id => $name)
                                            <option value="{{ $id }}"
                                                {{ request('product_group') == $id ? 'selected' : '' }}>{{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="flex-fill">
                                    <label for="product_id" class="form-label">Product</label>
                                    <select class="form-control w-100" name="product_id">
                                        <option value="">All</option>
                                        @foreach ($products as $id => $name)
                                            <option value="{{ $id }}"
                                                {{ request('product_id') == $id ? 'selected' : '' }}>{{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="flex-fill">
                                    <label for="enq_no" class="form-label">Enquiry No</label>
                                    <input type="text" class="form-control w-100" name="enq_no"
                                        value="{{ request('enq_no') }}">
                                </div>

                                <div class="flex-fill d-flex align-self-end gap-2">
                                    <button type="submit" class="btn btn-primary w-100"><i class="fa fa-filter" aria-hidden="true"></i></button>
                                    <a href="{{ route('user.reports.index') }}" class="btn btn-secondary w-100"><i class="fa fa-undo"></i></a>
                                </div>
                            </form>
                        </div>

                        <div class="card-body">

                            <table class="table table-striped" id="datatables-reponsive">
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
                                        <th>Assig to</th>
                                        <th>Lead Cycle</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($enquiry as $eq)
                                        <tr onclick="window.location='{{ route('user.enquiry.enquiry_view', $eq->id) }}'"
                                            style="cursor: pointer;">
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
                                                    <span class="badge bg-success">Completed</span>
                                                @elseif ($eq->status === 'cancelled')
                                                    <span class="badge bg-danger">Cancelled</span>
                                                @else
                                                    <span class="badge bg-warning">Pending</span>
                                                @endif
                                            </td>
                                            <td>{{ date('d-m-Y', strtotime($eq->created_at)) }}</td>
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
    {{-- <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script> --}}
    {{-- <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            $('#datatables-reponsive').DataTable({
                responsive: true,
                ordering: false,
                dom: 'Bfrtip', // IMPORTANT: required for button layout
                buttons: [{
                        extend: 'excelHtml5',
                        className: 'btn btn-success',
                        text: 'Export to Excel'
                    },
                    {
                        extend: 'pdfHtml5',
                        className: 'btn btn-danger',
                        text: 'Export to PDF',
                        orientation: 'landscape',
                        pageSize: 'A4'
                    }
                ]
            });
        });
    </script>


@endsection()
