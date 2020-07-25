@extends('layouts.master')

<form action="{{ route('search') }}" method="GET" class="form-horizontal" enctype="multipart/form-data">
	
	Name:<input type="text" name="name"><br/>
	Email:<input type="email" name="email"><br/>
	<input type="submit" value="submit">
</form>