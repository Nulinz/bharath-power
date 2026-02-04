@extends('admin.layouts.app')
@section('title', 'Task Sales List')
@section('content')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <style>
        .dropdown-menu {
            width: 250px !important;
        }
    </style>
    <main class="content">
        <div class="container-fluid p-0">
            <div class="row mb-xl-3 mb-2">
                <div class="d-flex align-items-center justify-content-between">
                    <h3 class="mb-0"><strong>Task List</strong></h3>
                    <a href="{{ route('admin.dash.add_task') }}" class="btn btn-primary btn-md"><i class="fa fa-fw fa-plus align-middle"></i> Add Task</a>

                </div>
            </div>

            
                        <div class="card-body">
                            <table id="datatables-reponsive" class="table-striped table" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Title</th>
                                        <th>Category</th>
                                        <th>Description</th>
                                        <th>Assigned By</th>
                                        <th>Priority</th>
                                        <th>Start Date-End Date</th>
                                        <th>Status</th>
                                        

                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody class="">

                                   @foreach ($task_sale as $task)
                                       <tr class="clickable-row" data-url="{{ route('admin.admin.sales_task_profile',['id' => $task->id]) }}">

                        
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $task->task_title }}</td>
                                            <td>{{ $task->category_name }}</td>
                                            <td>{{ $task->description }}</td>
                                            <td>{{ $task->assigned_name }}</td>
                                            <td>
                                                @if($task->priority == 'high')
                                                    <span class="badge bg-danger">High</span>
                                                @elseif($task->priority == 'medium')
                                                    <span class="badge bg-warning text-dark">Medium</span>
                                                @elseif($task->priority == 'low')
                                                    <span class="badge bg-success">Low</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $task->priority }}</span>
                                                @endif
                                            </td>
                                            <td>{{ \Carbon\Carbon::parse($task->start_date)->format('d-m-Y') }}
                                            -
                                        {{ \Carbon\Carbon::parse($task->end_date)->format('d-m-Y') }}</td>
                                            <td>{{$task->status}}</td>
                                            {{-- <td>{{ \Carbon\Carbon::parse($task->start_date)->format('d-m-Y') }}</td> --}}

                                        
                                        </tr>
                    

                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/js/disable.js') }}"></script>


    <script>
document.addEventListener("DOMContentLoaded", function () {

    let table = $('#datatables-reponsive').DataTable({
        responsive: true,
        ordering: true
    });

    $.fn.dataTable.ext.search.push(function (settings, data) {

        let assign = $('#assignFilter').val()?.toLowerCase() || '';
        let filterDate = $('#dateFilter').val();

        // Assigned By column (index 4)
        let rowAssign = (data[4] || '').toLowerCase();

        // Date column (index 6): "dd-mm-yyyy - dd-mm-yyyy"
        let rowDateRange = data[6] || '';
        let startDate = rowDateRange.split(' - ')[0]; // ✅ FIXED

        // Convert dd-mm-yyyy → yyyy-mm-dd
        let parts = startDate.split('-');
        let formattedDate = parts.length === 3
            ? `${parts[2]}-${parts[1]}-${parts[0]}`
            : '';

        let assignMatch = !assign || rowAssign === assign;
        let dateMatch = !filterDate || formattedDate === filterDate;

        return assignMatch && dateMatch;
    });

    $('#assignFilter, #dateFilter').on('change', function () {
        table.draw();
    });

});
</script>

<script>
$(document).ready(function () {

    $('#datatables-reponsive tbody').on('click', 'tr.clickable-row', function () {
        let url = $(this).data('url');
        if (url) {
            window.location.href = url;
        }
    });

    $('#datatables-reponsive tbody').css('cursor', 'pointer');

});
</script>

 @if (session('message'))
        <div aria-live="polite" aria-atomic="true" class="position-relative" style="min-height: 100px;">
            <div class="toast-container position-fixed top-0 end-0 p-3" style="z-index: 1100;">
                <div id="successToast" class="toast align-items-center text-bg-success border-0" role="alert"
                    aria-live="assertive" aria-atomic="true">
                    <div class="d-flex">
                        <div class="toast-body text-white">
                            {{ session('message') }}
                        </div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"
                            aria-label="Close"></button>
                    </div>
                </div>
            </div>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                var toastEl = document.getElementById('successToast');
                var toast = new bootstrap.Toast(toastEl);
                toast.show();
            });
        </script>
    @endif



@endsection()
