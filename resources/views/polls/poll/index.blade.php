@extends('layouts.master')

@section('title', 'Poll-Lists')

@section('styles')

@endsection

<!-- Main stylesheet and color file-->

@section('content')

    @include('common.nav-section')

    <hr class="color-9 my-0">
    <section class="font-1 background-10" style="padding: 1.45rem 0;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h5>Polls</h5>
                </div>
            </div>
        </div>
    </section>

    <section class="font-1 pt-2 pb-4">
        <div class="container overflow-hidden">
            <div id="app">
                <div class="row p-2" style="min-height: 470px;">
                    @if(!count($polls))
                        @if (Auth::user()->hasAnyRole('super-admin|admin|editor|faculty-stuff'))
                            <div class="col-12 text-right mb-2">
                                <a href="{{route('poll.create')}}" class="btn btn-outline-primary btn-sm"><i
                                            class="fa fa-plus mr-1"></i>Add New </a>
                            </div>
                        @endif
                        <div class="col-lg-12">
                            <div class="alert alert-info">No poll is created yet !</div>
                        </div>
                    @else
                        @include('common.notifications')
                        @if (Auth::user()->hasAnyRole('super-admin|admin|editor|faculty-stuff'))
                            <div class="col-12 text-right mb-2">
                                <a href="{{route('poll.create')}}" class="btn btn-outline-primary btn-sm"><i
                                            class="fa fa-plus mr-1"></i>Add New </a>
                            </div>
                        @endif
                        @if (Auth::user()->hasAnyRole('super-admin|admin|editor|faculty-stuff'))

                            @foreach($polls as $poll)
                                <div class="col-md-4 mb-5">
                                    <div class="card h-100">
                                        <div class="card-header p-0 background-white">
                                            <p class="text-right p-2">@if($poll->poll->status==0)
                                                    <span class="badge badge-success">{{'Open'}}</span>
                                                @else
                                                    <span class="badge badge-danger"> {{'Closed'}} </span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="card-block">
                                            <a href="{{route('poll.result',['id'=>$poll->poll->id])}}"><h5 class="card-title">{{$poll->poll->title}}</h5></a>
                                            <p class="card-text color-4 fw-300 font-1">{{$poll->name}}</p>
                                            <ul>
                                                @foreach($poll->poll->options as $option)
                                                    <li class="card-text color-2 font-1">{{$option->name}}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="card-footer background-transparent border-top-0">
                                            <div class="row">
                                                <div class="col-4">
                                                    <h6 class=" mt-2 text-muted">Votes
                                                        : {{$poll->totalVotes}} </h6>
                                                </div>

                                                <div class="col-8 text-right pt-2">
                                                    <div class="lh-1">
                                                        <p><a class="card-link"
                                                              href="{{route('poll.edit',['id'=>$poll->poll->id])}}"><i
                                                                        class="fa fa-edit"></i></a>
                                                            <a class="card-link"
                                                               href="{{route('poll.destroy',['id'=>$poll->poll->id])}}"
                                                               onclick="return chkDelete();"> <i
                                                                        class="fa fa-times-circle"></i></a>
                                                            @if($poll->poll->status==0)
                                                                <a class="card-link"
                                                                   href="{{route('poll.change-status',['id'=>$poll->poll->id,'status'=>1])}}"><i
                                                                            class="fa fa-unlock"></i></a>
                                                            @else
                                                                <a class="card-link"
                                                                   href="{{route('poll.change-status',['id'=>$poll->poll->id,'status'=>0])}}"><i
                                                                            class="fa fa-lock"></i></a>

                                                            @endif</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        @elseif(Auth::user()->hasAnyRole('alumni|student'))

                            <?php $userVotedPolls = [];

                            foreach ($allVotes as $allVote) {
                                $userVotedPolls[] = $allVote->option->poll_id;
                            }

                            ?>

                            @foreach($polls as $poll)
                                <div class="col-md-4 mb-5">
                                    <div class="card h-100">
                                        <div class="card-header p-0 background-white">
                                            <p class="text-right p-2">@if($poll->poll->status==0)
                                                    <span class="badge badge-success">{{'Open'}}</span>
                                                @else
                                                    <span class="badge badge-danger"> {{'Closed'}} </span>
                                                @endif
                                            </p>
                                        </div>
                                        <div class="card-block">

                                            <a href="{{route('poll.result',['id'=>$poll->poll->id])}}"><h5 class="card-title">{{$poll->poll->title}}</h5></a>
                                            <p class="card-text color-4 fw-300 font-1">{{$poll->name}}</p>
                                            <ul>
                                                @foreach($poll->poll->options as $option)
                                                    <li class="card-text color-2 font-1">{{$option->name}}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                        <div class="card-footer background-transparent border-top-0">
                                            <div class="py-2 pl-0 pr-0">
                                                <div class="row">
                                                    <div class="col-4">
                                                        <h6 class=" mt-2 text-muted">Votes
                                                            : {{$poll->totalVotes}} </h6>
                                                    </div>
                                                    <div class="col-8 align-self-end text-right">

                                                        @if(in_array($poll->poll->id,$userVotedPolls))
                                                            @if($poll->poll->status==0)

                                                                <a href="{{route('poll.user-vote-details',['id'=>$poll->poll->id])}}"
                                                                   target="_blank" class="small">View your votes</a>

                                                            @else($poll->poll->status==1)
                                                                <a href="{{route('poll.result',['id'=>$poll->poll->id])}}"
                                                                   class="card-link btn btn-outline-primary btn-xs hv-cursor-pointer"
                                                                   target="_blank">Result</a>
                                                            @endif
                                                        @else
                                                            @if($poll->poll->status==0)
                                                                <a href="{{route('poll.vote',['id'=>$poll->poll->id])}}"
                                                                   class="card-link btn btn-success btn-xs"
                                                                   target="_blank">Vote</a>
                                                            @else
                                                                <a href="{{route('poll.result',['id'=>$poll->poll->id])}}"
                                                                   class="card-link btn btn-outline-primary btn-xs hv-cursor-pointer"
                                                                   target="_blank">Result</a>
                                                            @endif
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                        @endif
                    @endif
                </div>
            </div>
        </div>
    </section>

