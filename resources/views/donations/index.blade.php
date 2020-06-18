@extends('layouts.master')

@section('title', 'Donation')

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
                    <h5>Latest Donation/Fundraising</h5>
                </div>
            </div>
        </div>
    </section>

    <section class="font-1 py-4">
        <div class="container">
            <div class="row" id="app">
                <div class="col-12 col-lg-8 col-xl-9">
                    @include('common.notifications')

                    @if (Auth::user()->hasRole('alumni|student'))

                        @foreach($approvedDonations as $approvedDonation )

                            <div class="background-11 p-3 mb-2">
                                <div class="row">
                                    <div class="col-4 col-sm-3 col-md-2">
                                        <div class="background-oxford color-white p-2  text-center font-1 radius-primary lh-1">
                                            <div class="fs-2">@if($approvedDonation->start_date) {{Carbon\Carbon::createFromFormat('Y-m-d', $approvedDonation->start_date)->format('d')}} @else{{"No start date found !"}} @endif </div>
                                            <div class="d-block">@if($approvedDonation->start_date)  {{Carbon\Carbon::createFromFormat('Y-m-d', $approvedDonation->start_date)->format('M')}}@else {{""}} @endif</div>
                                        </div>

                                    </div>
                                    <div class="col">
                                        <div class="fs-1 mb-1">
                                            <a href="{{route('donations.show',['id'=>$approvedDonation->id])}}">
                                                {{$approvedDonation->title}}
                                            </a>
                                        </div>
                                        <small>End Date: @if($approvedDonation->end_date)  {{Carbon\Carbon::createFromFormat('Y-m-d', $approvedDonation->end_date)->format('d M Y')}} @else {{"No end date found"}} @endif</small>
                                        <p class="mt-2">{!!   str_limit($approvedDonation->description,50) !!}</p>
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-3 col-xl-2 text-center text-lg-right">
                                        <div class="p-3 p-lg-0 ml-2">

                                            <a class="btn mb-2 mb-md-0 btn-outline-warning btn-xs btn-block " href="{{route('donations.show',['id'=>$approvedDonation->id])}}">Details</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        {{ $approvedDonations->appends(request()->input())->links() }}
                    @endif

                    @if (Auth::user()->hasAnyRole('super-admin|admin|editor|faculty-stuff'))
                        <form class="background-11 py-2 px-2 mb-3" ref="form" action="{{route('donations')}}" method="get">
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
                                        <label class="form-check-label d-inline">Select All
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
                                        <button class="btn btn-primary btn-sm hv-cursor-pointer" type="button" @click="batchAction" style="padding: 0.8rem 1.5rem;">Go</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        @foreach($allDonations as $allDonation )
                            <div class="background-11 p-3 mb-2">
                                <div class="row">
                                    <div class="col-4 col-sm-3 col-md-2">
                                        <div class="background-oxford color-white p-2  text-center font-1 radius-primary lh-1">
                                            <div class="fs-2">@if($allDonation->start_date) {{Carbon\Carbon::createFromFormat('Y-m-d', $allDonation->start_date)->format('d')}} @else{{"No start date found !"}} @endif </div>
                                            <div class="d-block">@if($allDonation->start_date)  {{Carbon\Carbon::createFromFormat('Y-m-d', $allDonation->start_date)->format('M')}}@else {{""}} @endif</div>
                                        </div>
                                        <label class="form-check-label py-3">
                                            <input class="form-check-input" id="checkAll" @click="select" type="checkbox" v-model="donationIds" value="{{$allDonation->id}}"> Select
                                        </label>
                                    </div>
                                    <div class="col">
                                        <div class="fs-1 mb-1">
                                            <a href="{{route('donations.show',['id'=>$allDonation->id])}}">
                                                {{$allDonation->title}}
                                            </a>
                                        </div>
                                        <small>End Date: @if($allDonation->end_date)  {{Carbon\Carbon::createFromFormat('Y-m-d', $allDonation->end_date)->format('d M Y')}} @else {{"No end date found"}} @endif</small>
                                        <p class="mt-2">{!!   str_limit($allDonation->description,50) !!}</p>
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-3 col-xl-2 text-center text-lg-right">
                                        <div class="p-3 p-lg-0 ml-2">
                                            @if($allDonation->is_approved==0)
                                                <a class="btn mb-2 btn-outline-primary btn-xs btn-block" href="{{route('donations.approve',['id'=>$allDonation->id])}}" onclick="return chkConfirm();"><span class="fa fa-check-circle"></span> Approve</a>
                                            @endif
                                            <a class="btn mb-2 mb-md-0 btn-outline-warning btn-xs btn-block " href="{{route('donations.edit',['id'=>$allDonation->id])}}"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Edit</a>

                                            <a class="btn mb-2 mb-md-0 btn-outline-danger btn-xs btn-block" href="{{route('donations.destroy',['id'=>$allDonation->id])}}" onclick="return chkDelete();"><span class="fa fa-times-circle"></span> Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="py-4 d-flex justify-content-center">
                            {{ $allDonations->appends(request()->input())->links() }}
                        </div>
                    @endif
                </div>

                <div class="col-12 col-lg-4 col-xl-3 px-0 py-0 mt-3 mt-lg-0">
                    <div class="background-oxford color-white p-3">
                        <p class="mb-0"><i class="fa fa-search mr-2" aria-hidden="true"></i>Search Donations</p>
                    </div>
                    <form class="background-11 py-3 px-3" method="get" action="{{route('donations')}}">
                        <div class="form-group">
                            <input class="form-control background-white" type="text" name="q" placeholder="Search by keyword" value="@if(request('q')){{(request('q'))}}@endif">

                            <div class="text-right">
                                <button class="btn btn-xs btn-outline-primary hv-cursor-pointer  mt-2" type="submit">Search</button>
                            </div>
                        </div>
                    </form>
                    <div class="mx-3 mx-sm-0 mt-3">
                        <a class="btn btn-block btn-primary mr-2" href="{{route('donations.create')}}">
                            <i class="fa fa-plus-circle"></i> Create donation
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('scripts')
    <script src="https://unpkg.com/vue@2.5.9/dist/vue.js"></script>
    <script>
        let app = new Vue({
            el: '#app',
            data: {
                selected: [],
                allSelected: false,
                donationIds: [],
                allDonationIds:{{$allDonations->pluck('id')}},
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

                    this.donationIds = [];
                    if (e.target.checked) {
                        this.donationIds = this.allDonationIds;
                    }
                    else {
                        this.donationIds = [];
                    }
                },
                select: function () {
                    this.allSelected = false;
                },
                batchAction: function () {

                    let ids = this.donationIds;
                    let action = this.approval;
                    let test = this.test;

                    window.location = "{{route('donations.batch-action')}}?action=" + action + "&ids=" + ids.join();
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
            return confirm('Are you sure you want to delete this donation ?');
        }

        function chkConfirm() {
            return confirm('Are you sure you want to approve this donation ?');
        }
    </script>

    <script src="{{asset('lib/semantic-ui-accordion/accordion.js')}}"></script>
    <script src="{{asset('lib/semantic-ui-dropdown/dropdown.js')}}"></script>
    <script src="{{asset('lib/semantic-ui-transition/transition.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>

@endsection