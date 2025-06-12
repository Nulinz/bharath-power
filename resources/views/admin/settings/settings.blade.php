@extends('admin.layouts.app')
@section('title', 'Settings')
@section('content')
    <main class="content">
        <div class="container-fluid p-0">
            <div class="row mb-2 mb-xl-3">
                <div class="col-auto d-none d-sm-block">
                    <h3><strong>Settings</strong></h3>
                </div>
            </div>

            <div class="row">
                {{-- report tabs --}}
                <div class="col-md-12 col-xl-12">

                    <div class="nav nav-tabs" role="tablist">
                        <a class="active" data-bs-toggle="tab" href="#Pro_group" role="tab" aria-selected="false" tabindex="-1">
                            Product Group
                        </a>
                        <a data-bs-toggle="tab" href="#Products" role="tab" aria-selected="true">
                            Products
                        </a>
                        <a data-bs-toggle="tab" href="#Users" role="tab" aria-selected="false" tabindex="-1">
                            Users
                        </a>
                    </div>

                    {{-- <div class="nav nav-tabs" role="tablist">
                        <a class="active" data-bs-toggle="tab" href="{{ route('admin.settings.settings', ['tab' => '#Products']) }}" role="tab" aria-selected="true">
                            Products
                        </a>
                        <a data-bs-toggle="tab" href="{{ route('admin.settings.settings', ['tab' => '#Users']) }}" role="tab" aria-selected="false" tabindex="-1">
                            Users
                        </a>
                    </div> --}}

                   {{-- @php
                    $activeTab = request()->route('tab', 'defaultTabName');
                    // $activeTab = request()->get('tab');
                    //  dd($activeTab);
                @endphp --}}

                    {{-- <div class="tab-content mt-3">
                        <div class="tab-pane fade show {{ $activeTab == 'Products' ? 'active' : '' }}" id="Products" role="tabpanel">
                            @include('admin.settings.products_list');
                        </div>
                        <div class="tab-pane fade {{ $activeTab == 'Users' ? 'active' : '' }}" id="Users" role="tabpanel">
                            @include('admin.settings.user_list');
                        </div>
                    </div> --}}
                    {{-- <div class="tab-content mt-3">
                    <div class="tab-pane fade {{ $activeTab == 'Products' ? 'show active' : '' }}" id="" role="tabpanel">
                        @include('admin.settings.products_list')
                    </div>

                    <div class="tab-pane fade show{{ $activeTab == 'Users' ? 'show active' : '' }}" id="" role="tabpanel">
                        @include('admin.settings.user_list')
                    </div>
                    </div> --}}

                    <div class="tab-content mt-3">

                    <div class="tab-pane fade show active" id="Pro_group" role="tabpanel">
                        @include('admin.settings.product_group')
                    </div>

                    <div class="tab-pane fade" id="Products" role="tabpanel">
                        @include('admin.settings.products_list')
                    </div>

                    <div class="tab-pane fade" id="Users" role="tabpanel">
                        @include('admin.settings.user_list')
                    </div>


                    </div>

                </div>
            </div>
        </div>
    </main>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // 1) Initialize Table #1
            $("#datatables-reponsive").DataTable({
                responsive: true,
                ordering: false,
                lengthMenu: [
                    [5, 10, 25, 50, -1],
                    ["5", "10", "25", "50", "All"]
                ]
            });
            // 2) Initialize Table #2 (even though it’s hidden initially)
            $("#datatables-reponsive-two").DataTable({
                responsive: true,
                ordering: false,
                lengthMenu: [
                    [5, 10, 25, 50, -1],
                    ["5", "10", "25", "50", "All"]
                ]
            });

            // 3) WHEN the “Permissions” tab is actually shown, force a recalc on Table #2:
            $('a[data-bs-toggle="tab"][href="#Users"]').on("shown.bs.tab", function(e) {
                // Explicitly adjust only the second DataTable:
                $("#datatables-reponsive-two")
                    .DataTable()
                    .columns.adjust()
                    .responsive.recalc();
            });
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
