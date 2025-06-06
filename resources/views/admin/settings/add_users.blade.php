@extends('admin.layouts.app')
@section('title','Add users')
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="row mb-2 mb-xl-3">
                <div class="col-auto d-none d-sm-block">
                    <h3><strong>Add User</strong></h3>
                </div>
            </div>

            <div class="row">
                {{-- report tabs --}}
                <div class="card">
                    <div class="card-header pb-0">
                        <h5 class="card-title mb-0">User Details</h5>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('admin.settings.user_store') }}" method="POST" id="myForm">
                            @csrf
                            <div class="row">
                                <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Name</label>
                                    <input type="text" name="user_name" class="form-control" placeholder="">
                                </div>

                                <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Designation</label>
                                    <select class="form-select" name="user_desig" id="">
                                        <option value="" selected disabled>Select Option</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Employee">Employee</option>
                                    </select>
                                </div>
                                 <div class="mb-3 col-md-3">
                                   <label class="form-label fw-bold">Contact Number</label>
                                    <input type="text" name="user_contact" class="form-control" placeholder="" maxlength="10" minlength="10" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                                </div>
                                <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Mail Id</label>
                                    <input type="email" name="user_mail" class="form-control" placeholder="">
                                </div>
                                 <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Password</label>
                                    <input type="password" name="user_pass" class="form-control" id="password" minlength="6" data-toggle="tooltip" data-placement="top"  title="Password needs to be at least 6 characters long">
                                </div>

                                 <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Status</label>
                                    <select class="form-select" name="user_status" id="">
                                        <option value="" selected disabled>Select Option</option>
                                        <option value="Active">Active</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>

                            </div>

                            <div class="row">
                             <div class="mt-2 col-md-2">
                                    <input type="submit" class="btn btn-primary w-100" id="submitBtn" value="Save">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <script>
     document.addEventListener('DOMContentLoaded', function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-toggle="tooltip"]'))
            tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
<script src="{{ asset('assets/js/disable.js') }}"></script>

@endsection()
