@extends('admin.layouts.app')
@section('title', 'Add task')
@section('content')

<style>
.left-timeline {
    min-height: 180px;
}

.timeline-dot {
    position: absolute;
    top: 7px;
    left: 92%;
    transform: translateX(-50%);
    width: 20px;
    height: 20px;
    background: #2c3e50;
    color: #fff;
    font-size: 12px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 2;
}

.timeline-line {
    position: absolute;
    top: 1px;
    left: 92%;
    width: 2px;
    height: 180px;
    background: #d1d5db;
    transform: translateX(-50%);
}
</style>
<main class="content">
<div class="container-fluid p-0">

        <div class="row mb-3">
            <div class="col-12">
                <h3><strong>Task View</strong></h3>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-xl-11">

                <!-- MAIN CARD -->
                <div class="card">
                    <div class="card-body">

                        <div class="row position-relative">

                            <!-- LEFT COLUMN -->
                            <div class="col-md-3  position-relative">
                                <h6 class="fw-bold mb-0">{{$task_sales->created_name}}</h6>
                                <small class="text-muted"></small>
                                <div class="text-muted mt-1">{{ \Carbon\Carbon::parse($task_sales->created_at)->format('d-m-y') }}</div>

                                <!-- Timeline dot -->
                                <span class="timeline-dot">
                                    ✓
                                </span>

                                <!-- Timeline vertical line -->
                                <span class="timeline-line"></span>
                            </div>

                            <!-- RIGHT COLUMN -->
                            <div class="col-md-9">
                                <div class="border rounded p-3">

                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <strong>{{$task_sales->task_title}}</strong>

                                        @if($task_sales->priority == 'high')
                                            <span class="badge bg-danger">High</span>
                                        @elseif($task_sales->priority == 'medium')
                                            <span class="badge bg-warning text-dark">Medium</span>
                                        @elseif($task_sales->priority == 'low')
                                            <span class="badge bg-success">Low</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $task_sales->priority }}</span>
                                        @endif
                                    </div>


                                    <div class="mb-1">
                                        <span class="text-primary fw-bold">
                                           {{$task_sales->category_name}}
                                        </span>
                                        {{-- /
                                        <span class="text-warning fw-bold">
                                            Cleaning & Store Maintenance
                                        </span> --}}
                                    </div>
                                     

                                     <div class="fw-bold mb-2">
                                        {{$task_sales->description}}
                                    </div>
                                    <div class="fw-bold mb-2">
                                        {{$task_sales->add_info}}
                                    </div>

                                    {{-- <div class="text-muted mb-2">
                                        STEP CLEANING
                                    </div> --}}

                                    <div class="fw-bold mb-2">
                                        {{$task_sales->assigned_name}} - <span class="fw-normal">{{$task_sales->assigned_designation}}</span>




                                              @if($task_sales->file)
                                                <a href="{{ asset('image/task_sale_file/' . $task_sales->file) }}"
                                                download
                                                title="Download File"
                                                class="text-decoration-none">
                                               <i class="fa fa-paperclip"></i>  
                                               {{-- <i class="fa-light fa-paperclip"></i> --}}


                                                </a>
                                            @else
                                                <span class="text-muted">No File</span>
                                            @endif


                                    </div>

                                    <div class="d-flex justify-content-between">
                                        <div class="text-muted">
                                            📅 {{ \Carbon\Carbon::parse($task_sales->start_date)->format('d-m-y') }} <br>
                                            ⏰  {{$task_sales->start_time}}
                                        </div>

                                        <div class="text-danger text-end">
                                            📅  {{ \Carbon\Carbon::parse($task_sales->end_date)->format('d-m-y') }} <br>
                                            ⏰ {{$task_sales->end_time}}
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <!-- END CARD -->

            </div>
        </div>

    </div>
    </main>
@endsection

