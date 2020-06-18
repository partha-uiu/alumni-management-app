@if(Auth::check())
    @if (Auth::user()->hasAnyRole('super-admin|admin|editor|faculty-stuff'))
        @include('common.top-nav-admin')
    @elseif (Auth::user()->hasAnyRole('alumni|student'))
        @include('common.top-nav-alumni')
    @endif
@endif