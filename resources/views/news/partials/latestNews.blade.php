<div class="col-12 col-lg-4">
    <div class="background-oxford text-white p-2 text-center">
        <div class="fs-1">Latest News</div>
    </div>
    <div class="scroll-up">
        <div class="scroll-content px-1">
            @foreach($latestNews as $latestNewsVal)
                <a class="color-oxford" href="{{route('news.show',['id'=>$latestNewsVal->id])}}" target="_blank">
                    <div class="row no-gutters mb-4">
                        <div class="col-4 col-md-2 col-lg-4 pl-3">
                            <img class="img-thumbnail" @if($latestNewsVal->image_url) src="{{asset('storage').'/'.$latestNewsVal->image_url}}" @else src="{{asset('images/no-image-default.jpg')}}" @endif>
                        </div>
                        <div class="col-8 col-md-10 col-lg-8 pl-3">
                            <h6 class="mb-2">{{$latestNewsVal->heading}}</h6>
                            <h6 class="text-muted small">{{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $latestNewsVal->created_at)->format('d M Y h:i a')}}</h6>
                            <button class="btn btn-outline-dark btn-xs">Read more</button>
                        </div>
                    </div>
                </a>
                @if(!$loop->last)
                    <div class="col-12">

                        <hr class="color-9">

                    </div>

                @endif
                @if($loop->last)
                    <div class="col-12 mb-0">

                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>