@extends('admin.layouts.app')
@section('title', 'View enquiry')
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="row mb-2 mb-xl-3">
                <div class="col-auto d-none d-sm-block">
                    <h3><strong>View Enquiry</strong></h3>
                </div>
            </div>
            <div class="row">
                {{-- enquiry-card --}}
                <div class="col-12 col-lg-6 col-xl-4">
                    <div class="card">
                        <div class="card-header border-bottom pb-1">
                            <h5 class="card-title text-dark">Basic Details</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h5 class="fs-6 text-muted mb-0 fw-bold">Enquiry Number</h5>
                                <p class="fs-6 text-dark mb-0">{{ $enquiry->enq_no ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h5 class="fs-6 text-muted mb-0 fw-bold">Name</h5>
                                <p class="fs-6 text-dark mb-0">{{ $enquiry->name ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="text-muted mb-0 fw-bold">Contact Number</h6>
                                <p class="text-dark mb-0">{{ $enquiry->contact ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="text-muted mb-0 fw-bold">Product Group</h6>
                                <p class="text-dark mb-0">{{ $enquiry->group_name ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="text-muted mb-0 fw-bold">Product</h6>
                                <p class="text-dark mb-0">{{ $enquiry->product_name ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="text-muted mb-0 fw-bold">Remarks</h6>
                                <p class="text-dark mb-0">{{ $enquiry->requirements ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="text-muted mb-0 fw-bold">Quantity</h6>
                                <p class="text-dark mb-0">{{ $enquiry->quantity ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="text-muted mb-0 fw-bold">UOM</h6>
                                <p class="text-dark mb-0">{{ $enquiry->enq_uom ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="text-muted mb-0 fw-bold">Capacity</h6>
                                <p class="text-dark mb-0">{{ $enquiry->enq_capacity ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="text-muted mb-0 fw-bold">Address</h6>
                                <p class="text-dark mb-0">{{ $enquiry->enq_address ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="text-muted mb-0 fw-bold">Location</h6>
                                <p class="text-dark mb-0">{{ $enquiry->location ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="text-muted mb-0 fw-bold">Source</h6>
                                <p class="text-dark mb-0">{{ $enquiry->source ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="text-muted mb-0 fw-bold">Leadcycle</h6>
                                <p class="text-dark mb-0 fw-bold">{{ $enquiry->lead_cycle ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="text-muted mb-0 fw-bold">Referred Name</h6>
                                <p class="text-dark mb-0">{{ $enquiry->enq_ref_name ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="text-muted mb-0 fw-bold">Reference Contact</h6>
                                <p class="text-dark mb-0">{{ $enquiry->enq_ref_contact ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <h6 class="text-muted mb-0 fw-bold">Status</h6>
                                <p class="text-dark mb-0">
                                    @if ($enquiry->status === 'completed')
                                        <span class="badge badge-success-light">Completed</span>
                                    @elseif ($enquiry->status === 'cancelled')
                                        <span class="badge badge-danger-light">Cancelled</span>
                                    @else
                                        <span class="badge badge-warning-light">Pending</span>
                                    @endif
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header border-bottom pb-1">
                            <h5 class="card-title text-dark">File Details</h5>
                        </div>
                        <div class="card-body">
                            @foreach ($task as $t)
                                @if ($t->quote)
                                    <article
                                        class="d-flex justify-content-between align-items-center my-2 border p-2 bg-light rounded-3 qc-card">
                                        <div>
                                            <h5 class="card-title text-muted fw-bold mb-0">{{ $t->quote }}</h5>
                                            <p class="mt-1 mb-0 text-muted fw-semibold"><span>Value: </span>
                                                {{ $t->value }}</p>
                                            <p class="mb-0">
                                                <small>{{ \Carbon\Carbon::parse($t->created_at)->format('d/m/Y') }}</small>
                                            </p>
                                        </div>
                                        <a href="{{ asset('assets/quote_files/' . $t->quote) }}" target="_blank">
                                            <i class="text-success fs-3 fa fa-fw fa-download"></i>
                                        </a>
                                    </article>
                                @endif

                                 @if ($t->cancel_upload)
                                  <article
                                        class="d-flex justify-content-between align-items-center my-2 border p-2 bg-light rounded-3 qc-card">
                                        <div>
                                            <h5 class="card-title text-muted fw-bold mb-0">{{ $t->cancel_upload }}</h5>
                                            <p class="mb-0">
                                                <small>{{ \Carbon\Carbon::parse($t->created_at)->format('d/m/Y') }}</small>
                                            </p>
                                        </div>
                                        <a href="{{ asset('assets/quote_files/' . $t->quote) }}" target="_blank">
                                            <i class="text-success fs-3 fa fa-fw fa-download"></i>
                                        </a>
                                    </article>
                                  @endif
                            @endforeach

                        </div>
                    </div>

                </div>

                {{-- progress --}}
                <div class="col-12 col-lg-6 col-xl-4">
                    <div class="card">
                        <div class="card-header border-bottom pb-1 d-flex align-items-center justify-content-between">
                            <h5 class="card-title text-dark">Progress</h5>
                            <h4>{{ $enquiry->enq_no }}</h4>
                        </div>
                        <div class="card-body" style="overflow-y: auto; max-height: 530px;">

                            <ul class="timeline mt-2 mb-0 ps-4">
                                {{-- <li class="timeline-item">
                                    <div class="bg-primary d-flex justify-content-between align-items-center p-2">
                                        <strong class="text-white">{{ $enquiry->lead_cycle }}</strong>

                                        <span class="text-white text-sm fw-normal">{{{ date("d-m-Y",strtotime($enquiry->updated_at)); }}}</span>
                                    </div>

                                    <div class="card-body p-3">
                                        <p class="fw-bold mb-0">Details: <span class="fw-normal ms-1">Rsdv.lklsdaghu</span>
                                        </p>
                                        <p class="fw-bold mb-0">Created by: <span class="fw-normal ms-1"></span></p>
                                        <p class="fw-bold mb-0">Created on: <span class="fw-normal ms-1">{{ date("d-m-Y", strtotime($enquiry->created_at)); }}</span></p
                                    </div>
                                </li> --}}
                                @if ($task)
                                    @foreach ($task as $tak)
                                        <li class="timeline-item">
                                            <div class="tl-bg d-flex justify-content-between align-items-center p-2">
                                                <strong class="text-white">{{ $tak->lead_cycle }}</strong>
                                                <span
                                                    class="text-white text-sm fw-bold">{{ date('d-m-Y', strtotime($tak->created_at)) }}</span>
                                            </div>
                                            <div class="card-body p-3">
                                                <!-- task details -->
                                                <p class="fw-bold mb-0">Assigned to: <span
                                                        class="fw-normal ms-1">{{ $enquiry->assigned_user_name }}</span>
                                                </p>

                                                <p class="fw-bold mb-0">Remarks: <span
                                                        class="fw-normal ms-1">{{ $tak->remarks ?? 'Not added' }}</span>
                                                </p>
                                                <p class="fw-bold mb-0">Created by: <span
                                                        class="fw-normal ms-1">{{ $tak->created_by_name ?? 'NA' }}</span>
                                                </p>

                                            </div>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- task --}}
                <div class="col-12 col-xl-4">
                    <div class="card">
                        <div class="card-header border-bottom pb-1">
                            <h5 class="card-title text-dark">Task</h5>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.enquiry.submit_task') }}" method="POST" id="myForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="enqid" value="{{ $enquiry->enq_id }}">
                            <input type="hidden" name="enqno" value="{{ $enquiry->enq_no }}">
                            <input type="hidden" name="pro_id" value="{{ $enquiry->product_category }}">
                            <input type="hidden" name="user_id" value="{{ $user_id }}">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Assigned Employee</label>
                                <input type="test" disabled class="form-control" placeholder=""
                                    value="{{ $enquiry->assigned_user_name }}">
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Remarks</label>
                                <textarea class="form-control" name="remarks" id="" rows="2" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold">Lead cycle</label>
                                <select class="form-select" name="lead_cycle" id="inter" required>
                                    <option value="" selected disabled>Select Option</option>
                                    <option value="Enquiry Received">Enquiry Received</option>
                                    <option value="Initial Contact">Initial Contact</option>
                                    <option value="Requirement Gathering">Requirement Gathering</option>
                                    <option value="Product Selection">Product & Specification Selection</option>
                                    <option value="Quotation">Quotation Submission</option>
                                    <option value="Follow-up">Follow-up</option>
                                    <option value="Final Decision">Final Decision</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>
                            </div>

                            <div class="mb-3 inter-cal" style="display: none;">
                                <label class="form-label fw-bold">Reason for cancel</label>
                                <input type="test" name="cancel" class="form-control" placeholder="">
                            </div>

                            <div class="mb-3 inter-cal" style="display: none;">
                                <label class="form-label fw-bold">Upload</label>
                                <input type="file" name="cancel_upload" class="form-control">
                            </div>

                            <div class="mb-3 inter-det" style="display: none;">
                                <label class="form-label fw-bold">Upload Quote</label>
                                <input type="file" name="quote" class="form-control">
                            </div>

                            <div class="mb-3 inter-det" style="display: none;">
                                <label class="form-label fw-bold">Quote Value</label>
                                <input type="text" name="quote_value" class="form-control">
                            </div>


                            <div class="mb-3 inputs inter-det" style="display: none;">
                                <label class="form-label fw-bold">Purchase Group</label>
                                <select class="form-select" name="Purchase_group" id="inter">
                                    <option selected disabled>Select Option</option>
                                    <option value="Group1">Group 1</option>
                                    <option value="Group2">Group 2</option>
                                    <option value="Group3">Group 3</option>
                                    <option value="Group4">Group 4</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Callback</label>
                                <input type="date" class="form-control" name="callback" placeholder="" required>
                            </div>

                            <button type="submit" id="submitBtn" class="btn btn-primary w-100 mt-2">Submit</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#inter').change(function() {
                if ($(this).val() === 'Quotation') {
                    $('.inter-det').show();
                } else {
                    $('.inter-det').hide();
                }
            });

            $('#inter').change(function() {
                if ($(this).val() === 'Cancelled') {
                    $('.inter-cal').show();
                } else {
                    $('.inter-cal').hide();
                }
            });
        });
    </script>
    <script src="{{ asset('assets/js/disable.js') }}"></script>

    {{-- SUCCESS TOAST --}}
    @if (session('message'))
        <div aria-live="polite" aria-atomic="true" class="position-relative" style="z-index: 1100;">
            <div class="toast-container position-fixed top-0 end-0 p-3">
                <div class="toast align-items-center text-bg-success border-0 show" role="alert" aria-live="assertive"
                    aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ session('message') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- ERROR TOAST --}}
    @if ($errors->has('message_error'))
        <div aria-live="polite" aria-atomic="true" class="position-relative" style="z-index: 1100;">
            <div class="toast-container position-fixed top-0 end-0 p-3">
                <div class="toast align-items-center text-bg-danger border-0 show" role="alert" aria-live="assertive"
                    aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ $errors->first('message_error') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var toastEl = document.getElementById('successToast');
            // var toast = new bootstrap.Toast(toastEl);
            // toast.show();
        });
    </script>
@endsection()
