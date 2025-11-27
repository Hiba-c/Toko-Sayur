<!-- backend/v_layout/header.blade.php -->
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="">

<title>{{ $judul ?? 'Toko Sayur' }}</title>

<!-- Favicon -->
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('image/icon_univ_bsi.png') }}">

<!-- Styles (template lama paths) -->
<link href="{{ asset('backend/libs/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('backend/libs/datatables.net-bs4/css/dataTables.bootstrap4.css') }}" rel="stylesheet">
<link href="{{ asset('backend/dist/css/style.min.css') }}" rel="stylesheet">

<!-- Optional icons (pastikan path asset sesuai) -->
<link href="{{ asset('backend/assets/icons/material-design-iconic-font/css/materialdesignicons.min.css') }}" rel="stylesheet">
