<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('CSS/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/AdminLand.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/adminHeader.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/success.css') }}">
    <link rel="stylesheet" href="{{ asset('CSS/user.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css" integrity="sha512-5Hs3dF2AEPkpNAR7UiOHba+lRSJNeM2ECkwxUIxC1Q/FLycGTbNapWXB4tP889k5T5Ju8fs4b1P5z/iB4nMfSQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>صفحة الأدمن</title>
</head>
<body>
    @include('admin.layouts.header')
    @include('admin.layouts.sidebar')
    <div class="admin_container">
        @if (session('success'))
    <div class="notification-card success" id="success-alert">
        ✅ {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="notification-card error" id="error-alert">
        ❌ {{ session('error') }}
    </div>
@endif
        @yield('admin_content')
    </div>
<script src="{{ asset('JS/admin_script.js') }}"></script>
<script src="{{ asset('JS/sidebar.js') }}"></script>
<script src="{{ asset('JS/AdminLand.js') }}"></script>
<script src="{{ asset('JS/adminHeader.js') }}"></script>
<script src="{{ asset('JS/success.js') }}"></script>
<script src="{{ asset('JS/user.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
</body>
</html>
