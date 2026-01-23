@extends('admin.service.layouts.app')
@section('title', 'View service_task_profile')

@section('content')
<main class="content">
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
                                <h6 class="fw-bold mb-0">{{$task_service->created_name}}</h6>
                                <small class="text-muted"></small>
                                <div class="text-muted mt-1">{{ \Carbon\Carbon::parse($task_service->created_at)->format('d-m-y') }}</div>

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
                                            <strong>{{$task_service->task_title}}</strong>

                                            @if($task_service->priority == 'high')
                                                <span class="badge bg-danger">High</span>
                                            @elseif($task_service->priority == 'medium')
                                                <span class="badge bg-warning text-dark">Medium</span>
                                            @elseif($task_service->priority == 'low')
                                                <span class="badge bg-success">Low</span>
                                            @else
                                                <span class="badge bg-secondary">{{ $task_service->priority }}</span>
                                            @endif
                                        
                                    </div>


                                   <div class="d-flex justify-content-between align-items-center mb-2">

                                        <span class="text-primary fw-bold">
                                           {{$task_service->category_name}}
                                        </span>
                                        {{-- /
                                        <span class="text-warning fw-bold">
                                            Cleaning & Store Maintenance
                                        </span> --}}
                                        
                                            @if($taskClosed)
                                                <button class="listtdbtn bg-danger text-white ms-2 border-0"
                                                    data-bs-toggle="modal" data-bs-target="#extPopup2"
                                                    data-taskid2="{{ $task_service->id }}"
                                                    data-createdby="{{ $task_service->created_by }}">
                                                    Close  
                                                </button>
                                    {{-- @else --}}
                                        {{-- <span class="badge bg-secondary">Already Closed</span> --}}
                                    @endif
                                    </div>
                                     <div class="fw-bold mb-2">
                                        {{$task_service->description}}
                                    </div>
                                     <div class="fw-bold mb-2">
                                        {{$task_service->add_info}}
                                    </div>


                                    {{-- <div class="text-muted mb-2">
                                        STEP CLEANING
                                    </div> --}}

                                    <div class="fw-bold mb-2">
                                        {{$task_service->assigned_name}} - <span class="fw-normal">{{$task_service->assigned_designation}}</span>

                                        
                                              @if($task_service->file)
                                                <a href="{{ asset('image/task_service_file/' . $task_service->file) }}"
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
                                            📅 {{ \Carbon\Carbon::parse($task_service->start_date)->format('d-m-y') }} <br>
                                            ⏰  {{$task_service->start_time}}
                                        </div>

                                        <div class="text-danger text-end">
                                            📅  {{ \Carbon\Carbon::parse($task_service->end_date)->format('d-m-y') }} <br>
                                            ⏰ {{$task_service->end_time}}
                                        </div>
                                    </div>

                                </div>
                            </div>

                        </div>

                    </div>
                </div>
                <!-- END CARD -->
                 <!--pop up-->
                 <!-- Close Task Modal -->
                <div class="modal fade" id="extPopup2" tabindex="-1" aria-labelledby="extPopup2Label" aria-hidden="true">
                <div class="modal-dialog">
                    <form id="closeTaskForm" method="POST" action="{{ route('admin.service_task_close') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="task_id" id="modal_task_id">
                    <input type="hidden" name="created_by" id="modal_created_by">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="extPopup2Label">Close Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                        <div class="mb-3">
                            <label for="a_remarks" class="form-label">Remarks</label>
                            <textarea name="a_remarks" id="a_remarks" class="form-control" required></textarea>
                        </div>
                        {{-- <div class="mb-3">
                            <label for="attach" class="form-label">Attach File</label>
                            <input type="file" name="attach" id="attach" class="form-control">
                        </div> --}}
                        </div>
                        <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Submit Close Request</button>
                        </div>
                    </div>
                    </form>
                </div>
                </div>

                 <!--end pop up-->

            </div>
        </div>

    </div>
</main>
<script>
    var extModal = document.getElementById('extPopup2');
    extModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var taskId = button.getAttribute('data-taskid2');
        var createdBy = button.getAttribute('data-createdby');

        // Set values in modal hidden fields
        document.getElementById('modal_task_id').value = taskId;
        document.getElementById('modal_created_by').value = createdBy;
    });
</script>
@endsection 