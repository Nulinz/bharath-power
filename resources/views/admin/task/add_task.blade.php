@extends('admin.layouts.app')
@section('title', 'Add task')
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="row mb-2 mb-xl-3">
                <div class="col-auto d-none d-sm-block">
                    <h3><strong>Add Task</strong></h3>
                </div>
            </div>

            <div class="row">
                {{-- report tabs --}}
                <div class="card">
                    <div class="card-body">
                             <form action="{{ route('admin.admin.task_sale_store') }}" method="POST"  id="myForm" enctype="multipart/form-data"> 
                                @csrf
                            <div class="row">
                                
                                <div class="mb-3 col-md-3">
                                    {{-- <label class="form-label fw-bold">Task Title </label> --}}
                                    <label class="form-label fw-bold">
                                     Task Title <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" class="form-control" name="task_title" required>
                                     <input type="hidden" class="form-control" name="user"  value="{{ auth()->id() }}" required>

                                </div>

                                 <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Category <span class="text-danger">*</span></label>
                                    <select name="category_id" id="" class="form-select select2input" required>
                                        <option value="" selected disabled>Select</option>
                                        {{-- <option>SH</option>
                                        <option>MH</option> --}}
                                         @foreach ($category as $cat )
                                            <option value="{{ $cat->id }}">{{ $cat->cat_name }}</option>
                                        @endforeach 
                                    </select>
                                </div>

                                <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Assign To <span class="text-danger">*</span></label>
                                    <select name="user_id" id="" class="form-control select2input" required>
                                        <option value="" selected disabled>Select</option>
                                         @foreach ($users as $usr )
                                            <option value="{{ $usr->id }}">{{ $usr->name }}</option>
                                        @endforeach 
                                    </select>
                                </div>

                                
                                <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Task Description  <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="description" required>
                                </div>

                                <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Additional Information <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="add_info" required>
                                </div>

                                 <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Start Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="start_date" required>
                                </div>

                                 <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Start Time <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control" name="start_time" required>
                                </div>

                                 <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">End Date <span class="text-danger">*</span></label>
                                    <input type="date" class="form-control" name="end_date" required>
                                </div>

                                 <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">End Time <span class="text-danger">*</span></label>
                                    <input type="time" class="form-control" name="end_time" required>
                                </div>

                              
                                <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Priority <span class="text-danger">*</span></label>
                                    <select name="priority" id="" class="form-select select2input" required>
                                        <option value="" selected disabled>Select</option>
                                         <option value="high">High</option>
                                         <option value="medium">Medium</option>
                                         <option value="low">Low</option>
                                    </select>
                                 
                                </div>
                                
                                  <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">File  <span class="text-danger">*</label>
                                    <input type="file" class="form-control" name="file" accept=".jpg,.jpeg,.png,.pdf" required>
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
<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


<script>
    $(document).ready(function() {
        $('.select2input').select2({
            placeholder: "--Select--",
            allowClear: false,
            width: '100%'
        }).prop('required', true);
        $('.select2input1').select2({
            placeholder: "--Select--",
            allowClear: false,
            width: '100%'
        }).prop('required', false);
    });
</script>

@endsection()
