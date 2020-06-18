@extends('layouts.master')

@section('title', 'Poll-Vote')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker3.min.css"/>
@endsection

<!-- Main stylesheet and color file-->

@section('content')

    @include('common.nav-section')

    <hr class="color-9 my-0">

    <section class="font-1 py-4 h-full-non-fixed-nav">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-3 pb-4">
                    @include('feed.partials.alumni_feed_categories', ['active' => 'poll'])
                </div>
                <div class="col-lg-8 mb-4 ml-auto">
                    @php
                        $userVotedPolls = [];

                        foreach ($allVotes as $allVote) {
                            $userVotedPolls[] = $allVote->option->poll_id;
                        }
                    @endphp

                    @if(in_array($polls->id, $userVotedPolls))
                        <div class="mb-4 alert alert-success">Thanks for your vote.</div>
                    @endif

                    <h4 class="mb-3 p-0 lh-3">{{$polls->title}}</h4>
                    @if(session('error'))
                        <div class="my-4 alert alert-danger">{{session('error')}}</div>
                    @endif
                    <form method="post" action="{{route('poll.vote',['id'=>$polls->id])}}">
                        {{csrf_field()}}
                        @if($polls->max_checkable > 1)
                            <div class="fs--1 color-3 pb-3">You can select maximum {{$maxCheck}} options</div>
                            <input type="hidden" name="checkbox_type">
                            @foreach($polls->options as $poll)
                                <div class="zinput zcheckbox">
                                    <input id="<?php echo "option" . $poll->id;?>" name="options[]" value="{{$poll->id}}" name="cb6" type="checkbox">
                                    <label for="<?php echo "option" . $poll->id;?>">{{$poll->name}}</label>
                                </div>
                            @endforeach
                        @else
                            <input type="hidden" name="radio_type">
                            @foreach($polls->options as $poll)
                                <div class="zinput zradio">
                                    <input name="options" id="<?php echo "option" . $poll->id;?>" value="{{$poll->id}}" type="radio">
                                    <label for="<?php echo "option" . $poll->id;?>">{{$poll->name}}</label>
                                </div>
                            @endforeach
                        @endif

                        @if($polls->end_date && !in_array($polls->id, $userVotedPolls))
                            <div class="mt-3">
                                @php
                                    $date = Carbon\Carbon::parse($polls->end_date);
                                    $now = Carbon\Carbon::now();
                                    $diff = $date->diffInDays($now);
                                @endphp
                                <span class="color-danger"> {{$diff}} days left for voting</span>
                            </div>
                        @endif

                        <div class="mt-4">
                            @if(!in_array($polls->id, $userVotedPolls))
                                <button type="submit" class="btn btn-outline-dark hv-cursor-pointer">VOTE</button>
                            @else
                                <a href="#" class="btn btn-outline-dark hv-cursor-pointer disabled">VOTED</a>
                            @endif

                            <a href="{{route('feed')}}" class="btn btn-default color-4">Back to feed</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection


@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>

    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <script src="https://unpkg.com/vue@2.5.9/dist/vue.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb"
            crossorigin="anonymous"></script>

    <script>
        let app = new Vue({
            el: '#app',
            data: {
                rows: [{options: ""}, {options: ""}],
                works: []

            },
            methods: {
                addRow: function () {
                    this.rows.push({options: ""});
                },
                removeRow: function (row) {
                    let index = this.rows.indexOf(row)
                    this.rows.splice(index, 1);
                },

            }
        });
    </script>

    <script>
        $('#end_date').datepicker({
            format: 'dd-mm-yyyy',
            startView: 2,
            todayHighlight: true
        })
    </script>

@endsection
