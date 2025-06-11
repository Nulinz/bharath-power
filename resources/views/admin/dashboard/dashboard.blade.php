@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="d-flex align-items-center justify-content-between mb-2 mb-xl-3">
                <div class="">
                    <h3><strong>Dashboard</strong></h3>
                </div>

                <p class="fw-bold fs-4 mb-0"><span>Total Enquiry: </span>{{ $totalEnquiries }}</p>
            </div>
            {{-- basic cards --}}

            <div class="row">

                <div class="col-12 col-md-6 col-xl-3 d-flex">
                    <div class="card flex-fill" style="background-color: #ff015d">
                        <div class="card-body">
                            <a href="" class="text-decoration-none">
                                  <div class="d-flex justify-content-between align-items-center">
                                    <div class="mb-2">
                                        <h5 class="card-title text-white mb-0">Enquiry Received</h5>
                                        <h1 class="mt-2 mb-0 text-white">{{ $leadCycleCounts['Enquiry Received'] ?? 0 }}</h1>
                                    </div>

                                    <div class="">
                                        <img src="{{ asset('assets/icons/cover-letter.png') }}" height="55px" alt="">
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-3 d-flex">
                    <div class="card flex-fill" style="background-color: #fec000;">
                        <div class="card-body">
                            <a href="" class="text-decoration-none">
                                 <div class="d-flex justify-content-between align-items-center">
                                    <div class="mb-2">
                                        <h5 class="card-title text-white mb-0">Initial Contact</h5>
                                        <h1 class="mt-2 mb-0 text-white">{{ $leadCycleCounts['Initial Contact'] ?? 0 }}</h1>
                                    </div>

                                    <div class="">
                                        <img src="{{ asset('assets/icons/contact-information.png') }}" height="55px" alt="">
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-3 d-flex">
                    <div class="card flex-fill" style="background-color: #11a9b4">
                        <div class="card-body">
                            <a href="" class="text-decoration-none">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="mb-2">
                                        <h5 class="card-title text-white mb-0">Requirement Gathering</h5>
                                        <h1 class="mt-2 mb-0 text-white">{{ $leadCycleCounts['Requirement Gathering'] ?? 0 }}</h1>
                                    </div>

                                    <div class="">
                                        <img src="{{ asset('assets/icons/requirement.png') }}" height="55px"
                                            alt="">
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-3 d-flex">
                    <div class="card flex-fill" style="background-color: #683ab7;">
                        <div class="card-body">
                            <a href="" class="text-decoration-none">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="mb-2">
                                        <h5 class="card-title text-white mb-0">Product & Specs</h5>
                                        <h1 class="mt-2 mb-0 text-white">{{ $leadCycleCounts['Product Selection'] ?? 0 }}</h1>
                                    </div>

                                    <div class="">
                                        <img src="{{ asset('assets/icons/inspection.png') }}" height="55px" alt="">
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-3 d-flex">
                    <div class="card flex-fill" style="background-color: #0a813c;">
                        <div class="card-body">
                            <a href="" class="text-decoration-none">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="mb-2">
                                        <h5 class="card-title text-white mb-0">Quotation Preparation</h5>
                                        <h1 class="mt-2 mb-0 text-white">{{ $leadCycleCounts['Quotation'] ?? 0 }}</h1>
                                    </div>

                                    <div class="">
                                        <img src="{{ asset('assets/icons/quotation.png') }}" height="55px" alt="">
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-3 d-flex">
                    <div class="card flex-fill"  style="background-color: #1a4e89;">
                        <div class="card-body">
                            <a href="" class="text-decoration-none">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="mb-2">
                                        <h5 class="card-title text-white mb-0">Follow-up</h5>
                                        <h1 class="mt-2 mb-0 text-white">{{ $leadCycleCounts['Follow-up'] ?? 0 }}</h1>
                                    </div>

                                    <div class="">
                                        <img src="{{ asset('assets/icons/events.png') }}" height="55px" alt="">
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-3 d-flex">
                    <div class="card flex-fill"  style="background-color: #ed3799;">
                        <div class="card-body">
                            <a href="" class="text-decoration-none">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="mb-2">
                                        <h5 class="card-title text-white mb-0">Final Decision</h5>
                                        <h1 class="mt-2 mb-0 text-white">{{ $leadCycleCounts['Final Decision'] ?? 0 }}</h1>
                                    </div>

                                    <div class="">
                                        <img src="{{ asset('assets/icons/decision-making.png') }}" height="55px"
                                            alt="">
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                 <div class="col-12 col-md-6 col-xl-3 d-flex">
                    <div class="card flex-fill"  style="background-color: #e7522d;">
                        <div class="card-body">
                            <a href="" class="text-decoration-none">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="mb-2 ">
                                        <h5 class="card-title text-white mb-0">Cancelled</h5>
                                        <h1 class="mt-2 mb-0 text-white">{{ $leadCycleCounts['Cancelled'] ?? 0 }}</h1>
                                    </div>

                                    <div class="">
                                        <img src="{{ asset('assets/icons/file.png') }}" height="55px"
                                            alt="">
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>




            </div>
            {{-- altert table --}}
            <div class="row">
                <div class="col-lg-12">
                    <div class="card mb-4">
                        <div class="card-header text-white border-bottom border-2">
                            <h4 class="mb-0 fs-4 fw-semibold">Today's Reminder <span class="fs-3 text-danger">*</span>
                            </h4>
                        </div>
                        <div class="card-body">

                            <table id="datatables-reponsive" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Enquiry No</th>
                                        <th>Lead Cycle</th>
                                        <th>Assig to</th>
                                        <th style="width:20%;">Remarks</th>
                                        <th>Status</th>
                                        <th>Callback</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($todayTasks as $task)
                                        <tr style="cursor: pointer;"
                                            onclick="window.location='{{ route('admin.enquiry.enquiry_view', $task->enq_id) }}'">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $task->enq_no }}</td>
                                            <td>{{ $task->lead_cycle }}</td>
                                            <td>{{ $task->assign_to }}</td>
                                            <td>{{ $task->remarks }}</td>
                                            <td>
                                                @if ($task->status === 'completed')
                                                     <span class="badge badge-success-light">Completed</span>
                                                @elseif ($task->status === 'cancelled')
                                                    <span class="badge badge-danger-light">Cancelled</span>
                                                 @else
                                                    <span class="badge badge-warning-light">Pending</span>

                                                @endif
                                            </td>
                                            <td>{{ date('d-m-Y', strtotime($task->callback)) }}</td>
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
                "ordering": false,
                "lengthMenu": [
                    [5, 10, 25, 50, -1],
                    ['5', '10', '25', '50', 'All']
                ],
            });
        });
    </script>
@endsection()
