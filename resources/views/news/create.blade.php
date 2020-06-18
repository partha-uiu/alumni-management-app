@extends('layouts.master-auth')

@section('title', 'News | Add')

@section('content')

    @include('common.nav-section')
    
    <hr class="color-9 my-0">

    <section class="font-1 py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-12">
                    @if(session('success'))
                        @include('common.notifications')
                    @endif

                    <h5 class="mb-3">Create New News</h5>
                    <div class="background-10 p-4">
                        <form method="post" action="{{route('news.store')}}" enctype="multipart/form-data" files="true">
                            {{csrf_field()}}

                            
                        <input type="hidden" name="department_id"  value="{{$department->id}}"> 
                        <input type="hidden" name="institution_id"  value="{{$institution->id}}">
                             <div class="form-group row">
                            <label for="session_id" class="col-sm-2 col-form-label col-form-label-sm">Session:</label>
                                <div class="col-md-5">
                                    <select class="form-control hv-cursor-pointer" name="session_id">
                                        <option disabled selected>Select Session</option>
                                        @foreach($sessions as $session)
                                            <option value="{{$session->id}}">
                                                {{$session->name}}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                          </div>

                            <div class="form-group row">
                                <label for="heading" class="col-sm-2 col-form-label col-form-label-sm">Heading: <span class="req-red">*</span></label>
                                <div class="col-md-10">
                                    <div class="form-group @if ($errors->has('heading')) has-danger @endif">
                                        <input class="form-control"
                                               id="heading"
                                               type="text"
                                               name="heading"
                                               value="{{old('heading')}}">
                                        @if ($errors->has('heading'))
                                            <div class="form-control-feedback">{{ $errors->first('heading') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="description" class="col-md-2 col-form-label col-form-label-sm"> Description:<span class="req-red">*</span></label>
                                <div class="col-md-10">
                                    <div class="form-group @if ($errors->has('description')) has-danger @endif">
                                    <textarea class="form-control"
                                              name="description"
                                              id="description"
                                              rows="4">{{old('description') }}</textarea>
                                        @if ($errors->has('description'))
                                            <div class="form-control-feedback">{{ $errors->first('description') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label for="link" class="col-md-2 col-form-label col-form-label-sm"> Link:</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input class="form-control"
                                               name="link"
                                               id="link"
                                               value="{{old('link') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6 col-md-3 offset-md-2">
                                    <input class="inputfile" id="file-1" name="image_url" type="file" name="file-1[]" data-multiple-caption="{count} files selected" multiple="">
                                    <label class="btn btn-outline-primary btn-sm" for="file-1"><span>Upload Photo</span></label>
                                </div>
                                <div class="col-6 col-md-7 text-right">
                                    <span class="req-red small text-right">*</span>
                                    <small>Required Fields</small>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12 col-md-3 offset-md-2 my-5">
                                    <button type="submit" class="btn btn-primary btn-block hv-cursor-pointer ">Save</button>
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