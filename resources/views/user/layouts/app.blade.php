@include('user.layouts.header')
<div class="wrapper">
    @include('user.layouts.sidebar')
    <div class="main">
        @include('user.layouts.navbar')
        @yield('content')
@include('user.layouts.footer')
