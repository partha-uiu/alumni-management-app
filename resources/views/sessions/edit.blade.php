@extends('layouts.master-auth')

@section('title', 'Session | Edit')

@section('content')

    @include('common.nav-section')

    <section class="font-1 py-6">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-8">
                    @include('common.notifications')

                    <div class="background-oxford color-white p-2 mb-3">
                        <h5 class="mb-2">Edit Session</h5>
                    </div>

                    <form method="post" action="{{route('session.edit',['id'=>$session->id])}}">
                        {{csrf_field()}}

                        <div class="form-group  row">
                            <label for="session_name" class="col-sm-2 col-form-label col-form-label-sm">Name: <span class="req-red">*</span></label>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <input class="form-control"
                                           id="session_name"
                                           type="text"
                                           name="session_name"
                                           value="{{$session->name}}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-6 text-left pt-2">
                                <span class="req-red small text-right">*</span>
                                <small>Required Fields</small>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-5 offset-md-7 text-right mt-3">
                                <button type="submit" class="btn btn-outline-primary btn-block hv-cursor-pointer ">Save</button>
                            </div>
                        </div>

                        <div class="zform-feedback mt-3"></div>
                    </form>
                </div>
            </div>
        </div>
        <!--/.row-->
        <!--/.container-->
    </section>

@endsection