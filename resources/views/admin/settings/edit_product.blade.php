@extends('admin.layouts.app')
@section('title', 'Edit product')
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="row mb-2 mb-xl-3">
                <div class="col-auto d-none d-sm-block">
                    <h3><strong>Add Permission</strong></h3>
                </div>
            </div>

            <div class="row">
                {{-- report tabs --}}
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.settings.update_product') }}" method="POST">
                                        @csrf

                                        <div class="row">

                                                <input type="hidden" class="form-control" name="edit_id" value="{{ $products->id }}" required>

                                                <div class="mb-3 col-md-3">
                                                <label class="form-label fw-bold">Product Name</label>
                                                <input type="text" class="form-control" name="name" value="{{ $products->name }}" required>
                                            </div>

                                            <div class="mb-3 col-md-3">
                                                <label class="form-label fw-bold">Product Description</label>
                                                <input type="text" class="form-control" name="desc" value="{{ $products->desc }}" required>
                                            </div>

                                            <div class="mb-3 col-md-3">
                                                <label class="form-label fw-bold">Status</label>
                                                <select class="form-select" name="status" required>
                                                    <option value="Active" {{ $products->status == 'Active' ? 'selected' : '' }}>Active</option>
                                                    <option value="Inactive" {{ $products->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
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
