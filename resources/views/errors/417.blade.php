@extends('layouts.master')



@section('content')
    <h2>{{ $exception->getMessage() }}</h2>
    <h3 class="text-info mt-5">Sorry ! Page Not Found.</h3>
@endsection