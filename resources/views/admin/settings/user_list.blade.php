<div class="card mb-3">
                                <div class="m-3 mb-0 pb-3 d-flex align-items-center justify-content-between border-bottom">
                                    <h5 class="card-title mb-0">Users</h5>
                                    <a class="btn btn-primary" href="{{ route('admin.settings.add_users') }}"><i
                                            class="align-middle fa fa-fw fa-plus"></i>Add User</a>
                                </div>
                                <div class="card-body">
                                    <div class="">
                                    </div>
                                    <table id="datatables-reponsive" class="table table-striped" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Name</th>
                                                <th>Designation</th>
                                                <th>Contact Number</th>
                                                <th>Password</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="">
                                            @foreach ($users as $user)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->designation }}</td>
                                                    <td>{{ $user->contact_number }}</td>
                                                    <td>{{ $user->password }}</td>
                                                    <td>
                                                        @if ($user->user_status == 'Active')
                                                            <span class="badge badge-success-light">Active</span>
                                                        @else
                                                         <span class="badge badge-danger-light">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('admin.settings.user_edit', $user->id) }}">
                                                            <i class="fs-4 text-dark fa fa-fw fa-edit"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>