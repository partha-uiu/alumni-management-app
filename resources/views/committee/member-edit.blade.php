@extends('layouts.master-auth')

@section('title', 'Committee | Edit')

@section('content')

    @if (Auth::user()->hasAnyRole('super-admin|admin|editor|faculty-stuff'))
        @include('common.top-nav-admin')
    @endif

    @if (Auth::user()->hasRole('alumni'))
        @include('common.top-nav-alumni')
    @endif

    <section class="font-1 py-6">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-8">

                        @include('common.notifications')

                    <div class="background-oxford color-white p-2 mb-3">
                        <h5 class="mb-2">Edit Committee Member</h5>
                    </div>

                    <form method="post" action="{{route('committee-member.edit',['id'=>$member->id])}}"  enctype="multipart/form-data" files="true">
                        {{csrf_field()}}
                        <input type="hidden" name="committee">
                        <div class="form-group  row">
                            <label for="heading" class="col-sm-2 col-form-label col-form-label-sm">Name: <span class="req-red">*</span></label>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <input class="form-control"
                                           id="heading"
                                           type="text"
                                           name="member_name"
                                           value="{{$member->member_name}}">
                                </div>
                            </div>
                        </div>
                        <div class="form-group  row">
                            <label for="heading" class="col-sm-2 col-form-label col-form-label-sm">Title: <span class="req-red">*</span></label>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <input class="form-control"
                                           id="heading"
                                           type="text"
                                           name="member_title"
                                           value="{{$member->member_title}}">
                                </div>
                            </div>
                        </div>

                        <div class="form-group  row">
                            <label for="heading" class="col-sm-2 col-form-label col-form-label-sm">Image: <span class="req-red">*</span></label>
                            <div class="col-md-10">
                                <img class="rounded" @if($member->member_image)
                                src="{{asset('storage').'/'.$member->member_image}}"
                                     @else src="{{asset('images/sample.png')}}"
                                     @endif
                                     alt="Member" width="200" height="200">
                            </div>
                        </div>

                        <div class="col-md-12 text-left">
                            <div class="form-group"></div>
                            <input class="inputfile"
                                   id="file-1"
                                   name="member_image"
                                   type="file"
                                   data-multiple-caption="{count} files selected"
                                   multiple="">
                            <label class="btn btn-outline-primary btn-sm" for="file-1"><span>Update Member Photo</span></label>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-md-12 text-right pt-2">
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