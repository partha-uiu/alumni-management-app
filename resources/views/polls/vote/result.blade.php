@extends('layouts.master')

@section('title', 'Poll-Lists')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker3.min.css"/>
@endsection

<!-- Main stylesheet and color file-->

@section('content')

    @include('common.nav-section')

    <hr class="color-9 my-0">
    <section class="font-1 background-10" style="padding: 1.45rem 0;">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @if($pollStatus->status==1)
                        <h5>Polls - Result</h5>
                    @elseif($pollStatus->status==0)
                        <h5>Polls - Details</h5>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <section class="font-1 pt-2 pb-4">
        <div class="container">
            <div class="row pb-4">
                <div class="col-md-6 offset-md-3">

                    <div class="card h-100">
                        <div class="card-header p-0 background-white">
                            <p class="text-right p-2"><a href="{{route('poll.home')}}">Back to list</a>
                            </p>
                        </div>
                        @if($pollStatus->status==1)


                            <div class="card-block">
                                <h5 class="text-primary mb-3">{{$voteResults[0]->poll->title}}</h5>
                                <?php
                                $percent = 0;
                                $max = [];
                                foreach($voteResults as $voteResult) {

                                if ($sum == 0) {
                                    $percent = 0;
                                } else {
                                    $percent = ($voteResult->votes * 100) / ($sum);
                                    $max[] = $percent;
                                }
                                ?>


                                <p class="text-left font-weight-bold "><?php echo $voteResult->name; ?> <span class='pull-right'><?php echo number_format($percent, 2); ?>%</span></p>

                                <div class="progress mb-3">
                                    <div class="progress-bar progress-bar-striped bg-info" role="progressbar" style="width:<?php echo $percent; ?>%" aria-valuenow="<?php echo $percent; ?>"
                                         aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <?php } ?>
                            </div>


                            <div class="card-footer background-transparent border-top-0">
                                <p class="text-primary"><span class="font-weight-bold">@if(count($max)) Maximum count : {{number_format(max($max))}}% @endif</span></p>
                            </div>
                        @else
                            <ul class="text-left">
                                <h5 class="text-primary mb-3 pt-4">{{$voteResults[0]->poll->title}}</h5>

                                @foreach($voteResults as $voteResult)
                                    <li> <?php echo $voteResult->name; ?> </li>
                                @endforeach
                            </ul>
                        @endif
                    </div>

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
@endsection
