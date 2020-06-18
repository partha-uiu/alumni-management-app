@extends('layouts.master-auth')

@section('title', 'News | Add')

@section('content')

    @include('common.nav-section')

    <section class="font-1 py-4">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-12">
                    <div class="mb-3">
                        <h5 class="mb-2">Edit News</h5>
                    </div>
                    <div class="background-10 p-4">
                    @if(session('success'))
                        @include('common.notifications')
                    @endif

                    <form method="post" action="{{route('news.edit',['id'=>$news->id])}}" enctype="multipart/form-data" files="true">
                        {{csrf_field()}}

                        <div class="form-group  row">
                            <label for="heading" class="col-sm-2 col-form-label col-form-label-sm">Heading: <span class="req-red">*</span></label>
                            <div class="col-md-10">
                                <div class="form-group @if ($errors->has('heading')) has-danger @endif">
                                    <input class="form-control"
                                           id="heading"
                                           type="text"
                                           name="heading"
                                           value="{{$news->heading,old('heading')}}">
                                    @if ($errors->has('heading'))
                                        <div class="form-control-feedback">{{ $errors->first('heading') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group  row">
                            <label for="description" class="col-md-2 col-form-label col-form-label-sm"> Description:<span class="req-red">*</span></label>
                            <div class="col-md-10">
                                <div class="form-group @if ($errors->has('description')) has-danger @endif">
                                    <textarea class="form-control"
                                              name="description"
                                              id="description"
                                              rows="4">{{$news->description,old('description') }}</textarea>
                                    @if ($errors->has('description'))
                                        <div class="form-control-feedback">{{ $errors->first('description') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="form-group  row">
                            <label for="link" class="col-md-2 col-form-label col-form-label-sm"> Link:</label>
                            <div class="col-md-10">
                                <div class="form-group">
                                    <input class="form-control"
                                           name="link"
                                           id="link"
                                           value="{{$news->link,old('link') }}">
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 text-left">
                                <div class="form-group"></div>
                                <img src="@if ($news->image_url) {{asset('storage').'/'.$news->image_url}}" @endif height="150">
                                <input class="inputfile" id="file-1" name="image_url" type="file" name="file-1[]" data-multiple-caption="{count} files selected" multiple="">
                                <label class="btn btn-outline-primary btn-sm" for="file-1"><span>Upload Photo</span></label>
                            </div>
                            <div class="col-md-6 text-right pt-2">
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

                @include('news.partials.latestNews',array('latestNews'=>$latestNews))

            </div>
        </div>
        <!--/.row-->
        <!--/.container-->
    </section>

@endsection

@section('scripts')
    <script src="{{asset('unisharp/laravel-ckeditor/ckeditor.js')}}"></script>

    <script>
        CKEDITOR.replace('description');
    </script>
@endsection

@section('styles')

    <link href="{{asset('css/right-scrollbar.css')}}" rel="stylesheet">

@endsection