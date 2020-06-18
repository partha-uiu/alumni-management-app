@extends('layouts.master')

@section('title', 'Poll-Vote-Details')

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
                    <h5>Poll Vote Details</h5>
                </div>
            </div>
        </div>
    </section>

    <section class="font-1 pt-2 pb-4">
        <div class="container">
            <div id="app">
                <div class="row p-2">
                    @include('common.notifications')
                    <div class="col-md-4 offset-md-4  mb-2 mb-2">


                        <div class="card h-100">
                            <div class="card-header p-2 background-white">
                                <p class="text-right">
                                    <span><a href="{{route('poll.home')}}">Back to list</a></span>
                                </p>
                            </div>
                            <div class="card-block">
                                @foreach( $userVoteDetails as  $userVoteDetails)
                                    @if($loop->index < 1)
                                        <p class="font-weight-bold text-primary">{{$userVoteDetails->poll->title}}</p>
                                        <p class="small">You answered : <br/></p>
                                    @endif

                                    <ul>
                                        <li class="small text-muted">{{$userVoteDetails->name}}</li>

                                    </ul>

                                @endforeach
                            </div>
                            <div class="card-footer background-transparent border-top-0">

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection


