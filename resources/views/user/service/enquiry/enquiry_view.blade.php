@extends('user.service.layouts.app')
@section('title', 'View enquiry')
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="row mb-xl-3 mb-2">
                <div class="d-none d-sm-block col-auto">
                    <h3><strong>View Service Enquiry</strong></h3>
                </div>
            </div>
            <div class="row">
                {{-- enquiry-card --}}
                <div class="col-12 col-lg-6 col-xl-4">
                    <div class="card">
                        <div class="card-header border-bottom pb-1">
                            <div class="d-flex align-items-center justify-content-between">
                                <h5 class="card-title text-dark">Basic Details</h5>
                                <a href="" data-bs-toggle="modal" data-bs-target="#editEnquiryModal" class="text-dark fs-4"><i class="fa fa-edit"></i></a>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h5 class="fs-6 text-muted fw-bold mb-0">Enquiry Number</h5>
                                <p class="fs-6 text-dark mb-0">{{ $enquiry->enq_no ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h5 class="fs-6 text-muted fw-bold mb-0">Name</h5>
                                <p class="fs-6 text-dark mb-0">{{ $enquiry->name ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="text-muted fw-bold mb-0">Contact Number</h6>
                                <p class="text-dark mb-0">{{ $enquiry->contact ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="text-muted fw-bold mb-0">Product Group</h6>
                                <p class="text-dark mb-0">{{ $enquiry->group_name ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="text-muted fw-bold mb-0">Product</h6>
                                <p class="text-dark mb-0">{{ $enquiry->product_name ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="text-muted fw-bold mb-0">Remarks</h6>
                                <p class="text-dark mb-0">{{ $enquiry->requirements ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="text-muted fw-bold mb-0">Quantity</h6>
                                <p class="text-dark mb-0">{{ $enquiry->quantity ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="text-muted fw-bold mb-0">UOM</h6>
                                <p class="text-dark mb-0">{{ $enquiry->enq_uom ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="text-muted fw-bold mb-0">Capacity</h6>
                                <p class="text-dark mb-0">{{ $enquiry->enq_capacity ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="text-muted fw-bold mb-0">Address</h6>
                                <p class="text-dark mb-0">{{ $enquiry->enq_address ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="text-muted fw-bold mb-0">Location</h6>
                                <p class="text-dark mb-0">{{ $enquiry->location ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="text-muted fw-bold mb-0">Source</h6>
                                <p class="text-dark mb-0">{{ $enquiry->source ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="text-muted fw-bold mb-0">Leadcycle</h6>
                                <p class="text-dark fw-bold mb-0">{{ $enquiry->lead_cycle ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="text-muted fw-bold mb-0">Referred Name</h6>
                                <p class="text-dark mb-0">{{ $enquiry->enq_ref_name ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <h6 class="text-muted fw-bold mb-0">Reference Contact</h6>
                                <p class="text-dark mb-0">{{ $enquiry->enq_ref_contact ?? 'N/A' }}</p>
                            </div>
                            <div class="d-flex align-items-center justify-content-between">
                                <h6 class="text-muted fw-bold mb-0">Status</h6>
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

                    <!-- Edit Enquiry Modal -->
                    <div class="modal fade" id="editEnquiryModal" tabindex="-1" aria-labelledby="editEnquiryModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <form action="{{ route('user.service.enquiry.update', $enquiry->id) }}" method="POST">
                                @csrf
                                @method('POST') {{-- Change to PUT if needed --}}
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title">Edit Enquiry Details</h4>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>

                                    <div class="modal-body row g-3">
                                        <div class="col-md-3">
                                            <label class="form-label">Name</label>
                                            <input type="text" name="name" class="form-control" value="{{ $enquiry->name }}">
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">Contact Number</label>
                                            <input type="text" name="contact" class="form-control" value="{{ $enquiry->contact }}" maxlength="10" minlength="10"
                                                oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">Product Group</label>
                                            <select class="form-select" name="enq_pro_group" id="enq_pro_group" required>
                                                <option disabled>Select Option</option>
                                                @foreach ($add_group as $ag)
                                                    <option value="{{ $ag->id }}" {{ $enquiry->enq_pro_group == $ag->id ? 'selected' : '' }}>
                                                        {{ $ag->group_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label fw-bold">Product</label>
                                            <select class="form-select" name="enq_product" id="enq_product" required>
                                                <option selected disabled>Select Option</option>
                                                @if ($enquiry->product_category)
                                                    <option value="{{ $enquiry->product_category }}" selected>
                                                        {{ $enquiry->product_name }}</option>
                                                @endif
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">Remarks</label>
                                            <textarea name="requirements" class="form-control" rows="2">{{ $enquiry->requirements }}</textarea>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">Quantity</label>
                                            <input type="number" name="quantity" class="form-control" value="{{ $enquiry->quantity }}">
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">UOM</label>
                                            <input type="text" name="enq_uom" class="form-control" value="{{ $enquiry->enq_uom }}">
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">Capacity</label>
                                            <input type="text" name="enq_capacity" class="form-control" value="{{ $enquiry->enq_capacity }}">
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">Address</label>
                                            <textarea name="enq_address" class="form-control" rows="2">{{ $enquiry->enq_address }}</textarea>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">Location</label>
                                            <input type="text" name="location" class="form-control" value="{{ $enquiry->location }}">
                                        </div>

                                        <div class="col-md-3 mb-3">
                                            <label class="form-label fw-bold">Source</label>
                                            <select class="form-select" name="source" required>
                                                <option value="" disabled {{ $enquiry->source == '' ? 'selected' : '' }}>Select Option</option>
                                                <option value="Existing Customer" {{ $enquiry->source == 'Existing Customer' ? 'selected' : '' }}>
                                                    Existing Customer</option>
                                                <option value="Customer reference" {{ $enquiry->source == 'Customer reference' ? 'selected' : '' }}>
                                                    Customer reference</option>
                                                <option value="India Mart" {{ $enquiry->source == 'India Mart' ? 'selected' : '' }}>India Mart
                                                </option>
                                                <option value="Exhibhition" {{ $enquiry->source == 'Exhibhition' ? 'selected' : '' }}>Exhibhition
                                                </option>
                                                <option value="Website" {{ $enquiry->source == 'Website' ? 'selected' : '' }}>Website</option>
                                                <option value="Telemarketing" {{ $enquiry->source == 'Telemarketing' ? 'selected' : '' }}>
                                                    Telemarketing</option>
                                                <option value="Advertisement" {{ $enquiry->source == 'Advertisement' ? 'selected' : '' }}>
                                                    Advertisement</option>
                                                <option value="Tender" {{ $enquiry->source == 'Tender' ? 'selected' : '' }}>Tender</option>
                                                <option value="Empanelled Channel" {{ $enquiry->source == 'Empanelled Channel' ? 'selected' : '' }}>
                                                    Empanelled Channel</option>
                                                <option value="Instagram" {{ $enquiry->source == 'Instagram' ? 'selected' : '' }}>Instagram
                                                </option>
                                                <option value="Other" {{ $enquiry->source == 'Other' ? 'selected' : '' }}>Other</option>
                                            </select>
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">Referred Name</label>
                                            <input type="text" name="enq_ref_name" class="form-control" value="{{ $enquiry->enq_ref_name }}">
                                        </div>

                                        <div class="col-md-3">
                                            <label class="form-label">Reference Contact</label>
                                            <input type="text" name="enq_ref_contact" class="form-control" value="{{ $enquiry->enq_ref_contact }}" maxlength="10"
                                                minlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <button type="submit" class="btn btn-primary">Update</button>
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-header border-bottom pb-1">
                            <h5 class="card-title text-dark">File Details</h5>
                        </div>
                        <div class="card-body">
                            @foreach ($task as $t)
                                @if ($t->quote)
                                    @php
                                        $quoteFiles = explode(',', $t->quote);
                                    @endphp

                                    @foreach ($quoteFiles as $file)
                                        <article class="bg-light rounded-3 qc-card my-2 border p-2">
                                            <div>
                                                <h5 class="card-title text-muted fw-bold mb-0">{{ $file }}</h5>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div>
                                                        <p class="text-muted fw-semibold mb-0 mt-1"><span>Value: </span>{{ $t->value }}</p>
                                                        <p class="mb-0">
                                                            <small>{{ \Carbon\Carbon::parse($t->created_at)->format('d/m/Y') }}</small>
                                                        </p>
                                                    </div>
                                                    <a href="{{ asset('assets/quote_files/' . $file) }}" target="_blank" download>
                                                        <i class="text-success fs-3 fa fa-fw fa-download"></i>
                                                        {{-- asset('assets/quote_files/' . $file) --}}
                                                    </a>
                                                </div>
                                            </div>
                                        </article>
                                    @endforeach
                                @endif
                            @endforeach
                        </div>
                    </div>

                </div>

                {{-- progress --}}
                <div class="col-12 col-lg-6 col-xl-4">
                    <div class="card">
                        <div class="card-header border-bottom d-flex align-items-center justify-content-between pb-1">
                            <h5 class="card-title text-dark">Progress</h5>
                            <h4>{{ $enquiry->enq_no }}</h4>
                        </div>
                        <div class="card-body" style="overflow-y: auto; max-height: 530px;">

                            <ul class="timeline mb-0 mt-2 ps-4">
                                {{-- <li class="timeline-item">
                                    <div class="bg-primary d-flex justify-content-between align-items-center p-2">
                                        <strong class="text-white">{{ $enquiry->lead_cycle }}</strong>

                                        <span class="text-white text-sm fw-normal">{{{ date("d-m-Y",strtotime($enquiry->updated_at)); }}}</span>
                                    </div>

                                    <div class="card-body p-3">
                                        <p class="fw-bold mb-0">Details: <span class="fw-normal ms-1">Rsdv.lklsdaghu</span>
                                        </p>
                                        <p class="fw-bold mb-0">Created by: <span class="fw-normal ms-1"></span></p>
                                        <p class="fw-bold mb-0">Created on: <span class="fw-normal ms-1">{{ date("d-m-Y", strtotime($enquiry->created_at)); }}</span></p>
                                    </div>
                                </li> --}}
                                @if ($task)
                                    @foreach ($task as $tak)
                                        <li class="timeline-item">
                                            <div class="tl-bg d-flex justify-content-between align-items-center p-2">
                                                <strong class="text-white">{{ $tak->lead_cycle }}</strong>
                                                <span class="fw-normal text-sm text-white">{{ date('d-m-Y', strtotime($tak->created_at)) }}</span>
                                            </div>
                                            <div class="card-body p-3">
                                                <!-- task details -->
                                                <p class="fw-bold mb-0">Assigned to: <span class="fw-normal ms-1">{{ $enquiry->assigned_user_name }}</span>
                                                </p>

                                                <p class="fw-bold mb-0">Remarks: <span class="fw-normal ms-1">{{ $tak->remarks ?? 'Not added' }}</span>
                                                </p>
                                                <p class="fw-bold mb-0">Created by: <span class="fw-normal ms-1">{{ $tak->created_by_name ?? 'NA' }}</span>
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
                            <form action="{{ route('user.service.enquiry.submit_task') }}" method="POST" id="myForm" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="enqid" value="{{ $enquiry->enq_id }}">
                                <input type="hidden" name="enqno" value="{{ $enquiry->enq_no }}">
                                <input type="hidden" name="pro_id" value="{{ $enquiry->product_category }}">
                                <input type="hidden" name="user_id" value="{{ $user_id }}">

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Assigned Employee</label>
                                    <select name="assign_to" class="form-select" required>
                                        <option selected disabled>Select Option</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" {{ $user->id == $enquiry->assign_to ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Remarks</label>
                                    <textarea class="form-control" name="remarks" id="" rows="2" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Lead cycle</label>
                                    <select class="form-select" name="lead_cycle" id="inter" required>
                                        <option selected disabled>Select Option</option>
                                        <option value="Enquiry Received">Enquiry Received</option>
                                        <option value="Re-assigend">Re-assigend</option>
                                        <option value="Initial Contact">Initial Contact</option>
                                        <option value="Requirement Gathering">Requirement Gathering</option>
                                        <option value="Product Selection">Product & Specification Selection</option>
                                        <option value="Quotation Preparation">Quotation Prepartion</option>
                                        <option value="Quotation">Quotation Submission</option>
                                        <option value="Follow-up">Follow-up</option>
                                        <option value="Service Entry">Service Entry</option>
                                        <option value="Order confimred">Order confirmed</option>
                                        <option value="Material supplied partially">Material supplied – partially </option>
                                        <option value="Material supplied final-full">Material supplied – final/full
                                        </option>
                                        <option value="Payment received partial">Payment received partial </option>
                                        <option value="Payment received final-full">Payment received final/full </option>
                                        <option value="Final Decision">Final Decision</option>
                                        <option value="Cancelled">Cancelled</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Attach file</label>
                                    <input type="file" name="quote[]" class="form-control" multiple>
                                </div>

                                <div class="inter-det1 mb-3" style="display: none;">
                                    <label class="form-label fw-bold">Service Value</label>
                                    <input type="text" name="ser_value" class="form-control">
                                </div>

                                <div class="inter-det1 mb-3" style="display: none;">
                                    <label class="form-label fw-bold">Attended by</label>
                                    <select class="form-select" name="attn_name" id="" required>
                                        <option selected disabled>Select Option</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="inter-cal mb-3" style="display: none;">
                                    <label class="form-label fw-bold">Reason for cancel</label>
                                    <input type="test" name="cancel" class="form-control" placeholder="">
                                </div>

                                <div class="inter-det mb-3" style="display: none;">
                                    <label class="form-label fw-bold">Quote Value</label>
                                    <input type="text" name="quote_value" class="form-control">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Date</label>
                                    <input type="date" class="form-control" name="callback" min={{ date('Y-m-d') }} placeholder="" required>
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
    <script src="{{ asset('assets/js/disable.js') }}"></script>
    <script>
        $(document).ready(function() {
            var selectedGroupId = "{{ $enquiry->enq_pro_group }}";
            var selectedProductId = "{{ $enquiry->product_category }}";

            // Trigger change manually to load products for selected group
            if (selectedGroupId) {
                $('#enq_pro_group').val(selectedGroupId).trigger('change');

                $.get('/get-products/' + selectedGroupId, function(data) {
                    var options = '<option disabled>Select Option</option>';
                    data.forEach(function(product) {
                        var selected = (product.id == selectedProductId) ? 'selected' : '';
                        options += '<option value="' + product.id + '" ' + selected + '>' + product
                            .name + '</option>';
                    });
                    $('#enq_product').html(options);
                });
            }

            // Update product list on group change
            $('#enq_pro_group').change(function() {
                var groupId = $(this).val();

                $('#enq_product').html('<option selected disabled>Loading...</option>');

                $.get('/get-products/' + groupId, function(data) {
                    var options = '<option selected disabled>Select Option</option>';
                    data.forEach(function(product) {
                        options += '<option value="' + product.id + '">' + product.name +
                            '</option>';
                    });
                    $('#enq_product').html(options);
                });
            });
        });
    </script>
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
            $('#inter').change(function() {
                if ($(this).val() === 'Service Entry') {
                    $('.inter-det1').show();
                } else {
                    $('.inter-det1').hide();
                }
            });
        });
    </script>

    <script src="{{ asset('assets/js/disable.js') }}"></script>

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

    {{-- ERROR TOAST --}}
    @if ($errors->has('message_error'))
        <div aria-live="polite" aria-atomic="true" class="position-relative" style="z-index: 1100;">
            <div class="toast-container position-fixed end-0 top-0 p-3">
                <div class="toast align-items-center text-bg-danger show border-0" role="alert" aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body">
                            {{ $errors->first('message_error') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white m-auto me-2" data-bs-dismiss="toast" aria-label="Close"></button>
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
