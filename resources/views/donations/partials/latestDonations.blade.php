<div class="col-lg-4 col-12">
    <div class="background-oxford text-white p-1 text-center"><h5>Latest Donations</h5></div>
    <div class="scroll-up">
        <div class="scroll-content pl-3">
            @foreach($latestDonations as $latestDonation)
                <a href="{{route('donations.show',['id'=>$latestDonation->id])}}" class="color-1 row" target="_blank">
                    <div class="col-3 text-center">
                        <div class="background-oxford color-white p-2 text-center font-1 radius-primary lh-1">
                            <div class="fs-1">@if($latestDonation->start_date){{Carbon\Carbon::createFromFormat('Y-m-d', $latestDonation->start_date)->format('d')}} @else {{"Date not available"}} @endif</div>
                            <div class="d-block">@if($latestDonation->end_date){{Carbon\Carbon::createFromFormat('Y-m-d', $latestDonation->start_date)->format('M')}}  @endif</div>
                        </div>
                    </div>
                    <div class="col pl-0 text-left">
                        <h6 class="color-oxford mb-0">{{$latestDonation->title}}</h6>
                        <p class="d-inline-block  mt-0">@php
                                $string = strip_tags($latestDonation->description);

                               if (strlen($string) > 50) {

                                // truncate string
                                $stringCut = substr($string, 0, 50);

                                $string = substr($stringCut, 0, strrpos($stringCut, ' '));

                                  }
                                echo $string.'.....';
                            @endphp
                        </p>
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


