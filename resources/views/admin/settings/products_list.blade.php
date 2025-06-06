<div class="card mb-3">
                                <div class="m-3 mb-0 pb-3 d-flex align-items-center justify-content-between border-bottom">
                                    <h5 class="card-title mb-0">Products</h5>
                                    <a class="btn btn-primary" href="{{ route('admin.settings.add_product') }}"><i
                                            class="align-middle fa fa-fw fa-plus"></i>Add Product</a>
                                </div>
                                <div class="card-body">
                                    <div class="">
                                    </div>
                                    <table id="datatables-reponsive" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product Name</th>
                                                <th>Description</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($products as $index => $pro)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>{{ $pro->name }}</td>
                                                    <td>{{ $pro->desc }}</td>
                                                    <td>
                                                        @if ($pro->status == 'Active')
                                                            <span class="badge badge-success-light">Active</span>
                                                        @else
                                                            <span class="badge badge-danger-light">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>

                                                        {{-- <a href="#"><i class="fs-4 text-danger align-middle me-2 fa fa-times-circle"></i></a> --}}
                                                        <a href="{{ route('admin.settings.edit_product', $pro->id) }}"><i
                                                                class="fs-4 text-dark fa fa-fw fa-edit"></i></a>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>