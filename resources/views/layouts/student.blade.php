<!DOCTYPE html>
<html lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="csrf-token" content="{{ csrf_token() }}" />
@include('common.css') {{-- Include css file --}}  
<style>
	h1{font-size:23px;}
	.pull-left h2{margin-top:0;font-size:20px;}
</style>
<title>@yield('title')</title>
</head>
<body>
  <div class="container-fluid"> 
	  @include('common.header')  {{-- Include header file --}} 
	  @yield("content")
  </div>
  @include('common.footer') {{-- Include footer file --}}  

</body>
</html>