@endsection


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.21.0/moment.min.js"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://unpkg.com/vue@2.5.9/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js"
            integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb"
            crossorigin="anonymous"></script>
    <script src="assets/lib/owl.carousel/dist/owl.carousel.min.js"></script>

    <script>
        let app = new Vue({
            el: '#app',
            data: {
                feedEvents: [],
                feedType: '',
                moment: moment,
                pageCount: 0
            },
            methods: {
                getFeeds: function (feedTypeValue) {
                    if (app.feedType != feedTypeValue && app.feedType != 'more') {
                        app.feedType = feedTypeValue;
                        app.pageCount = 0;
                    }
                    else {

                        return;
                    }

                    axios.post('/getFeeds', {
                        data: feedTypeValue
                    })
                        .then(function (response) {
                            console.log(response.data[0].user_id);
                            app.feedEvents = [];
                            for (var i = 0; i < response.data.length; i++) {
                                app.feedEvents.push(response.data[i]);
                            }
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                },
                loadMoreFeeds: function (feedTypeValue, feedType) {

                    app.pageCount = app.pageCount + 1;

                    axios.post('/getFeeds?pageCount=' + app.pageCount + '&type=' + app.feedType, {

                        data: feedTypeValue
                    })

                        .then(function (response) {

                            for (var i = 0; i < response.data.length; i++) {
                                app.feedEvents.push(response.data[i]);
                            }

                        })
                        .catch(function (error) {
                            console.log(error);
                        });

                },

                goto_route_donation: function (param1) {
                    route = "{{ route('donations.show', ['id' => '?anytagtoreplace?']) }}";
                    location.href = route.replace('?anytagtoreplace?', param1)
                },

                goto_route_event: function (param1) {
                    route = "{{ route('events.show', ['id' => '?anytagtoreplace?']) }}";
                    location.href = route.replace('?anytagtoreplace?', param1)
                },

                goto_route_news: function (param1) {
                    route = "{{ route('news.show', ['id' => '?anytagtoreplace?']) }}";
                    location.href = route.replace('?anytagtoreplace?', param1)
                },

                goto_route_job: function (param1) {
                    route = "{{ route('jobs.show', ['id' => '?anytagtoreplace?']) }}";
                    location.href = route.replace('?anytagtoreplace?', param1)
                },

                strip_html_tags: function (str) {
                    if ((str === null) || (str === ''))
                        return false;
                    else {
                        str = str.toString();
                        return str.replace(/<[^>]*>/g, '');
                    }
                },
            },
        });

        function chkDelete() {
            return confirm('Are you sure you want to delete this poll ?');
        }
    </script>

@endsection
