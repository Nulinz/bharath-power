@extends('admin.layouts.app')
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
                        <form action="{{ route('admin.enquiry.store') }}" method="POST" id="myForm" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <input type="hidden" name="user_id" value="{{ Auth::id(); }}">
                                <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Name</label>
                                    <input type="text" name="enq_name" class="form-control" placeholder="" required>
                                </div>

                                  {{-- <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Product Group</label>
                                    <select class="form-select" name="enq_pro_group" id="" required>
                                        <option  selected disabled>Select Option</option>
                                        @foreach ($add_group as $ag)
                                            <option value="{{ $ag->id }}">{{ $ag->group_name }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Product Category</label>
                                    <select class="form-select" name="enq_product" id="" required>
                                        <option  selected disabled>Select Option</option>
                                        @foreach ($products as $product)
                                            <option value="{{ $product->id }}">{{ $product->name }}</option>
                                        @endforeach
                                    </select>
                                </div> --}}


                                   <!-- Product Group Dropdown -->
                                   <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Product Group</label>
                                <select class="form-select"  name="enq_pro_group" id="enq_pro_group" required>
                                    <option selected disabled>Select Option</option>
                                    @foreach ($add_group as $ag)
                                        <option value="{{ $ag->id }}">{{ $ag->group_name }}</option>
                                    @endforeach
                                </select>
                                   </div>

                                <!-- Product Category Dropdown -->
                                <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Product Category</label>
                                <select class="form-select" name="enq_product" id="enq_product" required>
                                    <option selected disabled>Select Option</option>
                                </select>
                                </div>


                                <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Qty</label>
                                    <input type="text" name="enq_qty" class="form-control" placeholder="" required>
                                </div>

                                <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">UOM</label>
                                    <input type="text" name="enq_uom" class="form-control" placeholder="" required>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Capacity</label>
                                    <input type="text" name="enq_capacity" class="form-control" placeholder="">
                                </div>
                             <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Lead cycle</label>
                                    <select class="form-select" name="enq_lead_cycle" id="inter" required>
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

                                 <div class="mb-3  col-md-3 inter-det" style="display: none;">
                                    <label class="form-label fw-bold">Quote Value</label>
                                    <input type="text" name="quote_value" class="form-control">
                                </div>

                                  <div class="mb-3 col-md-3 inputs inter-det" style="display: none;">
                                    <label class="form-label fw-bold">Purchase Group</label>
                                      <select class="form-select" name="Purchase_group" id="inter">
                                        <option selected disabled>Select Option</option>
                                        <option value="Group1">Group 1</option>
                                        <option value="Group2">Group 2</option>
                                        <option value="Group3">Group 3</option>
                                        <option value="Group4">Group 4</option>
                                    </select>
                                </div>

                                <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Remarks</label>
                                    <input type="text" name="enq_requirements" class="form-control" placeholder="" required>
                                </div>

                                <div class="mb-3 col-md-3">
                                  <label class="form-label fw-bold">Contact Number</label>
                                   <input type="text" name="enq_contact" class="form-control" placeholder="" maxlength="10" minlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')" required>
                               </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Address</label>
                                    <textarea class="form-control" name="enq_address" id=""  rows="1"></textarea>
                                </div>
                                  <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Location</label>
                                    <input type="text" name="enq_location" class="form-control" placeholder="" required>
                                </div>
                                 <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Referred by Name</label>
                                    <input type="text" name="enq_ref_name" class="form-control" placeholder="">
                                </div>
                                  <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Reference Contact</label>
                                    <input type="text" name="enq_ref_contact" class="form-control" placeholder=""  maxlength="10" minlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Source</label>
                                    <select class="form-select" name="enq_source" id="" required>
                                        <option value="" selected disabled>Select Option</option>
                                        <option value="Existing Customer">Existing Customer</option>
                                        <option value="Customer reference">Customer reference</option>
                                        <option value="India Mart">India Mart</option>
                                        <option value="Exhibhition">Exhibhition</option>
                                        <option value="Website">Website</option>
                                        <option value="Telemarketing">Telemarketing</option>
                                        <option value="Advertisement">Advertisement</option>
                                        <option value="Tender">Tender</option>
                                        <option value="Empanelled Channel">Empanelled Channel</option>
                                        <option value="Instagram">Instagram</option>
                                        <option value="Other">Other</option>
                                    </select>
                                </div>

                                <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Assign To</label>
                                    <select class="form-select" name="enq_assign_to" id="" required>
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

<script>
    $('#enq_pro_group').change(function () {
        var groupId = $(this).val();

        $('#enq_product').html('<option selected disabled>Loading...</option>');

        $.get('/get-products/' + groupId, function (data) {
            var options = '<option selected disabled>Select Option</option>';
            data.forEach(function (product) {
                options += '<option value="' + product.id + '">' + product.name + '</option>';
            });
            $('#enq_product').html(options);
        });
    });
</script>


    <script src="{{ asset('assets/js/disable.js') }}"></script>
@endsection()