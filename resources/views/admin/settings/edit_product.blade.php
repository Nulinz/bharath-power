@extends('admin.layouts.app')
@section('title', 'Edit product')
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
                        <form action="{{ route('admin.settings.update_product') }}" method="POST">
                            @csrf

                            <div class="row">
                                <input type="hidden" name="edit_id" value="{{ $product->id }}">

                                <!-- Product group dropdown -->

                                <div class="mb-3 col-md-3">
                                     <label class="form-label fw-bold">Group Name</label>
                                    <select name="group_id" class="form-control">
                                        <option value="" selected disabled>Select</option>
                                        @foreach ($productGroups as $pt)
                                            <option value="{{ $pt->id }}"
                                                {{ $pt->id == $product->group_id ? 'selected' : '' }}>
                                                {{ $pt->group_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Other fields -->
                                <div class="mb-3 col-md-3">
                                     <label class="form-label fw-bold">Product</label>
                                    <input type="text" name="name" class="form-control" value="{{ $product->name }}"
                                        required>
                                </div>

                                <div class="mb-3 col-md-3">
                                       <label class="form-label fw-bold">Product Description</label>
                                    <input type="text" name="desc" class="form-control" value="{{ $product->desc }}"
                                        required>
                                </div>

                                <div class="mb-3 col-md-3">
                                    <label class="form-label fw-bold">Status</label>
                                    <select class="form-control" name="status" required>
                                        <option value="Active" {{ $product->status == 'Active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="Inactive" {{ $product->status == 'Inactive' ? 'selected' : '' }}>
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
