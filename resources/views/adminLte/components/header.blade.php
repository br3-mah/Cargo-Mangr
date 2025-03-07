@php

$user_role = auth()->user()->role;

$admin = 1;
$auth_staff = 0;
$auth_branch = 3;
$auth_client = 4;
$auth_dilver = 5;
@endphp


<!-- Navbar -->
<nav @if($user_role == 4) style="margin-left: 21.7%;" @endif  class="main-header navbar navbar-expand navbar-white navbar-light">
    @if($user_role == 4)
        @include('adminLte.components.header-client')
    @else
        @include('adminLte.components.header-admin')
    @endif
</nav>
<!-- /.navbar -->

<style>
    @media only screen and (max-width: 600px) {
        .mobile_section {
            display: none !important;
        }
    }

</style>
