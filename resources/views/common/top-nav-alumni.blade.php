<section class="background-11 py-2">
    <div class="container">
        {{ auth()->user()->name }}
        <div class="row">
            <div class="col-12 text-center text-lg-right ml-auto">
                <a class="btn btn-link btn-xs color-4" href="{{route('feed')}}">Feed</a>
{{--                <a class="btn btn-link btn-xs color-4" href="{{route('user.home')}}"> Dashboard</a>--}}
                <a class="btn btn-link btn-xs color-4" href="{{route('profile', ['id' => auth()->id()])}}"> Me</a>
                <a class="btn btn-link btn-xs color-4" href="{{route('alumni-directory')}}"> Directory</a>
                {{--<a class="btn btn-link btn-xs color-4" href="{{route('jobs')}}"> Jobs</a>--}}
                {{--<a class="btn btn-link btn-xs color-4" href="{{route('donations')}}"> Donate</a>--}}
                {{--<a class="btn btn-link btn-xs color-4" href="{{route('events-news')}}"> News &amp; Events</a>--}}
                <a class="btn btn-link btn-xs color-4" href="{{route('invite')}}"> Invite</a>
                {{--<a class="btn btn-link btn-xs color-4" href="{{route('poll.home')}}">Polls</a>--}}

            </div>
        </div>
    </div>
</section>