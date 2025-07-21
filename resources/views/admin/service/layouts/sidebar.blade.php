 <nav id="sidebar" class="sidebar js-sidebar">
     <div class="sidebar-content js-simplebar">
         <a class='sidebar-brand mx-auto pb-0'>
             {{-- <h2>Barath Power</h2> --}}
             <img src="{{ asset('assets/images/bp_logo.jpeg') }}" height="90" class="barnd" alt="bp_logo">
             <svg class="sidebar-brand-icon align-middle" width="32px" height="32px" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="1.5" stroke-linecap="square"
                 stroke-linejoin="miter" color="#FFFFFF" style="margin-left: -3px">
                 <path d="M12 4L20 8.00004L12 12L4 8.00004L12 4Z"></path>
                 <path d="M20 12L12 16L4 12"></path>
                 <path d="M20 16L12 20L4 16"></path>
             </svg>
         </a>

         <ul class="sidebar-nav">
             <li class="sidebar-item {{ Route::is('admin.service-dashboard') ? 'active' : '' }}">
                 <a class='sidebar-link fw-semibold' href='{{ route('admin.service-dashboard') }}'>
                     <i class="align-middle" data-feather="grid"></i> <span class="fw-semibold align-middle">Dashboard</span>
                 </a>
             </li>

             <li class="sidebar-item {{ Route::is('admin.service.enquiry.enquiry_list') ? 'active' : '' }}">
                 <a class='sidebar-link fw-semibold' href='{{ route('admin.service.enquiry.enquiry_list') }}'>
                     <i class="align-middle" data-feather="file-text"></i> <span class="fw-semibold align-middle">Enquiry</span>
                 </a>
             </li>

             <li class="sidebar-item {{ Route::is('admin.service.reports.index') ? 'active' : '' }}">
                 <a class='sidebar-link fw-semibold' href='{{ route('admin.service.reports.index') }}'>
                     <i class="align-middle" data-feather="clipboard"></i> <span class="fw-semibold align-middle">Report</span>
                 </a>
             </li>

         </ul>
     </div>
 </nav>
