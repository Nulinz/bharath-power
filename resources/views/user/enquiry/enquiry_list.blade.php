@extends('user.layouts.app')
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
                                    <a href="{{ route('user.enquiry.add_enquiry') }}" class="btn btn-primary btn-md">Add Enquiry</a>
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
                                            </tr>
                                        </thead>
                                        <tbody class="">
                                            @foreach ($enquiry as $eq)
                                           <tr onclick="window.location='{{ route('user.enquiry.enquiry_view', $eq->id) }}'" style="cursor: pointer;">
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

    @if (session('message'))
        <div aria-live="polite" aria-atomic="true" class="position-relative" style="min-height: 100px;">
            <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100;">
                <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert"
                    aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body text-white">
                            {{ session('message') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var toastEl = document.getElementById('successToast');
                var toast = new bootstrap.Toast(toastEl);
                toast.show();
            });
        </script>
    @endif
@endsection()
