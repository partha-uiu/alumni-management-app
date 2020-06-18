@extends('layouts.master')

@section('content')

    @if ((Auth::Check()) &&  (Auth::user()->hasAnyRole('super-admin|admin|editor|faculty-stuff')))
        @include('common.top-nav-admin')
    @endif

    @if((Auth::Check()) &&   (Auth::user()->hasRole('alumni')))
        @include('common.top-nav-alumni')
    @endif

    <div class="h-full text-center">
        <h2>{{ $exception->getMessage() }}</h2>
        <h3 class="text-info mt-5">Sorry ! Page Not Found</h3>
    </div>
@endsection