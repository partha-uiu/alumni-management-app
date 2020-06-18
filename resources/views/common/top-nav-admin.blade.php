<section class="background-11 py-2">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-1 text-center text-md-left mr-auto mb-2 mb-md-0">
                <span class="badge badge-pill badge-default">
                    @if (Auth::user()->hasAnyRole('super-admin'))
                        Super Admin
                    @elseif(Auth::user()->hasAnyRole('admin'))
                        Admin
                    @endif
                </span>
            </div>
            <div class="col-12 col-md-11 text-center text-md-right ml-auto">
                <a class="btn btn-link btn-xs color-4" href="{{route('admin.home')}}">Dashboard</a>
                <a class="btn btn-link btn-xs color-4" href="{{route('alumni-directory',['status'=>'pending'])}}"> Directory</a>
                <a class="btn btn-link btn-xs color-4" href="{{route('jobs',['status'=>'pending'])}}">Jobs</a>
                <a class="btn btn-link btn-xs color-4" href="{{route('donations',['status'=>'pending'])}}">Donate</a>
                <a class="btn btn-link btn-xs color-4" href="{{route('events-news')}}"> News &amp; Events</a>
                <a class="btn btn-link btn-xs color-4" href="{{route('pages')}}">Manage Pages</a>
                <a class="btn btn-link btn-xs color-4" href="{{route('feed')}}">Feed</a>
                <a class="btn btn-link btn-xs color-4" href="{{route('poll.home')}}">Polls</a>
            </div>
        </div>
    </div>
</section>