	<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class='sidebar-brand pb-0 mx-auto'>
						{{-- <h2>Barath Power</h2> --}}
					<img src="{{ asset('assets/images/bp_logo.jpeg') }}" height="90" class="barnd" alt="bp_logo">
					<svg class="sidebar-brand-icon align-middle" width="32px" height="32px" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="1.5"
						stroke-linecap="square" stroke-linejoin="miter" color="#FFFFFF" style="margin-left: -3px">
						<path d="M12 4L20 8.00004L12 12L4 8.00004L12 4Z"></path>
						<path d="M20 12L12 16L4 12"></path>
						<path d="M20 16L12 20L4 16"></path>
					</svg>
				</a>

				<ul class="sidebar-nav">

					<li class="sidebar-item {{ Route::is('admin.dashboard.dashboard') ? 'active' : '' }}">
						<a class='sidebar-link fw-semibold' href='{{ route('admin.dashboard.dashboard') }}'>
							<i class="align-middle" data-feather="grid"></i> <span class="align-middle fw-semibold">Dashboard</span>
						</a>
					</li>

					<li class="sidebar-item {{ Route::is('admin.enquiry.enquiry_list') ? 'active' : '' }}">
						<a class='sidebar-link fw-semibold' href='{{ route('admin.enquiry.enquiry_list') }}'>
							<i class="align-middle" data-feather="file-text"></i> <span class="align-middle fw-semibold">Enquiry</span>
						</a>
					</li>

					<li class="sidebar-item {{ Route::is('admin.reports.index') ? 'active' : ''}}">
						<a class='sidebar-link fw-semibold' href='{{ route('admin.reports.index') }}'>
							<i class="align-middle" data-feather="clipboard"></i> <span class="align-middle fw-semibold">Report</span>
						</a>
					</li>

					<li class="sidebar-item {{ Route::is('admin.settings.settings') ? 'active' : ''}}">
						<a class='sidebar-link fw-semibold' href='{{ route('admin.settings.settings') }}'>
							<i class="align-middle" data-feather="settings"></i> <span class="align-middle fw-semibold">Settings</span>
						</a>
					</li>

				</ul>
			</div>
		</nav>
