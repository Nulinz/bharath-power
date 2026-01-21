@extends('admin.layouts.app')
@section('title', 'Edit category')
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="row mb-2 mb-xl-3">
                <div class="col-auto d-none d-sm-block">
                    <h3><strong>Edit Product</strong></h3>
                </div>
            </div>

            <div class="row">
                {{-- report tabs --}}
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.settings.update_category') }}" method="POST">
                            @csrf

                            <div class="row">
                                <input type="hidden" name="edit_id" value="{{ $category_data->id }}">

                                <!-- Product group dropdown -->

                              
                                <!-- Other fields -->
                                <div class="mb-3 col-md-3">
                                     <label class="form-label fw-bold">Product</label>
                                    <input type="text" name="category_name" class="form-control" value="{{ $category_data->cat_name }}"
                                        required>
                                </div>

                                <div class="mb-3 col-md-3">
                                       <label class="form-label fw-bold">Product Description</label>
                                    <input type="text" name="category_desc" class="form-control" value="{{ $category_data->cat_desc }}"
                                        required>
                                </div>

                                <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Status</label>
                                    <select class="form-control" name="category_status" required>
                                        <option value="Active" {{ $category_data->status == 'Active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="Inactive" {{ $category_data ->status == 'Inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                </div>

                            </div>

                            <div class="mt-2 col-md-2">
                                <input type="submit" class="btn btn-primary w-100" value="Save">
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </main>
@endsection()
