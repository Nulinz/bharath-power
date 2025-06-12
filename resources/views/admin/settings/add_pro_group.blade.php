@extends('admin.layouts.app')
@section('title', 'Add product')
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="row mb-2 mb-xl-3">
                <div class="col-auto d-none d-sm-block">
                    <h3><strong>Add Product Group</strong></h3>
                </div>
            </div>

            <div class="row">
                {{-- report tabs --}}
                <div class="card">
                    <div class="card-body">
                            <form action="{{ route('admin.store_product_group') }}" method="POST"  id="myForm">
                                @csrf
                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Group Name</label>
                                    <input type="text" class="form-control" name="group_name" required>
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Product Description</label>
                                    <input type="text" class="form-control" name="group_desc">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Status</label>
                                    <select class="form-select" name="group_status" id="" required>
                                        <option value="" selected disabled>Select Option</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mt-2 col-md-2">
                                <input type="submit" class="btn btn-primary w-100" id="submitBtn" value="Save">
                            </div>
                            <form>
                        </div>
                    </div>
            </div>
        </div>
    </main>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('assets/js/disable.js') }}"></script>
@endsection()
