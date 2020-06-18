@extends('layouts.master')

@section('title', 'Job | '.$job->job_title.' at '.$job->company_name)

@section('content')

    @include('common.nav-section')
    <hr class="color-9 my-0">


    <section class="font-1 py-4">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 pb-4">
                    @include('feed.partials.alumni_feed_categories', ['active' => 'job'])
                </div>
                <div class="col-lg-9 mb-4">
                    <h4 class="mb-2">{{$job->job_title}} at {{$job->company_name}}</h4>
                    <small class="color-5">
                        <i class="fa fa-calendar"></i> Posted on {{Carbon\Carbon::createFromFormat('Y-m-d', $job->post_date)->format('d M Y')}}
                    </small>

                    <div class="my-4">
                        <h6>Job Title</h6>
                        <p class="ml-4">{{$job->job_title}}</p>

                        <h6>Company Name</h6>
                        <p class="ml-4">{{$job->company_name}}</p>

                        @if($job->vacancy)
                            <h6>Vacancy</h6>
                            <p class="ml-4">{{$job->vacancy}}</p>
                        @endif

                        @if($job->description)
                            <h6>Job Description</h6>
                            <p class="ml-4">{!! $job->description !!}</p>
                        @endif

                        @if($job->job_type)
                            <h6>Job Nature</h6>
                            <p class="ml-4">{{$job->job_type}}</p>
                        @endif

                        @if($job->educational_requirements)
                            <h6>Educational Requirements</h6>
                            <div class="ml-4">{!! $job->educational_requirements !!}</div>
                        @endif

                        @if($job->job_requirements)
                            <h6>Job Requirements</h6>
                            <div class="ml-4">{!! $job->job_requirements !!}</div>
                        @endif

                        @if($job->location)
                            <h6>Location</h6>
                            <p class="ml-4">{{$job->location}}</p>
                        @endif

                        @if($job->salary_range)
                            <h6>Salary Range</h6>
                            <p class="ml-4">{{$job->salary_range}}</p>
                        @endif

                        @if($job->other_benefits)
                            <h6>Other Benefits</h6>
                            <div class="ml-4">{!! $job->other_benefits !!}</div>
                        @endif

                        @if($job->url)
                            <h6>Company Website</h6>
                            <p class="ml-4"><a href="{{$job->url}}">{{$job->url}}</a></p>
                        @endif

                        @if($job->other_benefits)
                            <h6>Other Benefits</h6>
                            <p class="ml-4">{{$job->other_benefits}}</p>
                        @endif

                        <h6>Posted on</h6>
                        <p class="ml-4">{{Carbon\Carbon::createFromFormat('Y-m-d', $job->post_date)->format('d M Y')}}</p>

                        <h6>Last day of submission</h6>
                        <p class="ml-4 color-danger">{{Carbon\Carbon::createFromFormat('Y-m-d', $job->end_date)->format('d M Y')}}</p>

                        @if($job->apply_instruction)
                            <h6>Apply Instruction:</h6>
                            <div class="border border-color-8 p-4 mt-3">
                                {{$job->apply_instruction}}
                            </div>
                        @endif

                    </div>

                    <a href="{{url()->previous()}}" class="btn btn-outline-dark my-2">
                        <i class="fa fa-angle-left mr-2"></i> Go Back
                    </a>
                </div>

            </div>
        </div>
    </section>

@endsection

@section('styles')
    <link href="{{asset('css/right-scrollbar.css')}}" rel="stylesheet">
@endsection


