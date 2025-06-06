@extends('admin.layouts.app')
@section('title','Enquiry List')
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="row mb-2 mb-xl-3">
                <div class="col-auto d-none d-sm-block">
                    <h3><strong>Enquiry List</strong></h3>
                </div>
            </div>

            <div class="row">
                {{-- report tabs --}}
                <div class="col-md-12 col-xl-12">
                            {{-- Acting driver Details --}}
                            <div class="card mb-3">
                                <div class="d-flex align-items-center justify-content-between border-bottom p-3">
                                    <h5 class="card-title mb-0">Enquiry Driver</h5>
                                    <a href="{{ route('admin.enquiry.add_enquiry') }}" class="btn btn-primary btn-md">Add Enquiry</a>
                                </div>
                                <div class="card-body">
                                    <table id="datatables-reponsive" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Enq number</th>
                                                <th>Name</th>
                                                <th>Product</th>
                                                <th>Qty</th>
                                                <th>Contact Number</th>
                                                <th>Location</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                {{-- <th>Action</th> --}}
                                            </tr>
                                        </thead>
                                        <tbody class="">
                                             @foreach ($enquiry as $eq)

                                             <tr onclick="window.location='{{ route('admin.enquiry.enquiry_view', $eq->id) }}'" style="cursor: pointer;">
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $eq->enq_no }}</td>
                                                <td>{{ $eq->name }}</td>
                                                <td>{{ $eq->product_name }}</td>
                                                <td>{{ $eq->quantity }}</td>
                                                <td>{{ $eq->contact }}</td>
                                                <td>{{ $eq->location }}</td>
                                                <td>
                                                @if ( $eq->status == 'pending' )
                                                    <span class="badge badge-success-light">Pending</span>
                                                @else
                                                    <span class="badge badge-danger-light">Completed</span>
                                                @endif
                                                </td>
                                                <td>{{ date('d-m-Y',strtotime($eq->created_at)) }}</td>
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