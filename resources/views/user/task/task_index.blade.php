@extends('user.layouts.app')
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard_main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard_stages.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard_strength.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/dashboard_team.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
     <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

      <!-- Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

     <!-- SortableJS -->
    <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
      <style>
    .draggablecard {
    background: #fff !important;
    }
   </style>



    <div class="sidebodydiv mb-3 px-5 py-3">
        <div class="sidebodyhead">
            <div class="row mb-xl-3 mb-2">
                <div class="d-flex align-items-center justify-content-between mb-xl-3 mb-2">
                    <div class="d-flex align-items-center">
                        <h3 class="m-0"><strong>Task Sales Dashboard</strong></h3>
                        <a href="{{ route('user.dashboard.dashboard') }}" class="btn btn-outline-dark ms-3">Enquiry Dashboard</a>
                        <a href="{{ route('user.service-dashboard') }}" class="btn btn-outline-dark ms-3">Service Dashboard</a>
                    </div>
                    
                  

                    {{-- <p class="fw-bold fs-4 mb-0"><span>Total Enquiry: </span>{{ $totalEnquiries }}</p> --}}
                </div>
            </div>
        </div>

        {{-- @include('generaldashboard.tabs') --}}

        <div class="container-fluid stages mt-2 px-0">
            <div class="row">

                <!-- Todo -->
                <div class="col-sm-12 col-md-4 col-xl-4 px-2">
                    <div class="stagemain">
                        <div class="todo">
                            <div class="todoct">
                                <h6 class="m-0">To Do</h6>
                            </div>
                            <div class="todono totalno" id="todo-column">
                                <h6 class="m-0 text-end"><span id="todo-count">{{ $tasks_todo_count }}</span></h6>
                            </div>
                        </div>

                        <div class="cardmain column">
                            <div class="row drag todo-list sortable-column" id="todo">
                                    
                                     @foreach ($tasks_todo as $task)
                                    <div class="col-sm-12 col-md-11 col-xl-11 d-block draggablecard task mx-auto mb-2"
                                        data-id="{{ $task->id }}" data-ext_status="{{ $task->status ?? 'empty' }}"
                                        draggable="true">
                                            
                                        <div class="taskname mb-1">
                                            <div class="tasknameleft">
                                                @if ($task->priority == 'High')
                                                    <i class="fa-solid fa-circle text-danger"></i>
                                                @elseif($task->priority == 'Low')
                                                    <i class="fa-solid fa-circle text-primary"></i>
                                                @else
                                                    <i class="fa-solid fa-circle text-warning"></i>
                                                @endif
                                                <h6 class="mb-0">{{ $task->task_title }}
                                                 <h6 class="mb-0">{{ $task->id }}
                                                </h6>
                                            </div>
                                            <div class="tasknamefile">
                                                @if ($task->file)
                                                    <a href="{{ asset('image/task_sale_file/' . $task->file) }}" data-bs-toggle="tooltip"
                                                        data-bs-title="Attachment" download>
                                                        <i class="fa-solid fa-paperclip"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="taskcategory mb-1">
                                            <h6 class="mb-0"><span class="category">{{  $task->category }}</span> /
                                                
                                            </h6>
                                        </div>
                                        <div class="taskdate mb-1">
                                            <div class="taskdescp">
                                                <h6 class="mb-0">{{ $task->description }}</h6>
                                                <div class="taskdescpdiv">
                                                    <h5 class="mb-0">{{ $task->assigned_user }}</h5>
                                                </div>
                                            </div>
                                               

                                            {{-- @if ($status === 'Completed')
                                                <div class="taskdescp">
                                                    <h5 class="text-success">Extended</h5>
                                                </div>
                                            @elseif ($status === 'Pending')
                                                <div class="taskdescp">
                                                    <h5 class="text-success">Pending</h5>
                                                </div>
                                            @elseif (empty($status))
                                                @if ($task->end_date == date('Y-m-d'))
                                                    <!-- Button for extend -->
                                                    <button class="listtdbtn mb-1" data-bs-toggle="modal"
                                                        data-bs-target="#extPopup" data-taskid="{{ $task->id }}">Extend
                                                    </button>
                                                @endif
                                            @endif --}}

                                        </div>
                                        <div class="taskdate mb-2">
                                            <h6 class="startdate m-0">
                                                <i class="fa-regular fa-calendar"></i>&nbsp;
                                                 {{ date('d-m-Y', strtotime($task->start_date) ?? 0) }}

                                            </h6>
                                            <div>
                                                <h6 class="enddate m-0">
                                                   <i class="fa-solid fa-flag"></i>&nbsp;
                                                   {{ date('d-m-Y', strtotime($task->end_date) ?? 0) }}

                                                    {{-- @if ($task->end_date)
                                                        {{ date('d-m-Y', strtotime($task->end_date)) }}
                                                    @else
                                                        N/A
                                                    @endif --}}
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="taskdate">
                                            <h6 class="startdate m-0">
                                                <i class="fas fa-hourglass-start"></i>&nbsp;
                                                 @if ($task->start_time)
                                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $task->start_time)->format('h:i A') }}
                                                @else
                                                    N/A
                                                @endif

                                               
                                            </h6>
                                            <h6 class="enddate m-0">
                                                @if ($task->end_time)
                                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $task->end_time)->format('h:i A') }}
                                                @else
                                                    N/A
                                                @endif
                                            </h6>
                                        </div>

                                    </div>
                                @endforeach
                            
                            </div>

                        </div>
                    </div>
                </div>

                <!-- Inprogress -->
                <div class="col-sm-12 col-md-4 col-xl-4 px-2">
                    <div class="stagemain">
                        <div class="inprogress">
                            <div class="inprgct">
                                <h6 class="m-0">In Progress</h6>
                            </div>
                            <div class="inprgno totalno" id="inprogress-column">
                                <h6 class="m-0 text-end"><span id="inprogress-count">{{ $tasks_inprogress_count }}</span>
                                </h6>
                            </div>
                        </div>

                        <div class="cardmain column">
                            <div class="row drag inprogress-list sortable-column" id="inprogress">

                              @foreach ($tasks_inprogress as $task)
                                    <div class="col-sm-12 col-md-11 col-xl-11 d-block draggablecard task mx-auto mb-2"
                                        data-id="{{ $task->id }}" data-ext_status="{{ $task->status ?? 'empty' }}"
                                        draggable="true">
                                            
                                        <div class="taskname mb-1">
                                            <div class="tasknameleft">
                                                @if ($task->priority == 'High')
                                                    <i class="fa-solid fa-circle text-danger"></i>
                                                @elseif($task->priority == 'Low')
                                                    <i class="fa-solid fa-circle text-primary"></i>
                                                @else
                                                    <i class="fa-solid fa-circle text-warning"></i>
                                                @endif
                                                <h6 class="mb-0">{{ $task->task_title }}
                                                </h6>
                                                <h6 class="mb-0">{{ $task->id }}
                                            </div>
                                            <div class="tasknamefile">
                                                @if ($task->file)
                                                    <a href="{{ asset($task->file) }}" data-bs-toggle="tooltip"
                                                        data-bs-title="Attachment" download>
                                                        <i class="fa-solid fa-paperclip"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="taskcategory mb-1">
                                            <h6 class="mb-0"><span class="category">{{  $task->category }}</span> /
                                                
                                            </h6>
                                        </div>
                                        <div class="taskdate mb-1">
                                            <div class="taskdescp">
                                                <h6 class="mb-0">{{ $task->description }}</h6>
                                                <div class="taskdescpdiv">
                                                    <h5 class="mb-0">{{ $task->assigned_user }}</h5>
                                                </div>
                                            </div>
                                               

                                            {{-- @if ($status === 'Completed')
                                                <div class="taskdescp">
                                                    <h5 class="text-success">Extended</h5>
                                                </div>
                                            @elseif ($status === 'Pending')
                                                <div class="taskdescp">
                                                    <h5 class="text-success">Pending</h5>
                                                </div>
                                            @elseif (empty($status))
                                                @if ($task->end_date == date('Y-m-d'))
                                                    <!-- Button for extend -->
                                                    <button class="listtdbtn mb-1" data-bs-toggle="modal"
                                                        data-bs-target="#extPopup" data-taskid="{{ $task->id }}">Extend
                                                    </button>
                                                @endif
                                            @endif --}}

                                        </div>
                                        <div class="taskdate mb-2">
                                            <h6 class="startdate m-0">
                                                <i class="fa-regular fa-calendar"></i>&nbsp;
                                                 {{ date('d-m-Y', strtotime($task->start_date) ?? 0) }}

                                            </h6>
                                            <div>
                                                <h6 class="enddate m-0">
                                                   <i class="fa-solid fa-flag"></i>&nbsp;
                                                   {{ date('d-m-Y', strtotime($task->end_date) ?? 0) }}

                                                    {{-- @if ($task->end_date)
                                                        {{ date('d-m-Y', strtotime($task->end_date)) }}
                                                    @else
                                                        N/A
                                                    @endif --}}
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="taskdate">
                                            <h6 class="startdate m-0">
                                                <i class="fas fa-hourglass-start"></i>&nbsp;
                                                 @if ($task->start_time)
                                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $task->start_time)->format('h:i A') }}
                                                @else
                                                    N/A
                                                @endif

                                               
                                            </h6>
                                            <h6 class="enddate m-0">
                                                @if ($task->end_time)
                                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $task->end_time)->format('h:i A') }}
                                                @else
                                                    N/A
                                                @endif
                                            </h6>
                                        </div>

                                    </div>
                                    @endforeach
                               
                            </div>
                        </div>
                    </div>
                </div>

               
                
                <!-- Completed -->
                <div class="col-sm-12 col-md-4 col-xl-4 px-2">
                    <div class="stagemain">
                        <div class="completed">
                            <div class="completedct">
                                <h6 class="m-0">Completed</h6>
                            </div>
                            <div class="completedno totalno" id="complete-column">
                                <h6 class="m-0 text-end"><span id="complete-count">{{ $tasks_complete_count }}</span>
                                </h6>
                            </div>
                            
                        </div>

                        <div class="cardmain column">
                            <div class="row drag complete-list sortable-column" id="complete">

                              
                                      @foreach ($tasks_complete as $task)
                                    <div class="col-sm-12 col-md-11 col-xl-11 d-block draggablecard task mx-auto mb-2"
                                        data-id="{{ $task->id }}" data-ext_status="{{ $task->status ?? 'empty' }}"
                                        draggable="true">
                                            
                                        <div class="taskname mb-1">
                                            <div class="tasknameleft">
                                                @if ($task->priority == 'High')
                                                    <i class="fa-solid fa-circle text-danger"></i>
                                                @elseif($task->priority == 'Low')
                                                    <i class="fa-solid fa-circle text-primary"></i>
                                                @else
                                                    <i class="fa-solid fa-circle text-warning"></i>
                                                @endif
                                                <h6 class="mb-0">{{ $task->task_title }}
                                                </h6>
                                                <h6 class="mb-0">{{ $task->id }}
                                            </div>
                                            <div class="tasknamefile">
                                                @if ($task->file)
                                                    <a href="{{ asset($task->file) }}" data-bs-toggle="tooltip"
                                                        data-bs-title="Attachment" download>
                                                        <i class="fa-solid fa-paperclip"></i>
                                                    </a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="taskcategory mb-1">
                                            <h6 class="mb-0"><span class="category">{{  $task->category }}</span> /
                                                
                                            </h6>
                                        </div>
                                         <div class="taskdescp mb-1">
                                            <h6 class="mb-0">{{ $task->description }}</h6>
                                            <div class="taskdescpdiv">
                                                <h5 class="mb-0">{{ $task->assigned_user }}</h5>
                                                <div class="d-flex align-items-center">
                                                    @if ($task->task_status === 'Completed')
                                                        @php
                                                            $status = $tast_ext[$task->id]->status ?? null;
                                                        @endphp

                                                        @if ($status === 'Close Request')
                                                            <h5 class="text-warning mb-0 ms-2">Pending</h5>
                                                        @else
                                                            {{-- <button class="taskassignbtn" data-bs-toggle="modal"
                                                                data-bs-target="#completedModal"
                                                                id="assign">Assign</button> --}}

                                                            <button class="listtdbtn bg-danger ms-2 border-0"
                                                                data-bs-toggle="modal" data-bs-target="#extPopup2"
                                                                data-taskid2="{{ $task->id }}"
                                                                data-createdby="{{ $task->created_by }}">
                                                                Close
                                                            </button>
                                                        @endif
                                                    @elseif ($task->task_status === 'Assigned')
                                                        <h5 class="text-success mb-0">Assigned</h5>
                                                    @else
                                                        <h5 class="text-danger mb-0">Closed</h5>
                                                    @endif
                                                </div>

                                            </div>
                                        </div>
                                        <div class="taskdate mb-2">
                                            <h6 class="startdate m-0">
                                                <i class="fa-regular fa-calendar"></i>&nbsp;
                                                 {{ date('d-m-Y', strtotime($task->start_date) ?? 0) }}

                                            </h6>
                                            <div>
                                                <h6 class="enddate m-0">
                                                   <i class="fa-solid fa-flag"></i>&nbsp;
                                                   {{ date('d-m-Y', strtotime($task->end_date) ?? 0) }}

                                                    {{-- @if ($task->end_date)
                                                        {{ date('d-m-Y', strtotime($task->end_date)) }}
                                                    @else
                                                        N/A
                                                    @endif --}}
                                                </h6>
                                            </div>
                                        </div>
                                        <div class="taskdate">
                                            <h6 class="startdate m-0">
                                                <i class="fas fa-hourglass-start"></i>&nbsp;
                                                 @if ($task->start_time)
                                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $task->start_time)->format('h:i A') }}
                                                @else
                                                    N/A
                                                @endif

                                               
                                            </h6>
                                            <h6 class="enddate m-0">
                                                @if ($task->end_time)
                                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $task->end_time)->format('h:i A') }}
                                                @else
                                                    N/A
                                                @endif
                                            </h6>
                                        </div>

                                    </div>
                                    @endforeach

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- close task -->
            <div class="modal fade" id="extPopup2" tabindex="-1" aria-labelledby="extPopupLabel" aria-hidden="true"
                data-bs-backdrop="static" data-bs-keyboard="false">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title fs-5" id="extPopupLabel">Close Task</h4>
                            <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form method="POST" action="{{ route('user.task.ext') }}" enctype="multipart/form-data">
                            @csrf

                            <input type="hidden" name="category" value="close">

                            <div class="col-sm-12 col-md-12 mb-2">
                                {{-- <label for="show_task_id">Task ID</label> --}}
                                <input type="hidden" class="form-control" name="task_id" id="task_id">
                                <input type="hiden" class="form-control" name="assined_by" id="assined_by"> 
                            </div>

                            <div class="modal-body">
                                <div class="row">
                                    <div class="col-sm-12 col-md-12 mb-2">
                                        <label for="">Attach</label>
                                        <input type="file" class="form-control" name="close_attach">
                                    </div>
                                    <div class="col-sm  -12 col-md-12 mb-2">
                                        <label for="">Remarks</label>
                                        <input type="text" class="form-control" name="remarks">
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer d-flex justify-content-center align-items-center pb-1">
                                <button type="submit" class="modalbtn">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

              <!-- task extend -->
                <div class="modal fade" id="extPopup" tabindex="-1" aria-labelledby="extPopupLabel" aria-hidden="true"
                    data-bs-backdrop="static" data-bs-keyboard="false">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title fs-5" id="extPopupLabel">Extend Date</h4>
                                <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <form method="POST" action="{{ 1 }}">
                                @csrf

                                <input type="hidden" name="category" value="extend">

                                <div class="col-sm-12 col-md-12 mb-2">
                                    {{-- <label for="show_task_id">Task ID</label> --}}
                                    <input type="hidden" class="form-control" name="task_id" id="show_task_id">
                                </div>

                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12 mb-2">
                                            <label for="enddate">End Date</label>
                                            <input type="date" class="form-control" min="{{ date('Y-m-d') }}"
                                                name="extend_date">
                                        </div>
                                        <div class="col-sm-12 col-md-12 mb-2">
                                            <label for="">Remarks</label>
                                            <input type="text" class="form-control" name="remarks">
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer d-flex justify-content-center align-items-center pb-1">
                                    <button type="submit" class="modalbtn">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            {{-- <div class="row mt-4">
                <div class="col-md-5 col-sm-12 col-xl-5 cards mb-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="cardshead">
                                <h6 class="card1h6 mb-2">Walkin Counts</h6>
                            </div>
                            <form method="GET" class="d-flex justify-content-between">
                                <div>
                                    <label class="d-block">From</label>
                                    <input type="date" class="form-control-sm" name="fromdate" id="fromdate"
                                        value="{{ date('Y-m-d') }}">
                                </div>
                                <div>
                                    <label class="d-block">To</label>
                                    <input type="date" class="form-control-sm" name="todate" id="todate"
                                        value="{{ date('Y-m-d') }}">
                                </div>
                            </form>

                            <div id="chart5"></div>
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>

    <!-- Update Assign Modal -->
    <div class="modal fade" id="completedModal" tabindex="-1" aria-labelledby="completedModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title fs-5" id="completedModalLabel">Assign Task</h4>
                    <button type="button" class="btn-close bg-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="row" id="taskForm" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="f_id" id="f_id" value="">
                        <input type="hidden" name="task_id" id="current_task_id" value="">
                        <input type="hidden" name="category_id" id="cat_id" value="">
                        <input type="hidden" name="subcategory_id" id="subcat_id" value="">

                        <div class="col-sm-12 col-md-6 mb-3">
                            <label for="taskname" class="col-form-label">Task Title</label>
                            <input type="text" class="form-control" name="task_title" id="taskname"
                                placeholder="Enter Task Title" required>
                        </div>

                        <div class="col-sm-12 col-md-6 mb-3">
                            <label for="assignto" class="col-form-label">Assign To</label>
                            <select class="form-select select2" name="assign_to" id="assignto" required>
                                <option value="" selected disabled>Select Employee</option>
                               
                            </select>
                        </div>

                        <div class="col-sm-12 col-md-6 mb-3">
                            <label for="startdate" class="col-form-label">Start Date</label>
                            <input type="date" class="form-control" name="start_date" id="startdate"
                                value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="col-sm-12 col-md-6 mb-3">
                            <label for="starttime" class="col-form-label">Start Time</label>
                            <input type="time" class="form-control" name="start_time" id="starttime"
                                value="{{ date('h:i') }}" required>
                        </div>

                        <div class="col-sm-12 col-md-6 mb-3">
                            <label for="enddate" class="col-form-label">End Date</label>
                            <input type="date" class="form-control" name="end_date" id="enddate" required>
                        </div>

                        <div class="col-sm-12 col-md-6 mb-3">
                            <label for="endtime" class="col-form-label">End Time</label>
                            <input type="time" class="form-control" name="end_time" id="endtime" required>
                        </div>

                        <div class="col-sm-12 col-md-6 mb-3">
                            <label for="priority" class="col-form-label">Priority</label>
                            <select class="form-select" name="priority" id="priority" required>
                                <option value="" selected disabled>Select Priority</option>
                                <option value="Low">Low</option>
                                <option value="Medium">Medium</option>
                                <option value="High">High</option>
                            </select>
                        </div>

                        <div class="col-sm-12 col-md-6 mb-3">
                            <label for="file" class="col-form-label">File</label>
                            <input type="file" class="form-control" name="task_file" id="file">
                        </div>

                        <div class="col-sm-12 col-md-12 mb-3">
                            <label for="taskdescp" class="col-form-label">Task Description</label>
                            <textarea class="form-control" name="task_description" id="taskdescp" placeholder="Enter Task Description"></textarea>
                        </div>

                        <div class="col-sm-12 col-md-12 mb-3">
                            <label for="" class="col-form-label">Comment</label>
                            <input type="text" class="form-control" placeholder="Enter comment" name="comment"
                                required>
                        </div>

                        <div class="d-flex justify-content-center align-items-center mx-auto">
                            <button type="submit" id="sub_btn" class="modalbtn">Assign</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/form_script.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts@latest"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/1.4.0/axios.min.js"></script>
    <script>
        // For Extend Date Modal
        const extPopup = document.getElementById('extPopup');

        extPopup.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const taskId = button.getAttribute('data-taskid'); // should be data-taskid
            document.getElementById('show_task_id').value = taskId;
        });

        // For Close Task Modal
        const extPopup2 = document.getElementById('extPopup2');

        extPopup2.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const taskId = button.getAttribute('data-taskid2'); // should be data-taskid2
            var createdBy = button.getAttribute('data-createdby');
            document.getElementById('task_id').value = taskId;
              document.getElementById('assined_by').value = createdBy;
        });
    </script>

    <script>
        $(document).ready(function() {
            $('.taskclosebtn').on('click', function() {

                var close = confirm("Are you sure you want to close the task flow ?");

                if (close) {
                    var close_id = $(this).data('close');
                   
                    $.ajax({
                        url: "{{ route('user.update.task') }}",
                        type: "POST",
                        dataType: "json",
                        data: {
                            id: close_id,
                            status: 'Close',
                            _token: $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.success) {
                                location.reload();
                            }
                        }
                    });
                } // if closing

            })

            let alertShown = false;
            var columnOrder = {
                        'todo': 1,
                        'inprogress': 2,
                        'onhold': 3,
                        'complete': 4
                    };

            $('.sortable-column').each(function() {
                new Sortable(this, {
                    group: {
                        name: 'tasks',
                        pull: this.id === 'complete' ? false : true,
                        put: true
                    },
                    animation: 150,
                    ghostClass: 'blue-background-class',
                    forceFallback: true,
                   onMove: function(evt) {
                        var fromColumn = evt.from.id;
                        var toColumn = evt.to.id;
                        var ext_status = $(evt.dragged).data('ext_status');

                    // Prevent moving Pending tasks
                    if (ext_status === "Pending") {
                        if (!alertShown) {
                            alert("Not able to move until the extension is complete.");
                            alertShown = true;
                        }
                        return false; // Cancel move
                    }

                    // Prevent backward movement
                    if (columnOrder[toColumn] < columnOrder[fromColumn]) {
                        alert("You cannot move a task backward.");
                        return false; // Cancel move
                    }

                    return true; // Allow forward move
                },

                    onStart: function(evt) {


                        // console.log('Dragging Task ID:', $(evt.item).data('id'), 'from:', evt.from.id);
                        // console.log('Dragging Externd task Task ID:', $(evt.item).data(
                        //     'ext_status'), 'from:', evt.from.id);
                    },

                    onEnd: function(evt) {
                        var taskId = $(evt.item).data('id');
                        var taskStatus = $(evt.item).data('status');
                        var originColumn = evt.from;
                        var targetColumn = evt.to;
                        var columnId = targetColumn.id;
                        var ext_status = $(evt.item).data('ext_status');

                        // if (ext_status == "Pending") {

                        // }



                        if (!columnId || originColumn.id === columnId) {
                            return;
                        }

                        var newStatusMap = {
                            'todo': 'To Do',
                            'inprogress': 'In Progress',
                            'onhold': 'On Hold',
                            'complete': 'Completed'
                        };

                        var newStatus = newStatusMap[columnId] || '';
                        if (!newStatus) {
                            return;
                        }

                        if (columnId === 'complete') {
                            var confirmation = confirm(
                                "Are you sure you want to mark this task as completed?");
                            if (!confirmation) {
                                originColumn.appendChild(evt.item); // Move it back
                                return;
                            }
                        }

                        // If the task is in "Completed" status, prevent dropping it back into any other column


                        // if (columnId === 'complete') {
                        //     alert("You cannot move a completed task back.");
                        //     originColumn.appendChild(evt.item); // Move it back
                        //     return;
                        // }

                        $(evt.item).attr('data-status', newStatus);
                        $(evt.item).data('status', newStatus);

                        alert('Task "' + taskId + '" moved to "' + newStatus + '"');

                        $.ajax({
                            url: "{{ route('user.update.task') }}",
                            type: "GET",
                            dataType: "json",
                            data: {
                                id: taskId,
                                status: newStatus,
                                _token: $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.success) {
                                    location.reload();
                                    $('#todo-count').text(response.taskCounts.todo);
                                    $('#inprogress-count').text(response.taskCounts
                                        .inprogress);
                                    $('#onhold-count').text(response.taskCounts
                                        .onhold);
                                    $('#complete-count').text(response.taskCounts
                                        .complete);
                                }
                            }
                        });
                    }
                });
            });
        });
    </script>

   
    
    <script>
        $(document).ready(function() {
            $('#taskForm').on('submit', function(e) {
                e.preventDefault();
                $('#sub_btn').prop('disabled', true).text('Saving...');

                let formData = new FormData(this);
                formData.append('_token', '{{ csrf_token() }}');

                $.ajax({
                    url: "",
                    type: "POST",
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function(response) {
                        alert(response.message);
                        window.location.href = "";
                    },
                    error: function(xhr) {
                        alert('Something went wrong!');
                    }
                });
            });
        });
    </script>
    
@endsection
