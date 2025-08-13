@extends('admin.layouts.app')
@section('title', 'Enquiry List')
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="row mb-xl-3 mb-2">
                <div class="d-none d-sm-block col-auto">
                    <h3><strong>Sales Lead Cycle </strong></h3>
                </div>
            </div>

            <div class="row">
                {{-- report tabs --}}
                <div class="col-md-12 col-xl-12">
                    {{-- Acting driver Details --}}
                    <div class="card mb-3">
                        <div class="d-flex align-items-center justify-content-between border-bottom p-3">
                            <h5 class="card-title mb-0">{{ $cycle }} </h5>

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
                                        {{-- <th>Group</th> --}}
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
                                    @foreach ($enquiries as $eq)
                                        <tr onclick="window.location='{{ route('admin.enquiry.enquiry_view', $eq->id) }}'" style="cursor: pointer;">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $eq->enq_no }}</td>
                                            <td>{{ $eq->name }}</td>
                                            <td>{{ $eq->contact }}</td>
                                            <td>{{ $eq->enq_address }}</td>
                                            {{-- <td>{{ $eq->group_name }}</td> --}}
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
                                            {{-- <td><i class="fs-4 text-dark fa fa-external-link-alt"></i></td> --}}
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
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Datatables Responsive
            $("#datatables-reponsive").DataTable({
                responsive: true,
                "ordering": false
            });
        });
    </script>
@endsection()
