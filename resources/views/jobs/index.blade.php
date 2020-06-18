@extends('layouts.master')

@section('title', 'Jobs')

@section('styles')
    <link href="{{asset('lib/semantic-ui-accordion/accordion.css')}}" rel="stylesheet">
    <link href="{{asset('lib/semantic-ui-dropdown/dropdown.css')}}" rel="stylesheet">
    <link href="{{asset('lib/semantic-ui-transition/transition.css')}}" rel="stylesheet">
@endsection

@section('content')

    @include('common.nav-section')

    <hr class="color-9 my-0">
    <section class="font-1 background-10" style="padding: 1.45rem 0;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h5>Latest Job Post</h5>
                </div>
            </div>
        </div>
    </section>

    <section class="font-1 py-4">
        <div class="container">
            <div class="row">
                <div class="col-12 col-lg-8 col-xl-9" id="app">
                    @include('common.notifications')

                    @if (Auth::user()->hasAnyRole('super-admin|admin|editor|faculty-stuff'))
                        <form class="background-11 py-2 px-2 mb-3" ref="form" action="{{route('jobs')}}" method="get">
                            <div class="row">
                                <div class="col-12 col-xl-5 py-2 text-center text-xl-left align-self-center">
                                    <div class="form-group mb-0">
                                        <div class="form-check form-check-inline ml-0 ml-xl-2">
                                            <label class="form-check-label">
                                                <input class="form-check-input"
                                                       id="inlineRadio1"
                                                       type="radio"
                                                       name="status"
                                                       value="all"
                                                       @change="statusUpdate"
                                                       v-model="selectedStatus"> All
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input"
                                                       id="inlineRadio1"
                                                       type="radio"
                                                       name="status"
                                                       value="pending"
                                                       @change="statusUpdate"
                                                       v-model="selectedStatus"> Pending
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input"
                                                       id="inlineRadio2"
                                                       type="radio"
                                                       name="status"
                                                       value="approved"
                                                       @change="statusUpdate"
                                                       @if(request('status')=='approved') checked @endif> Approved
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 col-xl-7 py-2 text-center text-xl-right align-self-center">
                                    <div class="form-check form-check-inline">
                                        <label class="form-check-label d-inline"> Select All
                                            <input class="mx-2 form-check-input"
                                                   id="checkAll"
                                                   type="checkbox"
                                                   @click="selectAll"
                                                   v-model="allSelected">
                                        </label>
                                        <select class="ui dropdown" v-model="approval">
                                            <option value="">Action</option>
                                            <option value="approve">Approve</option>
                                            <option value="disapprove">Disapprove</option>
                                            <option value="delete">Delete</option>
                                        </select>
                                        <button class="btn btn-primary hv-cursor-pointer" type="button" @click="batchAction" style="padding: 0.8rem 1.5rem;">Go</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        @foreach($allJobs as $allJob)
                            <div class="background-11 p-3 mb-2">
                                <div class="row">
                                    <div class="col-12 col-sm-8 col-md-6 mb-3">
                                        <a href="{{route('jobs.show',['id'=>$allJob->id])}}">
                                            <h5 class="mb-2">
                                                {{$allJob->job_title}}
                                                <small>
                                                    @if($allJob->job_type=='Internship')
                                                        <span class="badge badge-pill badge-warning mx-2 mb-1 text-uppercase">{{$allJob->job_type}}</span>

                                                    @elseif($allJob->job_type=='Full-time')
                                                        <span class="badge badge-pill badge-success mx-2 mb-1 text-uppercase">{{$allJob->job_type}}</span>

                                                    @elseif($allJob->job_type=='Part-time')
                                                        <span class="badge badge-pill badge-primary mx-2 mb-1 text-uppercase">{{$allJob->job_type}}</span>
                                                    @elseif($allJob->job_type=='Hourly')
                                                        <span class="badge badge-pill badge-danger mx-2 mb-1 text-uppercase">{{$allJob->job_type}}</span>

                                                    @elseif($allJob->job_type=='Remote')
                                                        <span class="badge badge-pill badge-default  mx-2 mb-1 text-uppercase">{{$allJob->job_type}}</span>

                                                    @elseif($allJob->job_type=='Contract')
                                                        <span class="badge badge-pill badge-info  mx-2 mb-1 text-uppercase">{{$allJob->job_type}}</span>
                                                    @endif
                                                </small>
                                            </h5>
                                        </a>
                                        <p class="color-5 fs--1">By: {{$allJob->company_name}}</p>
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-6 text-center text-md-right my-2">
                                        @if($allJob->is_approved==0)
                                            <a class="btn mb-2 mb-md-0 btn-outline-primary btn-xs" href="{{route('jobs.approve',['id'=>$allJob->id])}}" onclick="return chkConfirm();"><span class="fa fa-check-circle"></span> Approve</a>
                                        @endif
                                        <a class="btn mb-2 mb-md-0 btn-outline-warning btn-xs " href="{{route('jobs.edit',['id'=>$allJob->id])}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit</a>

                                        <a class="btn mb-2 mb-md-0 btn-outline-danger btn-xs" href="{{route('jobs.destroy',['id'=>$allJob->id])}}" onclick="return chkDelete();"><span class="fa fa-times-circle"></span> Delete</a>
                                        <label class="form-check-label mb-md-0">
                                            <input class="form-check-input" id="checkAll" @click="select" type="checkbox" v-model="jobIds" value="{{$allJob->id}}"> Select
                                        </label>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        <div class="py-4 d-flex justify-content-center">
                            {{ $allJobs->appends(request()->input())->links() }}
                        </div>
                    @endif

                    @if (Auth::user()->hasRole('alumni|student'))

                        @foreach($jobs as $job)

                            <div class="background-11 p-3 mb-2">
                                <div class="row">
                                    <div class="col-12 col-sm-8 col-md-6 mb-3">
                                        <a href="{{route('jobs.show',['id'=>$job->id])}}">
                                            <h5 class="mb-2">
                                                {{$job->job_title}}
                                                <small>
                                                    @if($job->job_type=='Internship')
                                                        <span class="badge badge-pill badge-warning mx-2 mb-1 text-uppercase">{{$job->job_type}}</span>

                                                    @elseif($job->job_type=='Full-time')
                                                        <span class="badge badge-pill badge-success mx-2 mb-1 text-uppercase">{{$job->job_type}}</span>

                                                    @elseif($job->job_type=='Part-time')
                                                        <span class="badge badge-pill badge-primary mx-2 mb-1 text-uppercase">{{$job->job_type}}</span>
                                                    @elseif($job->job_type=='Hourly')
                                                        <span class="badge badge-pill badge-danger mx-2 mb-1 text-uppercase">{{$job->job_type}}</span>

                                                    @elseif($job->job_type=='Remote')
                                                        <span class="badge badge-pill badge-default  mx-2 mb-1 text-uppercase">{{$job->job_type}}</span>

                                                    @elseif($job->job_type=='Contract')
                                                        <span class="badge badge-pill badge-info  mx-2 mb-1 text-uppercase">{{$job->job_type}}</span>
                                                    @endif
                                                </small>
                                            </h5>
                                        </a>
                                        <p class="color-5 fs--1">By: {{$job->company_name}}</p>
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-6 text-center text-md-right my-2">

                                        <a class="btn mb-2 mb-md-0 btn-outline-warning btn-xs " href="{{route('jobs.show',['id'=>$job->id])}}">Details</a>

                                    </div>
                                </div>
                            </div>

                        @endforeach
                        {{ $jobs->appends(request()->input())->links() }}

                    @endif
                </div>

                <div class="col-12 col-lg-4 col-xl-3 px-0 py-0 mt-3 mt-lg-0">
                    <div class="background-oxford color-white p-3">
                        <p class="mb-0"><i class="fa fa-search mr-2" aria-hidden="true"></i>Search Job </p>
                    </div>
                    <form class="background-11 py-3 px-3" method="get" action="{{route('jobs')}}">
                        <div class="form-group mt-2">
                            <input class="form-control background-white" type="text" name="q" placeholder="Search by keyword" value="@if(request('q')){{(request('q'))}}@endif">

                            <select class="ui dropdown w-100 mt-3" name="type">
                                <option value="">Select</option>
                                @foreach(['All','Full-time','Internship','Hourly','Remote','Part-time','Contract'] as $jobType)
                                    <option value="{{$jobType}}" @if(request('type')==$jobType)selected @endif>{{$jobType}}</option>
                                @endforeach
                            </select>

                            <div class="text-right">
                                <button class="btn btn-xs btn-outline-primary hv-cursor-pointer  mt-2" type="submit">Search</button>
                            </div>
                        </div>
                    </form>

                    <div class="mx-3 mx-sm-0 mt-3">
                        <a class="btn btn-block btn-primary" href="{{route('jobs.create')}}">
                            <i class="fa fa-plus-circle mr-2"></i>Post a new job
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection

