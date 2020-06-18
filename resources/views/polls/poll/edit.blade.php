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
                    <h5>Update Poll</h5>
                </div>
            </div>
        </div>
    </section>

    <section class="font-1 pt-2 pb-4">
        <div class="container">
            <div id="app">
                <div class="row pb-4">
                    <div class="col-md-10 offset-md-1">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-6">
                                        <h5 class="text-primary">{{$poll->title}}</h5><br/>
                                        @if(session('success'))
                                            @include('common.notifications')
                                        @endif 
                                    </div> 
                                    <div class="col-4">
                                       
                                    </div>    
                                    <div class="col-2 text-right">
                                        <a href="{{route('poll.home')}}" class="btn btn-outline-primary btn-sm"> <i class="fa fa-angle-left mr-2"></i>Back to list </a>
                                    </div>
                                </div>        
                            </div>
                            
                            <div class="card-block">
                                <form action="{{route('poll.update',['id'=> $poll->id])}}" method="POST">
                                    {{csrf_field()}}
                                    <div class="form-group row">
                                        <label for="max_check" class="col-3 text-primary">Please select session</label>
                                        
                                        <div class="col-6">
                                            <select class="form-control hv-cursor-pointer" name="session_id">
                                                <option disabled selected>Select Session</option>
                                                <option value="all" @if($poll->session_id=='All') selected @endif>
                                                    All
                                                </option>
                                                    
                                                @foreach($sessions as $session)
                                                    <option value="{{$session->id}}" @if($poll->session_id==$session->id) selected @endif>
                                                        {{$session->name}}
                                                    </option>
                                                @endforeach
                                                    
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group row @if ($errors->has('max_checkable')) has-danger @endif">
                                        <label for="max_check" class="col-3 text-primary">Please choose the maximum selectable option<br/><span class="text-muted small">More than 1 will be considered as checkbox</span></label>
                                        
                                        <div class="col-6">
                                            <select class="form-control hv-cursor-pointer" name ="max_checkable" id="max_check">
                                                    <option value="" disabled selected>Please select</option>
                                                @foreach([1,2,3,4,5] as $maxcheck)
                                                    <option value="{{$maxcheck}}" @if($poll->max_checkable==$maxcheck) selected @endif >{{$maxcheck}}</option>
                                                @endforeach    
                                            </select>
                                            @if ($errors->has('max_checkable'))
                                                <div class="form-control-feedback">{{ $errors->first('max_checkable') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="form-group row @if ($errors->has('title')) has-danger @endif">
                                        <label for="poll_question" class="col-3  col-form-label text-primary">Please enter the poll question </label>
                                        <div class="col-6">
                                            <input class="form-control" type="text" name="title" id="poll_question" value="{{$poll->title}}">
                                            @if ($errors->has('title'))
                                                <div class="form-control-feedback">{{ $errors->first('title') }}</div>
                                            @endif
                                        </div>
                                    </div>
                                    <div  v-for="(row,index) in rows">

                                        <div class="form-group row @if ($errors->has('option_name.*')) has-danger @endif">
                                            <label for="option" class="col-3 col-form-label text-muted text-primary" v-if="index<1">Plese enter the options </label>
                                            <label for="" class="col-3 col-form-label text-muted text-primary" v-if="index>0"></label>
                                                <div class="col-4">
                                                    <input class="form-control" type="text" name="option_name[]" id="option" v-model="row.options">
                                                    @if ($errors->has('option_name.*'))
                                                        <div class="form-control-feedback">{{ $errors->first('option_name.*') }}</div>
                                                    @endif
                                                </div>
                                                <p v-if="index>0"><i class="fa fa-plus-circle hv-cursor-pointer text-primary" @click="addRow"></i></p><br/>
                                                <p class="ml-2" v-if="index>1"><i class="fa fa-minus-circle hv-cursor-pointer text-danger" @click="removeRow(row)"></i></p>
                                            
                                        </div>
                                    </div>

                                    <div class="form-group row">
                                        <label for="end_date" class="col-3 col-form-label text-muted text-primary">End Date: </label>
                                        <div class="col-3">
                                            <input class="form-control"
                                                    id="end_date"
                                                    type="text"
                                                    name="end_date"
                                                    value="@if(isset($poll->end_date)){{ Carbon\Carbon::createFromFormat('Y-m-d', $poll->end_date)->format('d-m-Y')}} @endif">
                                                    @if ($errors->has('end_date'))
                                                        <div class="form-control-feedback">{{ $errors->first('end_date') }}</div>
                                                    @endif
                                        </div>        
                                    </div>            

                                    <div class="form-group row">
                                        <label for="option" class="col-3 col-form-label text-muted text-primary"> </label>
                                        <div class="col-4">
                                            <button type="submit" href="#" class="btn btn-outline-primary hv-cursor-pointer">Save</a>
                                        </div>
                                    </div>


                                </form>


                            </div>
                        </div>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="assets/lib/owl.carousel/dist/owl.carousel.min.js"></script>

    <script>
            let app = new Vue({
                el: '#app',
                data: {
                    rows: [],
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

            var options = @json($options->toArray());
            if (options.length) {
            for (var i = 0; i < options.length; i++) {
                var newRow = {
                    options: options[i].name,
                };
                app.rows.push(newRow);
            }
        }

        
    </script>

    <script>
        $('#end_date').datepicker({
            format: 'dd-mm-yyyy',
            startView: 2,
            todayHighlight: true
        })
    </script>

@endsection
