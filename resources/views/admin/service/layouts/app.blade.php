@include('admin.service.layouts.header')
<div class="wrapper">
    @include('admin.service.layouts.sidebar')
    <div class="main">
        @include('admin.service.layouts.navbar')
        @yield('content')
        @include('admin.service.layouts.footer')
