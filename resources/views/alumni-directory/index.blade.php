@extends('layouts.master')

@section('title', 'Directory')

@section('content')

    @include('common.nav-section')

    <hr class="color-9 my-0">
    <section class="font-1 background-10 py-3">
        <div class="container">
            <div class="row text-left">
                <div class="col-12 col-md-6 col-lg-5 align-self-center">
                    <h5>Find the like minded people <span class="fa fa-question-circle-o"></span></h5>
                </div>

                <div class="col-12 col-md-6 col-lg-6">
                    <form method="get" action="{{route('alumni-directory')}}">

                        @hasanyrole('super-admin|admin|editor|faculty-stuff')
                            @if(request('status') && request('status')!='')
                                <input class="form-control background-white" type="hidden" name="status" value="{{(request('status'))}}">
                            @endif
                            @if(request('affiliation') && request('affiliation')!='')
                                <input class="form-control background-white" type="hidden" name="affiliation" value="{{(request('affiliation'))}}">
                            @endif
                            @if(request('graduated') && request('graduated')!='')
                                <input class="form-control background-white" type="hidden" name="graduated" value="{{(request('graduated'))}}">
                            @endif

                            @if(count(request('willing_to_help')))
                                @php $willing_to_help = request('willing_to_help'); @endphp
                                @foreach($willing_to_help as $whelp)
                                    <input class="form-control background-white" type="hidden" name="willing_to_help[]" value="{{$whelp}}">
                                @endforeach
                            @endif

                            @php $searchSessions = request('session_id', []); @endphp

                            @if(count($searchSessions))
                                @foreach($searchSessions as $session)
                                    <input class="form-control background-white" type="hidden" name="session_id[]" value="{{$session}}">
                                @endforeach
                            @endif
                        @endhasrole

                        @hasanyrole('alumni|student')
                            @if(request('affiliation') && request('affiliation')!='')
                                <input class="form-control background-white" type="hidden" name="affiliation" value="{{(request('affiliation'))}}">
                            @endif

                            @if(request('graduated') && request('graduated')!='')
                                <input class="form-control background-white" type="hidden" name="graduated" value="{{(request('graduated'))}}">
                            @endif

                            @if(count(request('willing_to_help')))
                                @php $willing_to_help = request('willing_to_help'); @endphp
                                @foreach($willing_to_help as $whelp)
                                    <input class="form-control background-white" type="hidden" name="willing_to_help[]" value="{{$whelp}}">
                                @endforeach
                            @endif

                            @php $searchSessions = request('session_id', []); @endphp
                            @if(count($searchSessions))
                                @foreach($searchSessions as $session)
                                    <input class="form-control background-white" type="hidden" name="session_id[]" value="{{$session}}">
                                @endforeach
                            @endif
                        @endhasrole

                        <div class="input-group">
                            <input class="form-control background-white" type="text" name="q" placeholder="Search by Name, Company, Keyword etc." value="@if(request('q')){{(request('q'))}}@endif">

                            <span class="input-group-btn">
                              <button class="btn btn-primary" type="submit">Find</button>
                            </span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <section class="font-1 py-4">
        <div class="container">
            <div class="row" id="app">
                <div class="col-12 col-lg-8 col-xl-9">
                    @include('common.notifications')

                    @hasanyrole('alumni|student')
                        <div class="background-oxford color-white p-3 mb-3">
                            @if((count(request('session_id')) || (request('affiliation')) || (request('graduated')) || (request('location')) || (request('work')) || count(request('willing_to_help')) || (request('q')) ) )
                                <strong> Showing result for </strong> :

                                @if (!empty(request('q')))
                                    <span class="badge badge-info"> Searched for {{ (request('q')) }}</span>
                                @endif

                                <span class="badge badge-info">
                                    Affiliation
                                    @if(!empty(request('affiliation')))
                                        {{ (request('affiliation')) }}
                                    @else
                                        {{"All"}}
                                    @endif
                                </span>

                                @if (!empty(request('location')))
                                    <span class="badge badge-info">
                                        Location {{(request('location'))}}
                                    </span>
                                @endif

                                @if (!empty(request('graduated')))
                                    <span class="badge badge-info">
                                        Session {{(request('graduated'))}}
                                    </span>
                                @endif

                                @if (!empty(request('work')))
                                    <span class="badge badge-info">
                                        Works at {{(request('work'))}}
                                    </span>
                                @endif

                                <?php
                                    if (request('willing_to_help') && count(request('willing_to_help'))) {
                                        echo "<span class=\"badge badge-info\"> Willing to help as";
                                        $willing_to_help = request('willing_to_help');
                                        foreach ($willing_to_help as $whelp) {
                                            $help = str_replace("_", " ", $whelp);
                                            echo $help . ',';
                                        }
                                        echo "</span>";
                                    }

                                    if (request('session_id') && count(request('session_id'))) {
                                        echo "<span class=\"badge badge-info\"> Batches";
                                        $session_id = request('session_id');
                                        $sessionData = [];
                                        foreach ($session_id as $sId) {
                                            $sessionData[] = $sId;
                                        }
                                        foreach ($sessions as $session) {
                                            if (in_array($session->id, $sessionData)) {
                                                echo $session->name . ' , ';
                                            }
                                        }
                                        if (in_array('all', $sessionData)) {
                                            echo 'All';
                                        }
                                        echo " </span>";
                                    }
                                ?>
                            @else
                                <p class="mb-0">
                                    Showing {{($alumni->currentpage()-1)*$alumni->perpage()+1}} to {{$alumni->currentpage()*$alumni->perpage()}}
                                    of <span class="badge badge-primary ml-1"> {{$alumni->total()}} </span> entries
                                </p>
                            @endif
                        </div>

                        @foreach($alumni as $alumnus)
                            <div class="row text-left">
                                <div class="col-8 col-md-3">
                                    <a href="{{route('alumni-directory.show',['id'=>$alumnus->id])}}" target="_blank">
                                        <img class="img-thumbnail radius-primary" src="{{$alumnus->profile->profile_picture}}" width="120">
                                    </a>
                                </div>
                                <div class="col mt-3 mt-md-0">
                                    <h5 class="mb-2 mt-2">
                                        <a class="color-1" href="{{route('alumni-directory.show',['id'=>$alumnus->id])}}" target="_blank">
                                            {{$alumnus->first_name.' '.$alumnus->last_name}}
                                        </a>
                                    </h5>
                                    <p class="color-4">{{$alumnus->profile->session->name or 'N/A'}}</p>
                                    <p class="color-5">{{$alumnus->profile->position or 'N/A'}}</p>

                                    @if($alumnus->userMetas->count()>0)
                                        <p class="color-2">
                                            <span class="fa fa-graduation-cap text-warning">
                                                <a style="cursor:pointer" class="whelp" data-toggle="popover" title="Willing to help">
                                                    Willing to help
                                                </a>
                                            </span>
                                        </p>

                                        <div id="popover_content_wrapper_alumni" style="display: none">
                                            @foreach($alumnus->userMetas as $userMeta)
                                                <div>
                                                    <ul>
                                                        @foreach($userMetas as $key=>$val)
                                                            @if($userMeta->value==$key)
                                                                <li>{{$val}}</li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif
                                </div>
                            </div>

                            <hr class="color-9 mb-4">
                        @endforeach
                        {{$alumni->appends(request()->input())->links()}}
                    @endhasrole

                    @if (Auth::user()->hasAnyRole('super-admin|admin|editor|faculty-stuff'))
                        <div class="background-oxford color-white p-3 mb-3">
                            @if((count(request('session_id')) || (request('affiliation')) || (request('graduated')) || (request('location')) || (request('work')) || count(request('willing_to_help')) || (request('q')) ) )
                                <strong> Showing result for </strong> :

                                @if (!empty(request('q')))
                                    <span class="badge badge-info">Searched for {{(request('q'))}}</span>
                                @endif

                                <span class="badge badge-info">Affiliation
                                    @if (!empty(request('affiliation')))
                                        {{(request('affiliation'))}}
                                    @else
                                        {{"All"}}
                                    @endif
                                </span>

                                @if (!empty(request('location')))
                                    <span class="badge badge-info">
                                        Location {{(request('location'))}}
                                    </span>
                                @endif

                                @if (!empty(request('graduated')))
                                    <span class="badge badge-info">
                                        Session {{(request('graduated'))}}
                                    </span>
                                @endif

                                @if (!empty(request('work')))
                                    <span class="badge badge-info">Works at {{(request('work'))}}</span>
                                @endif

                                <?php
                                    if (request('willing_to_help') && count(request('willing_to_help'))) {
                                        echo "<span class=\"badge badge-info\"> Willing to help as  	 ";
                                        $willing_to_help = request('willing_to_help');
                                        foreach ($willing_to_help as $whelp) {
                                            $help = str_replace("_", " ", $whelp);
                                            echo $help . ' , ';
                                        }
                                        echo "</span>";
                                    }

                                    if (request('session_id') && count(request('session_id'))) {
                                        echo "<span class=\"badge badge-info\"> Batches 	 ";
                                        $session_id = request('session_id');
                                        $sessionData = [];
                                        foreach ($session_id as $sId) {
                                            $sessionData[] = $sId;
                                        }
                                        foreach ($sessions as $session) {
                                            if (in_array($session->id, $sessionData)) {
                                                echo $session->name . ' , ';
                                            }
                                        }
                                        if (in_array('all', $sessionData)) {
                                            echo 'All';
                                        }
                                        echo " </span>";
                                    }
                                ?>
                            @else
                                <p class="mb-0">
                                    Showing {{($allAlumni->currentpage()-1)*$allAlumni->perpage()+1}} to {{$allAlumni->currentpage()*$allAlumni->perpage()}}
                                    of <span class="badge badge-primary ml-1"> {{$allAlumni->total()}} </span> entries
                                </p>
                            @endif
                        </div>

                        <div class="col-lg-12 px-0 py-0">
                            <form class="background-11 py-2 px-2 mb-3" ref="form" action="{{route('alumni-directory')}}" method="get">
                                @if(request('affiliation') && request('affiliation')!='')
                                    <input class="form-control background-white" type="hidden" name="affiliation" value="{{(request('affiliation'))}}">
                                @endif

                                @if(request('graduated') && request('graduated')!='')
                                    <input class="form-control background-white" type="hidden" name="graduated" value="{{(request('graduated'))}}">
                                @endif

                                @if(count(request('willing_to_help')))
                                    @php $willing_to_help = request('willing_to_help'); @endphp
                                    @foreach($willing_to_help as $whelp)
                                        <input class="form-control background-white" type="hidden" name="willing_to_help[]" value="{{$whelp}}">
                                    @endforeach
                                @endif

                                <div class="row">
                                    <div class="col-12 col-xl-5 py-2 text-center text-xl-left align-self-center">
                                        <div class="form-group mb-0">
                                            <div class="form-check form-check-inline ml-0 ml-xl-2">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" id="inlineRadio1" type="radio" name="status" value="all" @change="statusUpdate" v-model="selectedStatus"> All
                                                </label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" id="inlineRadio1" type="radio" name="status" value="pending" @change="statusUpdate" v-model="selectedStatus"> Pending
                                                </label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" id="inlineRadio2" type="radio" name="status" value="approved" @change="statusUpdate" @if(request('status')=='approved') checked @endif> Approved
                                                </label>
                                            </div>

                                            <div class="form-check form-check-inline">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" id="inlineRadio3" type="radio" name="status" value="deleted" @change="statusUpdate" @if(request('status')=='deleted')checked @endif> Deleted
                                                </label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 col-xl-7 py-2 text-center text-xl-right align-self-center">
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label d-inline"> Select All
                                                <input class="mx-2 form-check-input" id="checkAll" type="checkbox" @click="selectAll" v-model="allSelected">
                                            </label>
                                        </div>

                                        <select class="ui dropdown" v-model="approval">
                                            <option value="">Action</option>
                                            <option value="approve">Approve</option>
                                            <option value="disapprove">Disapprove</option>
                                            <option value="delete">Delete</option>
                                        </select>

                                        <button class="btn btn-primary" type="button" @click="batchAction" style="padding: 0.8rem 1.5rem;">Go</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        @if(!count($allAlumni)&& request('status') == 'pending')
                            <div class="background-11 p-3 mb-2">
                                <div class="row">
                                    <div class="col">
                                        <div class="alert alert-info text-left mb-4">
                                            <button class="close" type="button" data-dismiss="alert">
                                                <span>×</span>
                                            </button>

                                            <div>No one is pending here !</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            @foreach($allAlumni as $allAlumnus)
                                <div class="background-11 p-3 mb-2">
                                    <div class="row">
                                        <div class="col-4 col-sm-3 col-md-2">
                                            <img class="img-thumbnail radius-primary" src="{{$allAlumnus->profile->profile_picture}}" width="100%">
                                            <label class="form-check-label py-3">
                                                <input class="form-check-input" id="checkSingle" @click="select" type="checkbox" v-model="userIds" value="{{$allAlumnus->id}}"> Select
                                            </label>
                                        </div>

                                        <div class="col">
                                            <div class="fs-1 mb-3">
                                                <a href="{{route('alumni-directory.show',['id'=>$allAlumnus->id])}}" target="_blank">
                                                    {{$allAlumnus->first_name.' '.$allAlumnus->last_name}}
                                                </a>
                                            </div>
                                            <p>{{$allAlumnus->profile->session->name or 'N/A'}}</p>
                                            <p>{{$allAlumnus->profile->position or 'N/A'}}</p>

                                            @if($allAlumnus->userMetas->count()>0)
                                                <p class="color-2">
                                                    <span class="fa fa-graduation-cap text-warning">
                                                        <a style="cursor:pointer" class="whelp" data-toggle="popover" title="Willing to help">
                                                            Willing to help
                                                        </a>
                                                    </span>
                                                </p>

                                                <div id="popover_content_wrapper_admin" style="display: none">
                                                    @foreach($allAlumnus->userMetas as $userMeta)
                                                        <div>
                                                            <ul>
                                                                @foreach($userMetas as $key=>$val)
                                                                    @if($userMeta->value==$key)
                                                                        <li>{{$val}}</li>
                                                                    @endif
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>

                                        <div class="col-12 col-sm-4 col-md-3 col-xl-2 text-center text-lg-right">
                                            <div class="p-3 p-lg-0">
                                                @if(!$allAlumnus->is_approved==1)
                                                    <a class="btn mb-2 btn-outline-success btn-xs btn-block" href="{{route('alumni-directory.approve',['id'=>$allAlumnus->id])}}" onclick="return chkConfirm();">
                                                        <span class="fa fa-check-circle"></span> Approve
                                                    </a>
                                                @endif

                                                <a class="btn mb-2 btn-outline-danger btn-xs btn-block" href="{{route('alumni-directory.destroy',['id'=>$allAlumnus->id])}}" onclick="return chkDelete();">
                                                    <span class="fa fa-times-circle"></span> Delete
                                                </a>

                                                <a class="btn mb-2 btn-outline-warning btn-xs btn-block" href="{{route('alumni-directory.edit',['id'=>$allAlumnus->id])}}">
                                                    <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            {{$allAlumni->appends(request()->input())->links()}}
                        @endif
                    @endif
                </div>

                <div class="col-12 col-lg-4 col-xl-3 px-0 py-0 mt-3 mt-lg-0">
                    <div class="background-oxford color-white p-3">
                        <p class="mb-0">Refine your search</p>
                    </div>
                    <form class="background-11 py-3 px-3" id="refineSearch" action="{{route('alumni-directory')}}" method="get">

                        @if(request('q') && request('q')!='')

                            <input class="form-control background-white"
                                   type="hidden"
                                   name="q"
                                   value="{{(request('q'))}}">

                        @endif

                        <input class="form-control background-white"
                               type="hidden"
                               name="status"
                               value="approved">


                        @if(request('graduated') && request('graduated')!='')

                            <input class="form-control background-white"
                                   type="hidden" name="graduated"
                                   value="{{(request('graduated'))}}">

                        @endif

                        <div class="form-group">

                            <select class="ui dropdown w-100 mt-3" name="affiliation">
                                <option value="">Select</option>
                                <option value="all" @if(request('affiliation')=='all')selected @endif>All</option>
                                <option value="alumni" @if(request('affiliation')=='alumni')selected @endif>Alumni</option>
                                <option value="faculty-stuff"
                                        @if(request('affiliation')=='faculty-stuff')
                                        selected @endif>Teacher/Staff
                                </option>
                                <option value="student" @if(request('affiliation')=='student')selected @endif>Students</option>
                            </select>

                            <div class="ui styled fluid accordion mt-3">

                                <div class="title  @if(count(request('session_id'))) {{'active'}} @endif"><i class="dropdown icon"></i> Session</div>

                                <div class="content @if(count(request('session_id'))) {{'active'}} @endif" style="height: 300px;overflow: scroll">

                                    <div class="col-12 zinput zcheckbox"><input id="all" name="session_id[]"

                                                                                value="all" type="checkbox" @if((request('session_id')) && (in_array('all',request('session_id'))) ) checked @endif>
                                        <label for="all">All</label>
                                        <svg viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M16.7,62.2c4.3,5.7,21.8,27.9,21.8,27.9L87,16"
                                                  style="stroke-dasharray: 123.968, 123.968; stroke-dashoffset: 0; transition: stroke-dashoffset 0.2s ease-in-out 0s;"></path>
                                            <path d="M16.7,62.2c4.3,5.7,21.8,27.9,21.8,27.9L87,16"
                                                  style="stroke-dasharray: 123.968, 123.968; stroke-dashoffset: 0; transition: stroke-dashoffset 0.2s ease-in-out 0s;"></path>
                                        </svg>
                                        <svg viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"></svg>
                                    </div>
                                    @foreach($sessions as $session)

                                        <div class="col-12 zinput zcheckbox">
                                            <input id="{{$session->name}}" name="session_id[]"
                                                   @if((request('session_id')) && (in_array($session->id,request('session_id'))) ) checked @endif
                                                   value="{{$session->id}}" type="checkbox">
                                            <label for="{{$session->name}}">{{$session->name}}</label>
                                            <svg viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M16.7,62.2c4.3,5.7,21.8,27.9,21.8,27.9L87,16"
                                                      style="stroke-dasharray: 123.968, 123.968; stroke-dashoffset: 0; transition: stroke-dashoffset 0.2s ease-in-out 0s;"></path>
                                                <path d="M16.7,62.2c4.3,5.7,21.8,27.9,21.8,27.9L87,16"
                                                      style="stroke-dasharray: 123.968, 123.968; stroke-dashoffset: 0; transition: stroke-dashoffset 0.2s ease-in-out 0s;"></path>
                                            </svg>
                                            <svg viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"></svg>
                                        </div>
                                    @endforeach
                                </div>


                                <div class="title  @if(count(request('willing_to_help'))) {{'active'}} @endif"><i class="dropdown icon"></i> Willing to help</div>
                                <div class="content  @if(count(request('willing_to_help'))) {{'active'}} @endif">

                                    <div class="col-12 zinput zcheckbox">
                                        <input id="cb6" name="willing_to_help[]"
                                               @if((request('willing_to_help')) && (in_array('introduce_other_my_connections',request('willing_to_help'))) ) checked @endif
                                               value="introduce_other_my_connections" type="checkbox">
                                        <label for="cb6">Willing to introduce others to my connections</label>
                                        <svg viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M16.7,62.2c4.3,5.7,21.8,27.9,21.8,27.9L87,16"
                                                  style="stroke-dasharray: 123.968, 123.968; stroke-dashoffset: 0; transition: stroke-dashoffset 0.2s ease-in-out 0s;"></path>
                                            <path d="M16.7,62.2c4.3,5.7,21.8,27.9,21.8,27.9L87,16"
                                                  style="stroke-dasharray: 123.968, 123.968; stroke-dashoffset: 0; transition: stroke-dashoffset 0.2s ease-in-out 0s;"></path>
                                        </svg>
                                        <svg viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"></svg>
                                    </div>

                                    <div class="col-12 zinput zcheckbox">
                                        <input id="cb7" name="willing_to_help[]" @if (request('willing_to_help')) @if (in_array('open_my_workplace',request('willing_to_help'))) checked @endif @endif
                                        value="open_my_workplace" type="checkbox">
                                        <label for="cb7">Willing to open doors at my workplace</label>
                                        <svg viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M16.7,62.2c4.3,5.7,21.8,27.9,21.8,27.9L87,16"
                                                  style="stroke-dasharray: 123.968, 123.968; stroke-dashoffset: 0; transition: stroke-dashoffset 0.2s ease-in-out 0s;"></path>
                                        </svg>
                                        <svg viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"></svg>
                                    </div>

                                    <div class="col-12 zinput zcheckbox">
                                        <input id="cb8" name="willing_to_help[]"
                                               @if (request('willing_to_help')) @if (in_array('ans_industry_specific_questions',request('willing_to_help'))) checked @endif @endif
                                               value="ans_industry_specific_questions" type="checkbox">
                                        <label for="cb8">Willing to answer industry specific questions</label>
                                        <svg viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M16.7,62.2c4.3,5.7,21.8,27.9,21.8,27.9L87,16"
                                                  style="stroke-dasharray: 123.968, 123.968; stroke-dashoffset: 0; transition: stroke-dashoffset 0.2s ease-in-out 0s;"></path>
                                            <path d="M16.7,62.2c4.3,5.7,21.8,27.9,21.8,27.9L87,16"
                                                  style="stroke-dasharray: 123.968, 123.968; stroke-dashoffset: 0; transition: stroke-dashoffset 0.2s ease-in-out 0s;"></path>
                                        </svg>
                                        <svg viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"></svg>
                                    </div>

                                    <div class="col-12 zinput zcheckbox">
                                        <input id="cb9" name="willing_to_help[]"
                                               @if (request('willing_to_help')) @if (in_array('willing_to_be_mentor',request('willing_to_help'))) checked @endif @endif
                                               value="willing_to_be_mentor" type="checkbox" v-model="checked">
                                        <label for="cb9">Willing to be a mentor</label>
                                        <svg v-if="checked" viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M16.7,62.2c4.3,5.7,21.8,27.9,21.8,27.9L87,16"
                                                  style="stroke-dasharray: 123.968, 123.968; stroke-dashoffset: 0; transition: stroke-dashoffset 0.2s ease-in-out 0s;"></path>
                                            <path d="M16.7,62.2c4.3,5.7,21.8,27.9,21.8,27.9L87,16"
                                                  style="stroke-dasharray: 123.968, 123.968; stroke-dashoffset: 0; transition: stroke-dashoffset 0.2s ease-in-out 0s;"></path>
                                        </svg>
                                        <svg v-if="checked" viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"></svg>
                                    </div>

                                    <div class="col-10 ml-auto" v-if="checked">

                                        <div class="row">
                                            <small>Please select the topics:</small>

                                            @foreach($mentorshipTopics as $mentorshipTopic)
                                                <div class="col-12 zinput zcheckbox">
                                                    <input id="{{$mentorshipTopic->id}}" name="mentorship_topic[]" type="checkbox" value="{{$mentorshipTopic->id}}">
                                                    <label for="{{$mentorshipTopic->id}}">{{$mentorshipTopic->title}}</label>
                                                    <svg viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M16.7,62.2c4.3,5.7,21.8,27.9,21.8,27.9L87,16"
                                                              style="stroke-dasharray: 123.968, 123.968; stroke-dashoffset: 0; transition: stroke-dashoffset 0.2s ease-in-out 0s;"></path>
                                                        <path d="M16.7,62.2c4.3,5.7,21.8,27.9,21.8,27.9L87,16"
                                                              style="stroke-dasharray: 123.968, 123.968; stroke-dashoffset: 0; transition: stroke-dashoffset 0.2s ease-in-out 0s;"></path>
                                                    </svg>
                                                    <svg viewbox="0 0 100 100" xmlns="http://www.w3.org/2000/svg"></svg>
                                                </div>
                                            @endforeach

                                        </div>
                                    </div>

                                </div>

                                <div class="title  @if(request('location')) {{'active'}} @endif"><i class="dropdown icon"></i> Location</div>

                                <div class="content  @if(request('location')) {{'active'}} @endif">
                                    <input class="form-control background-white"
                                           type="text" name="location"
                                           placeholder="Search by location"
                                           value="@if(request('location')){{(request('location'))}}@endif">
                                </div>

                                <div class="title  @if(request('work')) {{'active'}} @endif"><i class="dropdown icon"></i> Work</div>
                                <div class="content @if(request('work')) {{'active'}} @endif">
                                    <input class="form-control background-white"
                                           type="text" name="work"
                                           placeholder="Search by Work"
                                           value="@if(request('work')){{(request('work'))}}@endif">
                                </div>
                            </div>
                        </div>
                        <div class="text-center">
                            <button class="btn btn-sm btn-outline-primary hv-cursor-pointer" type="submit">Search</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

