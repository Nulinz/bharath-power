@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="row mb-2 mb-xl-3">
                <div class="col-auto d-none d-sm-block">
                    <h3><strong>Dashboard</strong></h3>
                </div>
            </div>
            {{-- basic cards --}}
            <div class="row">

                <div class="col-12 col-md-6 col-xl-3 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body cd-aft">
                            <a href="" class="text-decoration-none">
                                <div class="row">
                                    <div class="col mb-2">
                                        <h5 class="card-title mb-0">Enquiry Received</h5>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    {{-- <h3 class="mt-2 mb-0 pb-0 fw-bold"> 53,252</h3> --}}
                                    <h1 class="mt-1 mb-0">{{ $leadCycleCounts['Enquiry Received'] ?? 0 }}</h1>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-3 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body cd-aft">
                            <a href="" class="text-decoration-none">
                                <div class="row">
                                    <div class="col mb-2">
                                        <h5 class="card-title mb-0">Initial Contact</h5>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <h1 class="mt-1 mb-0">{{ $leadCycleCounts['Initial Contact'] ?? 0 }}</h1>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-3 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body cd-aft">
                            <a href="" class="text-decoration-none">
                                <div class="row">
                                    <div class="col mb-2">
                                        <h5 class="card-title mb-0">Requirement Gathering</h5>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <h1 class="mt-1 mb-0">{{ $leadCycleCounts['Requirement Gathering'] ?? 0 }}</h1>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-3 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body cd-aft">
                            <a href="" class="text-decoration-none">
                                <div class="row">
                                    <div class="col mb-2">
                                        <h5 class="card-title mb-0">Product & Specification Selection</h5>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <h1 class="mt-1 mb-0">{{ $leadCycleCounts['Product & Specification Selection'] ?? 0 }}
                                    </h1>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-3 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body cd-aft">
                            <a href="" class="text-decoration-none">
                                <div class="row">
                                    <div class="col mb-2">
                                        <h5 class="card-title mb-0">Quotation Preparation</h5>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <h1 class="mt-1 mb-0">{{ $leadCycleCounts['Quotation Preparation'] ?? 0 }}</h1>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-3 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body cd-aft">
                            <a href="" class="text-decoration-none">
                                <div class="row">
                                    <div class="col mb-2">
                                        <h5 class="card-title mb-0">Quotation Submission </h5>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <h1 class="mt-1 mb-0">{{ $leadCycleCounts['Quotation Submission'] ?? 0 }}</h1>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-xl-3 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body cd-aft">
                            <a href="" class="text-decoration-none">
                                <div class="row">
                                    <div class="col mb-2">
                                        <h5 class="card-title mb-0">Follow-up</h5>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <h1 class="mt-1 mb-0">{{ $leadCycleCounts['Follow-up'] ?? 0 }}</h1>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-6 col-xl-3 d-flex">
                    <div class="card flex-fill">
                        <div class="card-body cd-aft">
                            <a href="" class="text-decoration-none">
                                <div class="row">
                                    <div class="col mb-2">
                                        <h5 class="card-title mb-0">Final Decision</h5>
                                    </div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <h1 class="mt-1 mb-0">{{ $leadCycleCounts['Final Decision'] ?? 0 }}</h1>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-lg-6">
                    <div class="card mb-4">
                        <div class="card-header text-white border-bottom border-2">
                            <h4 class="mb-0 fs-4 fw-semibold">Today's Reminder <span class="fs-3 text-danger">*</span></h4>
                        </div>
                        <div class="card-body">

                            <table id="datatables-reponsive" class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Enquiry No</th>
                                        <th>Lead Cycle</th>
                                        <th>Remarks</th>
                                        <th>Callback</th>

                                    </tr>
                                </thead>
                                <tbody class="">
                                    @foreach ($todayTasks as $task)
                                         @foreach ($todayTasks as $task)
                                        <tr style="cursor: pointer;">
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $task->enq_no }}</td>
                                            <td>{{ $task->lead_cycle }}</td>
                                            <td>{{ $task->remarks }}</td>
                                            <td>{{ date('d-m-Y', strtotime($task->callback)) }}</td>
                                        </tr>
                                    @endforeach
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
