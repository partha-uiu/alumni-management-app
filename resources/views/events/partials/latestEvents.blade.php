<div class="col-12 col-lg-4">
    <div class="background-oxford text-white p-2 text-center">
        <div class="fs-1">Latest Events</div>
    </div>
    <div class="scroll-up">
        <div class="scroll-content px-1">
            @foreach($latestEvents as $latestEvent)
                <a href="{{route('events.show',['id'=>$latestEvent->id])}}" target="_blank">
                    <div class="row no-gutters mb-4">
                        <div class="col-4 col-md-2 col-lg-4 pl-3">
                            <div class="background-facebook color-white p-2 text-center lh-1">
                                <div class="fs-3"> {{Carbon\Carbon::createFromFormat('Y-m-d', $latestEvent->start_date)->format('d')}}</div>
                                <div class="d-block"> {{Carbon\Carbon::createFromFormat('Y-m-d', $latestEvent->start_date)->format('M')}}</div>
                            </div>
                            <div class="background-oxford color-white p-2 text-center small lh-1">
                                {{Carbon\Carbon::createFromFormat('H:i:s', $latestEvent->start_time)->format('h:i A')}}
                            </div>
                        </div>
                        <div class="col-8 col-md-10 col-lg-8 pl-3">
                            <h6 class="color-oxford">{{$latestEvent->title}}</h6>
                            <p class="text-muted lh-2">{{$latestEvent->location}}</p>
                        </div>
                    </div>
                </a>
                @if(!$loop->last)
                    <div class="col-12">


                        <hr class="color-9">

                    </div>

                @endif
                @if($loop->last)
                    <div class="col-12 mb-3">

                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>
