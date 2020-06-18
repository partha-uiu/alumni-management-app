<div class="col-lg-4 col-12">
    <div class="background-oxford text-white p-1 text-center"><h5>Latest Jobs</h5></div>
    <div class="scroll-up">
        <div class="scroll-content pl-3">
            @foreach($latestJobs as $latestJob)
                <h6 class="mb-0">{{$latestJob->job_title}}

                    @if($latestJob->job_type=='Internship')
                        <span class="badge badge-pill badge-warning mx-2 mb-1 text-uppercase">{{$latestJob->job_type}}</span>

                    @elseif($latestJob->job_type=='Full-time')
                        <span class="badge badge-pill badge-success mx-2 mb-1 text-uppercase">{{$latestJob->job_type}}</span>

                    @elseif($latestJob->job_type=='Part-time')
                        <span class="badge badge-pill badge-primary mx-2 mb-1 text-uppercase">{{$latestJob->job_type}}</span>


                    @elseif($latestJob->job_type=='Hourly')
                        <span class="badge badge-pill badge-danger mx-2 mb-1 text-uppercase">{{$latestJob->job_type}}</span>

                    @elseif($latestJob->job_type=='Remote')
                        <span class="badge badge-pill badge-default  mx-2 mb-1 text-uppercase">{{$latestJob->job_type}}</span>

                    @elseif($latestJob->job_type=='Contract')
                        <span class="badge badge-pill badge-info  mx-2 mb-1 text-uppercase">{{$latestJob->job_type}}</span>

                    @endif

                </h6>
                <p class="color-5 fs--1">By : {{$latestJob->company_name}}</p>

                <div class="text-center">
                    <a class="btn btn-outline-primary btn-xs" href="{{route('jobs.show',['id'=>$latestJob->id])}}" target="_blank"> View Job</a>
                </div>
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