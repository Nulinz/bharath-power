@include('user.service.layouts.header')
<div class="wrapper">
    @include('user.service.layouts.sidebar')
    <div class="main">
        @include('user.service.layouts.navbar')
        @yield('content')
        @include('user.service.layouts.footer')
