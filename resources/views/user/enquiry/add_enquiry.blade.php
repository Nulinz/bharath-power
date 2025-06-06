@extends('user.layouts.app')
@section('title','Add Enquiry')
@section('content')
 <main class="content">
        <div class="container-fluid p-0">
            <div class="row mb-2 mb-xl-3">
                <div class="col-auto d-none d-sm-block">
                    <h3><strong>Add Enquiry</strong></h3>
                </div>
            </div>

            <div class="row">
                {{-- report tabs --}}
                <div class="card">
                    <div class="card-header pb-0">
                        <h5 class="card-title mb-0">User Details</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('user.enquiry.store') }}" method="POST" id="myForm" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="user_id" value="{{ Auth::id(); }}">
                                <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Name</label>
                                    <input type="text" name="enq_name" class="form-control" placeholder="">
                                </div>

                                <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Product Category</label>
                                    <select class="form-select" name="enq_product" id="">
                                        <option  selected disabled>Select Option</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Qty</label>
                                    <input type="text" name="enq_qty" class="form-control" placeholder="">
                                </div>
                             <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Lead cycle</label>
                                    <select class="form-select" name="enq_lead_cycle" id="inter">
                                        <option selected disabled>Select Option</option>
                                        <option value="Enquiry Received">Enquiry Received</option>
                                        <option value="Initial Contact">Initial Contact</option>
                                        <option value="Requirement Gathering">Requirement Gathering</option>
                                        <option value="Product Selection">Product & Specification Selection</option>
                                        <option value="Quotation">Quotation Submission</option>
                                        <option value="Follow-up">Follow-up</option>
                                        <option value="Final Decision">Final Decision</option>
                                    </select>
                                </div>

                                <div class="mb-3 col-md-3 inputs inter-det" style="display: none;">
                                    <label class="form-label fw-bold">Upload Quote</label>
                                    <input type="file" name="enq_quote" class="form-control">
                                </div>

                                <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Requirement</label>
                                    <input type="text" name="enq_requirements" class="form-control" placeholder="">
                                </div>

                                <div class="mb-3 col-md-3">
                                  <label class="form-label fw-bold">Contact Number</label>
                                   <input type="text" name="enq_contact" class="form-control" placeholder="" maxlength="10" minlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                               </div>
                                  <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Location</label>
                                    <input type="text" name="enq_location" class="form-control" placeholder="">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Source</label>
                                    <select class="form-select" name="enq_source" id="">
                                        <option value="" selected disabled>Select Option</option>
                                        <option value="Indiamart">Indiamart</option>
                                        <option value="Existing customers">Existing customers</option>
                                        <option value="Other source">Other sources</option>
                                    </select>
                                </div>

                                <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Assign To</label>
                                    <select class="form-select" name="enq_assign_to" id="">
                                        <option selected disabled>Select Option</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id  }}">{{ $user->name; }}</option>
                                        @endforeach
                                    </select>
                                </div>

                            </div>
                            <div class="row">
                             <div class="mt-2 col-md-2">
                                    <input type="submit" class="btn btn-primary w-100" id="submitBtn" value="Submit">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
	<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <script>
     document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="tooltip"]'))
            tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });

    $(document).ready(function () {
        $('#inter').change(function () {
            if ($(this).val() === 'Quotation') {
                $('.inter-det').show();
            } else {
                $('.inter-det').hide();
            }
        });
    });
    </script>
<script src="{{ asset('assets/js/disable.js') }}"></script>
@endsection()