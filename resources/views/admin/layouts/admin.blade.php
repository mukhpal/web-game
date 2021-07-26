<!doctype html>
<html lang="en">
<head>
	<title>{{$title}} - Admin Panel</title>
    <meta name="description" content="">
	<!-- Twitter meta-->
	<meta property="twitter:card" content="">
	<meta property="twitter:site" content="">
	<meta property="twitter:creator" content="">
	<!-- Open Graph Meta-->
	<meta property="og:type" content="website">
	<meta property="og:site_name" content="Admin Panel">
	<meta property="og:title" content="">
	<meta property="og:url" content="">
	<meta property="og:image" content="">
	<meta property="og:description" content="">
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	
    <link href="{{ asset( 'assets/front/images/fev_icon.png' ) }}" rel="icon">
    <link href="{{ asset( 'assets/front/img/apple-touch-icon.png' ) }}" rel="apple-touch-icon">	
	<!-- Main CSS-->
	<link rel="stylesheet" type="text/css" href="{{asset('assets/admin/css/main.css')}}">
	<!-- Font-icon css-->
	<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">

	<script src="{{asset('assets/admin/js/jquery-3.2.1.min.js')}}"></script>
	<script src="{{asset('assets/admin/js/jquery.validate.min.js')}}"></script>

</head>
<body  class="hold-transition sidebar-mini app">
<div class="wrapper">
    @include('admin.includes.adminheader')
    	@yield('content')
    @include('admin.includes.adminfooter')
</div>
</body>
</html>