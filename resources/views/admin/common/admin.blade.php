<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>后台管理</title>
	<meta name="renderer" content="webkit">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta http-equiv="Access-Control-Allow-Origin" content="*">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="format-detection" content="telephone=no">
	<!--<link rel="icon" href="favicon.ico">-->
	<link rel="stylesheet" href="{{ URL::asset(_ADMIN_.'layui/css/layui.css') }}" media="all" />

	<link rel="stylesheet" href="{{ URL::asset(_ADMIN_.'css/public.css') }}" media="all" />
	<script type="text/javascript" src="{{ URL::asset(_ADMIN_.'layui/layui.js') }}"></script>

</head>
@section('content')

@show
</html>

@section('js')

@show


