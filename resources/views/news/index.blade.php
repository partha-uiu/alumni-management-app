@extends('layouts.master')

@section('title', 'News')

@section('styles')

    <link href="{{asset('lib/semantic-ui-accordion/accordion.css')}}" rel="stylesheet">
    <link href="{{asset('lib/semantic-ui-dropdown/dropdown.css')}}" rel="stylesheet">
    <link href="{{asset('lib/semantic-ui-transition/transition.css')}}" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker3.min.css"/>

@endsection

@section('content')

    @include('common.nav-section')

    <hr class="color-9 my-0">
    <section class="font-1 background-10" style="padding: 1.45rem 0;">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-8">
                    <h5 class="text-center text-md-left">
                        All News

                    </h5>
                </div>
                <div class="d-none d-md-block col-md-4">

                </div>
            </div>
        </div>
    </section>



    <section class="font-1 py-4">
        <div class="container">
            <div class="row">
                <div class="col-8" id="app">
                    @include('common.notifications')

                    @if (Auth::user()->hasAnyRole('super-admin|admin|editor|faculty-stuff'))

                        <form class="background-11 py-2 px-2 mb-3" method="get">

                            <div class="form-group mb-0 text-right">

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
                                        <option value="delete">Delete</option>
                                    </select>
                                    <span class="input-group-btn d-inline pl-2">
                                        <button class="btn btn-primary btn-sm hv-cursor-pointer" type="button" @click="batchAction">Go</button>
                                    </span>
                                </div>
                            </div>
                        </form>

                    @endif
                    <div class="row mb-4">

                        @foreach($allNews as $allNewsVal)

                            <div class="col-lg-4 col-12 p-2">
                                <img class="radius-primary" style="height: 130px" @if($allNewsVal->image_url) src="{{asset('storage').'/'.$allNewsVal->image_url}}" @else src="{{asset('images/no-image-default.jpg')}}" @endif>
                                <h5 class="mt-3 mb-2 color-oxford"><a class="color-1 col-lg-3 mb-5" href="{{route('news.show',['id'=>$allNewsVal->id])}}" target="_blank">{{$allNewsVal->heading}}  </a></h5>
                                <div class="d-inline-block color-6 font-1 mb-2">
                                    {{Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $allNewsVal->created_at)->format('d M Y h:i a')}}
                                </div>

                                @if (Auth::user()->hasAnyRole('super-admin|admin|editor|faculty-stuff'))
                                    <div class="mt-3 mt-md-0 align-self-center text-center">
                                        <a href="{{route('news.destroy',['id'=>$allNewsVal->id])}}" onclick="return chkDelete();"><span class="fa fa-times-circle mx-3"></span></a>
                                        <a class="ml-3" href="{{route('news.edit',['id'=>$allNewsVal->id])}}"><i class="fa fa-pencil"></i></a>
                                        <label class="form-check-label d-inline pl-5">
                                            <input class="form-check-input" id="checkAll" @click="select" type="checkbox" v-model="newsIds" value="{{$allNewsVal->id}}">
                                        </label>
                                    </div>
                                @endif
                            </div>
                        @endforeach

                    </div>

                    {{ $allNews->appends(request()->input())->links() }}

                </div>
                <div class="col-lg-4 mt-0">
                    <div class="row">
                        <div class="col-lg-12 px-0 mb-2">
                            <div class="background-oxford color-white p-3">
                                <p class="mb-0"><i class="fa fa-search mr-2" aria-hidden="true"></i> Search News</p>
                            </div>
                            <form class="background-11 py-3 px-3" method="get" action="{{route('news')}}">
                                <div class="form-group mt-2">
                                    <input class="form-control background-white" type="text" name="q" placeholder="Search by keyword" value="@if(request('q')){{(request('q'))}}@endif">

                                    <input class="form-control background-white mt-2" type="text" id="newsDate" name="news_date" placeholder="Search by date" value="@if(request('news_date')){{(request('news_date'))}}@endif">

                                </div>
                                <div class="text-right">
                                    <button class="btn btn-xs btn-outline-primary hv-cursor-pointer" type="submit">Search</button>
                                </div>
                            </form>
                            @if (Auth::user()->hasAnyRole('super-admin|admin|editor|faculty-stuff'))
                                <div class="mx-3 mx-sm-0 mt-3">
                                    <a class="btn btn-block btn-primary" href="{{route('news.create')}}">
                                        <i class="fa fa-plus-circle mr-2"></i>Post a news
                                    </a>
                                </div>
                            @endif

                        </div>

                    </div>
                </div>
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </section>

@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>

    <script>

        $(document).ready(function () {

            $('#newsDate').datepicker({
                format: 'dd-mm-yyyy',
                todayHighlight: true,
                orientation: 'bottom'
            })

        })
    </script>

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
                newsIds: [],
                allNewsIds:{{$allNewsVal->pluck('id')}},
                approval: '',
            },
            methods: {
                selectAll: function (e) {

                    this.newsIds = [];
                    if (e.target.checked) {
                        this.newsIds = this.allNewsIds;
                    }
                    else {
                        this.newsIds = [];
                    }
                },
                select: function () {
                    this.allSelected = false;
                },
                batchAction: function () {

                    let ids = this.newsIds;
                    let action = this.approval;
                    let test = this.test;

                    window.location = "{{route('news.batch-action')}}?action=" + action + "&ids=" + ids.join();
                },

            }
        });

        function chkDelete() {
            return confirm('Are you sure you want to delete this news ?');
        }

    </script>

@endsection