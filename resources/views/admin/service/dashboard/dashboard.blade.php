@extends('admin.service.layouts.app')
@section('title', 'Dashboard')
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="d-flex align-items-center justify-content-between mb-xl-3 mb-2">
                <div class="d-flex align-items-center">
                    <h3 class="m-0"><strong>Service Dashboard</strong></h3>
                    <a href="{{ route('admin.dashboard.dashboard') }}" class="btn btn-outline-dark ms-3">Enquiry Dashboard</a>
                </div>

                <p class="fw-bold fs-4 mb-0"><span>Total Enquiry: </span>{{ $totalEnquiries }}</p>
            </div>
            {{-- basic cards --}}

            <div class="row">

                <div class="col-12 col-md-6 col-xl-3 d-flex">
                    <div class="card flex-fill" style="background-color: #ff015d">
                        <div class="card-body">
                            <a href="{{ route('admin.service.enquiry.byCycle', ['cycle' => 'Enquiry Received']) }}" class="text-decoration-none">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="mb-2">
                                        <h5 class="card-title mb-0 text-white">Enquiry Received</h5>
                                        <h1 class="mb-0 mt-2 text-white">{{ $leadCycleCounts['Enquiry Received'] ?? 0 }}
                                        </h1>
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
                            <a href="{{ route('admin.service.enquiry.byCycle', ['cycle' => 'Initial Contact']) }}" class="text-decoration-none">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="mb-2">
                                        <h5 class="card-title mb-0 text-white">Initial Contact</h5>
                                        <h1 class="mb-0 mt-2 text-white">{{ $leadCycleCounts['Initial Contact'] ?? 0 }}</h1>
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
                            <a href="{{ route('admin.service.enquiry.byCycle', ['cycle' => 'Requirement Gathering']) }}" class="text-decoration-none">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="mb-2">
                                        <h5 class="card-title mb-0 text-white">Requirement Gathering</h5>
                                        <h1 class="mb-0 mt-2 text-white">
                                            {{ $leadCycleCounts['Requirement Gathering'] ?? 0 }}</h1>
                                    </div>

                                    <div class="">
                                        <img src="{{ asset('assets/icons/requirement.png') }}" height="55px" alt="">
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-3 d-flex">
                    <div class="card flex-fill" style="background-color: #683ab7;">
                        <div class="card-body">
                            <a href="{{ route('admin.service.enquiry.byCycle', ['cycle' => 'Product Selection']) }}" class="text-decoration-none">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="mb-2">
                                        <h5 class="card-title mb-0 text-white">Product & Specs</h5>
                                        <h1 class="mb-0 mt-2 text-white">{{ $leadCycleCounts['Product Selection'] ?? 0 }}
                                        </h1>
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
                    <div class="card flex-fill" style="background-color: #ff9a00;">
                        <div class="card-body">
                            <a href="{{ route('admin.service.enquiry.byCycle', ['cycle' => 'Quotation Preparation']) }}" class="text-decoration-none">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="mb-2">
                                        <h5 class="card-title mb-0 text-white">Quotation Preparation</h5>
                                        <h1 class="mb-0 mt-2 text-white">
                                            {{ $leadCycleCounts['Quotation Preparation'] ?? 0 }}</h1>
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
                    <div class="card flex-fill" style="background-color: #e7522d;">
                        <div class="card-body">
                            <a href="{{ route('admin.service.enquiry.byCycle', ['cycle' => 'Quotation']) }}" class="text-decoration-none">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="mb-2">
                                        <h5 class="card-title mb-0 text-white">Quotation Submission</h5>
                                        <h1 class="mb-0 mt-2 text-white">{{ $leadCycleCounts['Quotation'] ?? 0 }}</h1>
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
                    <div class="card flex-fill" style="background-color: #9f22b2 ;">
                        <div class="card-body">
                            <a href="{{ route('admin.service.enquiry.byCycle', ['cycle' => 'Follow-up']) }}" class="text-decoration-none">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="mb-2">
                                        <h5 class="card-title mb-0 text-white">Follow-up</h5>
                                        <h1 class="mb-0 mt-2 text-white">{{ $leadCycleCounts['Follow-up'] ?? 0 }}</h1>
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
                    <div class="card flex-fill" style="background-color: #2dc60d;">
                        <div class="card-body">
                            <a href="{{ route('admin.service.enquiry.byCycle', ['cycle' => 'Order confimred']) }}" class="text-decoration-none">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="mb-2">
                                        <h5 class="card-title mb-0 text-white">Order confimred </h5>
                                        <h1 class="mb-0 mt-2 text-white">{{ $leadCycleCounts['Order confimred'] ?? 0 }}
                                        </h1>
                                    </div>

                                    <div class="">
                                        <img src="{{ asset('assets/icons/booking.png') }}" height="55px" alt="">
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-3 d-flex">
                    <div class="card flex-fill" style="background-color: #7a5548;">
                        <div class="card-body">
                            <a href="{{ route('admin.service.enquiry.byCycle', ['cycle' => 'Material supplied partially']) }}" class="text-decoration-none">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="mb-2">
                                        <h5 class="card-title mb-0 text-white">Material supplied – partially </h5>
                                        <h1 class="mb-0 mt-2 text-white">
                                            {{ $leadCycleCounts['Material supplied partially'] ?? 0 }}</h1>
                                    </div>

                                    <div class="">
                                        <img src="{{ asset('assets/icons/trolley.png') }}" height="55px" alt="">
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-3 d-flex">
                    <div class="card flex-fill" style="background-color: #3d50b6;">
                        <div class="card-body">
                            <a href="{{ route('admin.service.enquiry.byCycle', ['cycle' => 'Material supplied final-full']) }}" class="text-decoration-none">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="mb-2">
                                        <h5 class="card-title mb-0 text-white">Material supplied – final/full </h5>
                                        <h1 class="mb-0 mt-2 text-white">
                                            {{ $leadCycleCounts['Material supplied final-full'] ?? 0 }}</h1>
                                    </div>

                                    <div class="">
                                        <img src="{{ asset('assets/icons/supply.png') }}" height="55px" alt="">
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-3 d-flex">
                    <div class="card flex-fill" style="background-color: #00988b;">
                        <div class="card-body">
                            <a href="{{ route('admin.service.enquiry.byCycle', ['cycle' => 'Payment received partial']) }}" class="text-decoration-none">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="mb-2">
                                        <h5 class="card-title mb-0 text-white">Payment received partial </h5>
                                        <h1 class="mb-0 mt-2 text-white">
                                            {{ $leadCycleCounts['Payment received partial'] ?? 0 }}</h1>
                                    </div>

                                    <div class="">
                                        <img src="{{ asset('assets/icons/payment.png') }}" height="55px" alt="">
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-3 d-flex">
                    <div class="card flex-fill" style="background-color: #0a813c;">
                        <div class="card-body">
                            <a href="{{ route('admin.service.enquiry.byCycle', ['cycle' => 'Payment received final-full']) }}" class="text-decoration-none">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="mb-2">
                                        <h5 class="card-title mb-0 text-white">Payment received final/full </h5>
                                        <h1 class="mb-0 mt-2 text-white">
                                            {{ $leadCycleCounts['Payment received final-full'] ?? 0 }}</h1>
                                    </div>

                                    <div class="">
                                        <img src="{{ asset('assets/icons/hand.png') }}" height="55px" alt="">
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-3 d-flex">
                    <div class="card flex-fill" style="background-color: #ed3799;">
                        <div class="card-body">
                            <a href="{{ route('admin.service.enquiry.byCycle', ['cycle' => 'Final Decision']) }}" class="text-decoration-none">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="mb-2">
                                        <h5 class="card-title mb-0 text-white">Final Decision</h5>
                                        <h1 class="mb-0 mt-2 text-white">{{ $leadCycleCounts['Final Decision'] ?? 0 }}
                                        </h1>
                                    </div>

                                    <div class="">
                                        <img src="{{ asset('assets/icons/decision-making.png') }}" height="55px" alt="">
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-3 d-flex">
                    <div class="card flex-fill" style="background-color: #e6151f">
                        <div class="card-body">
                            <a href="{{ route('admin.service.enquiry.byCycle', ['cycle' => 'Cancelled']) }}" class="text-decoration-none">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="mb-2">
                                        <h5 class="card-title mb-0 text-white">Cancelled</h5>
                                        <h1 class="mb-0 mt-2 text-white">{{ $leadCycleCounts['Cancelled'] ?? 0 }}</h1>
                                    </div>

                                    <div class="">
                                        <img src="{{ asset('assets/icons/file.png') }}" height="55px" alt="">
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-3 d-flex">
                    <div class="card flex-fill" style="background-color: #04b5f3">
                        <div class="card-body">
                            <a href="{{ route('admin.service.enquiry.byCycle', ['cycle' => 'Service Entry']) }}" class="text-decoration-none">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="mb-2">
                                        <h5 class="card-title mb-0 text-white">Service Entry</h5>
                                        <h1 class="mb-0 mt-2 text-white">{{ $leadCycleCounts['Service Entry'] ?? 0 }}</h1>
                                    </div>

                                    <div class="">
                                        <img src="{{ asset('assets/icons/internet.png') }}" height="55px" alt="">
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
                        <div class="card-header border-bottom border-2 text-white">
                            <h4 class="fs-4 fw-semibold mb-0">Today's Reminder <span class="fs-3 text-danger">*</span>
                            </h4>
                        </div>
                        <div class="card-body">

                            <table id="datatables-reponsive" class="table-striped table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Enquiry No</th>
                                        <th>Lead Cycle</th>
                                        <th>Assign to</th>
                                        <th style="width:20%;">Remarks</th>
                                        <th>Status</th>
                                        <th>Callback</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($todayTasks as $task)
                                        <tr style="cursor: pointer;" onclick="window.location='{{ route('admin.enquiry.enquiry_view', $task->enq_id) }}'">
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