@section('scripts')

    <script src="{{asset('lib/semantic-ui-accordion/accordion.js')}}"></script>
    <script src="{{asset('lib/semantic-ui-dropdown/dropdown.js')}}"></script>
    <script src="{{asset('lib/semantic-ui-transition/transition.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>


    <script src="https://unpkg.com/vue@2.5.9/dist/vue.js"></script>

    <script>

        let app = new Vue({
            el: '#app',
            data: {
                selected: [],
                allSelected: false,
                jobIds: [],
                allJobIds:{{$allJobs->pluck('id')}},
                approval: '',
                selectedStatus: '<?php if (request('status') == 'pending') {
                    echo 'pending';
                } elseif (request('status') == 'approved') {
                    echo 'approved';
                } elseif (request('status') == 'all') {
                    echo 'all';
                } else {
                    echo 'all';
                }

                    ?>'
                ,
            },
            methods: {
                selectAll: function (e) {

                    this.jobIds = [];
                    if (e.target.checked) {
                        this.jobIds = this.allJobIds;
                    }
                    else {
                        this.jobIds = [];
                    }
                },
                select: function () {
                    this.allSelected = false;
                },
                batchAction: function () {

                    let ids = this.jobIds;
                    let action = this.approval;
                    let test = this.test;

                    window.location = "{{route('jobs.batch-action')}}?action=" + action + "&ids=" + ids.join();
                },
                statusUpdate: function () {

                    this.$refs.form.submit();
                },
                refineAffiliation: function () {

                    let affiliation = this.affiliation;
                    let curUrl = "{{ url()->full()}}";
                    console.log(curUrl);
                    window.location = curUrl + "&affiliation=" + affiliation;
                },
                submitStatus: function () {

                }
            }
        });

        function chkDelete() {
            return confirm('Are you sure you want to delete this job ?');
        }

        function chkConfirm() {
            return confirm('Are you sure you want to approve this job ?');
        }
    </script>

@endsection