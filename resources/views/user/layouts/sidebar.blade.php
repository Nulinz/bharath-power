	<nav id="sidebar" class="sidebar js-sidebar">
			<div class="sidebar-content js-simplebar">
				<a class='sidebar-brand pb-0 mx-auto'>
					<img src="{{ asset('assets/images/bp_logo.jpeg') }}" height="90" class="barnd" alt="bp_logo">
					<svg class="sidebar-brand-icon align-middle" width="32px" height="32px" viewBox="0 0 24 24" fill="none" stroke="#FFFFFF" stroke-width="1.5"
						stroke-linecap="square" stroke-linejoin="miter" color="#FFFFFF" style="margin-left: -3px">
						<path d="M12 4L20 8.00004L12 12L4 8.00004L12 4Z"></path>
						<path d="M20 12L12 16L4 12"></path>
						<path d="M20 16L12 20L4 16"></path>
					</svg>
				</a>

				<ul class="sidebar-nav">

					{{-- <li class="sidebar-item">
						<a data-bs-target="#pages" data-bs-toggle="collapse" class="sidebar-link collapsed">
							<i class="align-middle" data-feather="layout"></i> <span class="align-middle">Pages</span>
						</a>
						<ul id="pages" class="sidebar-dropdown list-unstyled collapse " data-bs-parent="#sidebar">
							<li class="sidebar-item"><a class='sidebar-link' href='pages-settings.html'>Settings</a></li>
							<li class="sidebar-item"><a class='sidebar-link' href='pages-projects.html'>Projects <span
										class="sidebar-badge badge bg-primary">Pro</span></a></li>
							<li class="sidebar-item"><a class='sidebar-link' href='pages-clients.html'>Clients <span
										class="sidebar-badge badge bg-primary">Pro</span></a></li>
							<li class="sidebar-item"><a class='sidebar-link' href='pages-orders.html'>Orders <span
										class="sidebar-badge badge bg-primary">Pro</span></a></li>
							<li class="sidebar-item"><a class='sidebar-link' href='pages-pricing.html'>Pricing <span
										class="sidebar-badge badge bg-primary">Pro</span></a></li>
							<li class="sidebar-item"><a class='sidebar-link' href='pages-chat.html'>Chat <span
										class="sidebar-badge badge bg-primary">Pro</span></a></li>
							<li class="sidebar-item"><a class='sidebar-link' href='pages-blank.html'>Blank Page</a></li>
						</ul>
					</li> --}}

					<li class="sidebar-item {{ Route::is('user.dashboard.dashboard') ? 'active' : '' }}">
						<a class='sidebar-link fw-semibold' href='{{ route('user.dashboard.dashboard') }}'>
							<i class="align-middle" data-feather="grid"></i> <span class="align-middle fw-semibold">Dashboard</span>
						</a>
					</li>

					<li class="sidebar-item {{ Route::is('user.enquiry.enquiry_list') ? 'active' : '' }}">
						<a class='sidebar-link fw-semibold' href='{{ route('user.enquiry.enquiry_list') }}'>
							<i class="align-middle" data-feather="grid"></i> <span class="align-middle fw-semibold">Enquiry</span>
						</a>
					</li>
				</ul>
			</div>
		</nav>
