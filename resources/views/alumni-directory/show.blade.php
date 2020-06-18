@extends('layouts.master')

@section('title', 'Directory | Details')

@section('content')

    @include('common.nav-section')

    <hr class="color-9 mt-0">
    <section class="font-1 py-3">
        <div class="container">
            <div class="row justify-content-center ">
                <div class="col-lg-3 background-11 ">
                    <div class="row font-1 text-center">
                        <div class="col text-center">
                            <a href="#"><img class="img-thumbnail radius-primary mt-3" src="{{$alumni->profile->profile_picture}}" width="150" height="150"></a>
                            <p class="mb-0 mt-3 fs-0">{{$alumni->first_name.' '.$alumni->last_name}}</p>
                            <p class="mb-0 text-muted small mb-2">@if(isset($alumni->profile->session->name)){{$alumni->profile->session->name}} @endif</p>
                            @if( isset($alumni->profile->position))  <p class="mb-0 small">{{$alumni->profile->position}}</p>
                            <p class="mb-0 small mb-2"> {{$alumni->profile->company_institute}} </p>@endif
                            <p class="mb-0 small"><strong>Lives in</strong> {{$alumni->profile->dist_state.', '.$alumni->profile->country->name}}</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 pl-lg-5">
                    @if($alumni->userMetas->count())
                        <h5 class="color-warning"><span class="fa fa-graduation-cap pr-3"></span>Willing to help</h5>
                    
                        <div id="popover_content_wrapper_alumni" style="">
                            @foreach($alumni->userMetas as $userMeta)

                                <div>
                                    <ul class="small text-muted">
                                            @foreach($userMetas as $key=>$val)
                                                @if($userMeta->value==$key)
                                                    <li> {{$val}}</li>
                                                @endif
                                            @endforeach
                                    </ul>
                                </div>
                            @endforeach
                        </div>
                    
                    
                    @endif
                    <h5 class="pt-3">Summary</h5>
                    <p>{{$alumni->profile->summary}}</p>
                    <h5 class="pt-3">Education</h5>
                    <ul class="pl-0 bullet-none">
                        @if(count($educationalDetails))
                            @foreach($educationalDetails as $educationalDetail)
                                <li>{{$educationalDetail->field_of_study }}</li>

                                <li class="small text-muted">{{$educationalDetail->degree->name.', '.$educationalDetail->passing_year}}</li>
                                <li class="small  text-muted mb-2">{{$educationalDetail->institution}}</li>

                            @endforeach

                        @else
                            <p class="color-8">Not found</p>

                        @endif
                    </ul>
                    <h5 class="pt-3">Work Experience</h5>
                    @if(count($workDetails))
                        <ul class="list-unstyled">
                            @foreach($workDetails as $workDetail)
                                <li style="font-weight: bold">{{$workDetail->job_title.' | '.$workDetail->company_name}}</li>
                                <li class="text-muted small mb-2">{{$workDetail->duration}}</li>

                            @endforeach
                        </ul>
                    @else
                        <p class="color-8">Not found</p>
                    @endif
                    <h5 class="pt-3">Associate Graduates</h5>
                    <hr class="short color-7 mt-2 left ">
                    <div class="row justify-content-left mt-4 text-left ml-2">

                        @if(!$fellowGraduates || $fellowGraduates->isEmpty() )
                            <p class="color-8">No graduates found !</p>

                        @else
                            @foreach($fellowGraduates as $fellowGraduate)
                                <div class="col-sm-6 col-md-4 col-lg-3 mb-2">
                                    <a href="{{route('alumni-directory.show',['id'=>$fellowGraduate->id])}}" target="_blank">
                                        <img class="radius-round" src="{{$fellowGraduate->profile->profile_picture}}" alt="Member" width="120">
                                        <h6 class="color-3 mt-3 mb-2">{{$fellowGraduate->first_name.' '.$fellowGraduate->last_name}}</h6>
                                    </a>
                                </div>
                            @endforeach


                            <div class="w-100"></div>

                            <a class="btn btn-outline-primary btn-capsule btn-sm my-2" href="{{route('alumni-directory', ['graduated' => $alumni->profile->session->name])}}">See all of Class {{$alumni->profile->session->name}}</a>
                        @endif
                    </div>



                </div>

                <div class="col-lg-3 pl-lg-5">
                    {{--<div class="fs--1 fw-600"><a class="d-block btn btn-outline-dark btn-sm my-2" href="#">Send Message</a></div>--}}
                    @if (Auth::user()->hasAnyRole('super-admin|admin|editor|faculty-stuff'))
                        <a class="d-block btn btn-outline-warning btn-sm my-2" href="{{route('alumni-directory.edit',['id'=>$alumni->id])}}">Edit</a>
                        <p class="mt-4 text-center">Connect on<span class="fa fa-facebook-official pl-3"></span><span class="fa fa-linkedin-square pl-3"></span></p>

                </div>
                @endif
            </div>
        </div>
        <!--/.row-->
        <!--/.container-->
    </section>

@endsection