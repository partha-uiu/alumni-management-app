@extends('layouts.master')

@section('title', 'Profile')

@section('content')

    @include('common.nav-section')
    <hr class="color-9 my-0">

    <section class="font-1 py-4 h-full-non-fixed-nav">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-3 mb-4 text-center">
                    <div class="background-10 pb-4">
                        <img class="img-thumbnail radius-primary mt-3" src="{{$userProfile->profile->profile_picture}}" width="200">
                        <p class="mb-0 mt-3 fs-0">{{$userProfile->first_name.' '.$userProfile->last_name}}</p>

                        <p class="mb-0 text-muted small mb-2">@if(isset($userProfile->profile->session->name)){{$userProfile->profile->session->name}} @endif</p>


                        @if( isset($userProfile->profile->position))  <p class="mb-0 small">{{$userProfile->profile->position}}</p>
                        <p class="mb-0 small mb-2"> {{$userProfile->profile->company_institute}} </p>@endif

                        <div class="mb-3 small">
                            Lives in <strong>{{$userProfile->profile->dist_state.', '.$userProfile->profile->country->name}}</strong>
                        </div>
                        <a class="btn btn-outline-primary" href="{{route('profile.edit',['id'=>$userProfile->id])}}"><i class="fa fa-edit"></i> Edit Profile</a>
                    </div>
                </div>

                <div class="col-lg-6">
                    <h5>Summary</h5>
                    <hr class="short color-7 mt-2 left ">
                    <p>{{$userProfile->profile->summary}}</p>
                    <h5 class="pt-3">Education</h5>
                    <hr class="short color-7 mt-2 left ">
                    <ul class="pl-0 bullet-none">
                        @if(count($educationalDetails))
                            @foreach($educationalDetails as $educationalDetail)
                                <li class="fw-800">{{$educationalDetail->field_of_study }}</li>

                                <li class="small">{{$educationalDetail->degree->name.', '.$educationalDetail->passing_year}}</li>
                                <li class="small mb-2">{{$educationalDetail->institution}}</li>

                            @endforeach

                        @else
                            <p class="color-8">Not found</p>

                        @endif
                    </ul>
                    <h5 class="pt-3">Work Experience</h5>
                    <hr class="short color-7 mt-2 left ">
                    @if(count($workDetails))
                        <ul class="list-unstyled">
                            @foreach($workDetails as $workDetail)
                                <li class="fw-800">{{$workDetail->job_title.' | '.$workDetail->company_name}}</li>
                                <li class="small mb-2">{{$workDetail->duration}}</li>

                            @endforeach
                        </ul>
                    @else
                        <p class="color-8">Not found</p>
                    @endif
                    <h5 class="pt-3">Associate Graduates</h5>
                    <hr class="short color-7 mt-2 left ">
                    @if(!$fellowGraduates || $fellowGraduates->isEmpty() )
                        <small>No graduates found</small>
                    @else
                        <div class="row justify-content-left mt-4 text-left ml-2">
                            @foreach($fellowGraduates as $fellowGraduate)
                                <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
                                    <a href="{{route('alumni-directory.show',['id'=>$fellowGraduate->id])}}" target="_blank">
                                        <img class="radius-round" src="{{$fellowGraduate->profile->profile_picture}}" alt="Member" width="120">
                                        <h6 class="color-3 mt-3 mb-2">{{$fellowGraduate->first_name.' '.$fellowGraduate->last_name}}</h6>
                                    </a>
                                </div>
                            @endforeach


                            <div class="w-100"></div>

                            <a class="btn btn-outline-primary btn-capsule btn-sm my-2" href="{{route('alumni-directory', ['graduated' => $userProfile->profile->session->name])}}">See all of Class {{$userProfile->profile->session->name}}</a>
                        </div>
                    @endif
                </div>

                <div class="col-lg-3 col-12 text-left pl-lg-5">
                    @if($userProfile->userMetas->count()>0)
                        <div class="badge badge-warning">
                            <span class="fa fa-graduation-cap"></span> Willing to help
                        </div>
                        <div id="popover_content_wrapper_alumni" class="mt-2">
                                @foreach($userProfile->userMetas as $userMeta)
                                    <ul class="small pl-4">
                                        @foreach($userMetas as $key=>$val)
                                            @if($userMeta->value==$key)
                                                <li>{{$val}}</li>
                                                @if($key === 'willing_to_be_mentor')
                                                    <ul>
                                                        @foreach($userProfile->metorshipTopics as $topic)
                                                            <li>{{$topic->title}}</li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            @endif
                                        @endforeach
                                    </ul>
                                @endforeach
                            </div>
                    @endif
                </div>
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </section>

@endsection