@endsection

@section('styles')
    <link href="{{asset('lib/semantic-ui-accordion/accordion.css')}}" rel="stylesheet">
    <link href="{{asset('lib/semantic-ui-dropdown/dropdown.css')}}" rel="stylesheet">
    <link href="{{asset('lib/semantic-ui-transition/transition.css')}}" rel="stylesheet">
@endsection

@section('scripts')
    <script>
        $('.whelp').popover({html: true});
        $(document).ready(function () {
            $('.whelp').popover({
                html: true,
                content: function () {
                    return $('#popover_content_wrapper_alumni,#popover_content_wrapper_admin').html();
                }
            });
        });
    </script>
    <script src="https://unpkg.com/vue@2.5.9/dist/vue.js"></script>

    <script>

        let app = new Vue({
            el: '#app',
            data: {
                selected: [],
                checked: false,
                allSelected: false,
                userIds: [],
                allUserIds:{{$allAlumni->pluck('id')}},
                approval: '',
                selectedStatus: '<?php if (request('status') == 'pending') {
                    echo 'pending';
                } elseif (request('status') == 'approved') {
                    echo 'approved';
                } elseif (request('status') == 'deleted') {
                    echo 'deleted';
                } elseif (request('status') == 'all') {
                    echo 'all';
                } else {
                    echo 'all';
                }
                    ?>'
                ,
                affiliation: '',
            },
            methods: {
                selectAll: function (e) {

                    this.userIds = [];
                    if (e.target.checked) {
                        this.userIds = this.allUserIds;
                    }
                    else {
                        this.userIds = [];
                    }
                },
                select: function () {
                    this.allSelected = false;
                },
                batchAction: function () {

                    let ids = this.userIds;
                    let action = this.approval;
                    let test = this.test;

                    window.location = "{{route('alumni-directory.batchAction')}}?action=" + action + "&ids=" + ids.join();
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
            return confirm('Are you sure you want to delete this user ?');
        }

        function chkConfirm() {
            return confirm('Are you sure you want to approve this user ?');
        }
    </script>

    <script src="{{asset('lib/semantic-ui-accordion/accordion.js')}}"></script>
    <script src="{{asset('lib/semantic-ui-dropdown/dropdown.js')}}"></script>
    <script src="{{asset('lib/semantic-ui-transition/transition.js')}}"></script>

    <script>
        jQuery(document).ready(function ($) {

            // Remove empty fields from GET forms
            // Author: Bill Erickson
            // URL: http://www.billerickson.net/code/hide-empty-fields-get-form/

            // Change 'form' to class or ID of your specific form
            $("#refineSearch").submit(function () {
                $(this).find(":input").filter(function () {
                    return !this.value;
                }).attr("disabled", "disabled");
                return true; // ensure form still submits
            });

            // Un-disable form fields when page loads, in case they click back after submission
            $("#refineSearch").find(":input").prop("disabled", false);

        });
    </script>

@endsection