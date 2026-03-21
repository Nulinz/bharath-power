@extends('admin.layouts.app')
@section('title', 'Report')
@section('content')
    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css"> --}}

    <main class="content">
        <div class="container-fluid p-0">
            <div class="row mb-xl-3 mb-2">
                <div class="d-none d-sm-block col-auto">
                    <h3><strong>Lead Management Report</strong></h3>
                </div>
            </div>

            <div class="row">
                {{-- report tabs --}}
                <div class="col-md-12 col-xl-12">
                    {{-- Acting driver Details --}}
                    <div class="card mb-3">
                        <div class="border-bottom bg-white p-3">
                            <form method="GET" action="{{ route('admin.reports.index') }}" class="row g-3 align-items-end">

                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
                                    <label for="start_date" class="form-label text-muted small fw-bold mb-1">Start Date</label>
                                    <input type="date" class="form-control form-control-sm" name="start_date" value="{{ request('start_date') }}">
                                </div>

                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
                                    <label for="end_date" class="form-label text-muted small fw-bold mb-1">End Date</label>
                                    <input type="date" class="form-control form-control-sm" name="end_date" value="{{ request('end_date') }}">
                                </div>

                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
                                    <label for="product_group" class="form-label text-muted small fw-bold mb-1">Product Group</label>
                                    <select class="form-select form-select-sm" name="product_group">
                                        <option value="">All</option>
                                        @foreach ($groups as $id => $name)
                                            <option value="{{ $id }}" {{ request('product_group') == $id ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
                                    <label for="product_id" class="form-label text-muted small fw-bold mb-1">Product</label>
                                    <select class="form-select form-select-sm" name="product_id">
                                        <option value="">All</option>
                                        @foreach ($products as $id => $name)
                                            <option value="{{ $id }}" {{ request('product_id') == $id ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
                                    <label for="assign_to" class="form-label text-muted small fw-bold mb-1">Assign To</label>
                                    <select class="form-select form-select-sm" name="assign_to">
                                        <option value="">All</option>
                                        @foreach ($users as $id => $name)
                                            <option value="{{ $id }}" {{ request('assign_to') == $id ? 'selected' : '' }}>
                                                {{ $name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
                                    <label class="form-label text-muted small fw-bold mb-1">Priority</label>
                                    <select id="priorityFilter" class="form-select form-select-sm" name="priority">
                                        <option value="">All</option>
                                        <option value="High" {{ request('priority') == 'High' ? 'selected' : '' }}>High</option>
                                        <option value="Medium" {{ request('priority') == 'Medium' ? 'selected' : '' }}>Medium</option>
                                        <option value="Low" {{ request('priority') == 'Low' ? 'selected' : '' }}>Low</option>
                                    </select>
                                </div>

                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
                                    <label for="enq_no" class="form-label text-muted small fw-bold mb-1">Enq No</label>
                                    <input type="text" class="form-control form-control-sm" name="enq_no" value="{{ request('enq_no') }}" placeholder="Enter No...">
                                </div>

                                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6 col-12">
                                    <div class="d-flex gap-2">
                                        <button type="submit" class="btn btn-primary btn-sm w-100" title="Apply Filter">
                                            <i class="fa fa-filter"></i> Filter
                                        </button>
                                        <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary btn-sm w-100" title="Reset Filters">
                                            <i class="fa fa-undo"></i> Reset
                                        </a>
                                    </div>
                                </div>

                            </form>
                        </div>
                        <div class="card-body">

                            <table class="table-striped table" id="datatables-reponsive">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Enq no</th>
                                        <th>Name</th>
                                        <th>Contact</th>
                                        {{-- <th>Address</th> --}}
                                        {{-- <th>Group</th> --}}
                                        <th>Product</th>
                                        <th>Qty</th>
                                        <th>UOM</th>
                                        <th>Assign to</th>
                                        <th>Lead Cycle</th>
                                        <th>Priority</th>
                                        <th>Status</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($enquiry as $eq)
                                        <tr onclick="window.location='{{ route('admin.enquiry.enquiry_view', $eq->id) }}'" style="cursor: pointer;">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $eq->enq_no }}</td>
                                            <td>{{ $eq->name }}</td>
                                            <td>{{ $eq->contact }}</td>
                                            {{-- <td>{{ $eq->enq_address }}</td> --}}
                                            {{-- <td>{{ $eq->group_name }}</td> --}}
                                            <td>{{ $eq->product_name }}</td>
                                            <td>{{ $eq->quantity }}</td>
                                            <td>{{ $eq->enq_uom }}</td>
                                            <td>{{ $eq->usr_name }}</td>
                                            <td>{{ $eq->lead_cycle }}</td>
                                            <td>
                                                @if ($eq->enq_priority === 'High')
                                                    <span class="badge bg-danger">
                                                        {{ $eq->enq_priority ?: 'N/A' }}
                                                    </span>
                                                @elseif ($eq->enq_priority === 'Medium')
                                                    <span class="badge bg-warning ms-1">
                                                        {{ $eq->enq_priority ?: 'N/A' }}
                                                    </span>
                                                @elseif ($eq->enq_priority === 'Low')
                                                    <span class="badge bg-secondary ms-1">
                                                        {{ $eq->enq_priority ?: 'N/A' }}
                                                    </span>
                                                @endif
                                            </td>
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

    {{-- <script>
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
    </script> --}}

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const startDate = "{{ request('start_date') ?? '' }}";
            const endDate = "{{ request('end_date') ?? '' }}";
            const productGroup = "{{ $groups[request('product_group')] ?? 'All' }}";
            const product = "{{ $products[request('product_id')] ?? 'All' }}";
            const assignedTo = "{{ $users[request('assign_to')] ?? 'All' }}";
            const enqNo = "{{ request('enq_no') ?? 'All' }}";

            let
                filterInfo = `Filters:
Start Date: ${startDate || 'All'} | 
End Date: ${endDate || 'All'} | 
Product Group: ${productGroup} | 
Product: ${product} | 
Assigned To: ${assignedTo} | 
Enquiry No: ${enqNo}`;

            $('#datatables-reponsive').DataTable({
                responsive: true,
                ordering: false,
                dom: 'Bfrtip',
                buttons: [{
                        extend: 'excelHtml5',
                        className: 'btn btn-success',
                        text: 'Export to Excel',
                        title: 'Lead Management Report', // ✅ This sets the Excel title
                        messageTop: filterInfo
                    },
                    {
                        extend: 'pdfHtml5',
                        className: 'btn btn-danger',
                        text: 'Export to PDF',
                        title: 'Lead Management Report', // ✅ This sets the PDF title
                        orientation: 'landscape',
                        pageSize: 'A4',
                        customize: function(doc) {
                            // Add filter info to PDF top
                            doc.content.splice(0, 0, {
                                text: filterInfo,
                                margin: [0, 0, 0, 12],
                                fontSize: 10
                            });

                            // Equal column widths
                            const table = doc.content.find(item => item.table);
                            if (table) {
                                const colCount = table.table.body[0].length;
                                table.table.widths = Array(colCount).fill('*');
                            }
                        }
                    }
                ]
            });
        });
    </script>

@endsection()
