@extends('layouts.master-auth')

@section('title', 'Job | Add')

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

                    <div class="mb-3">
                        <h5 class="mb-2">Post a Job</h5>
                    </div>
                    <div class="background-10 p-4">
                        <form method="post" action="{{route('jobs.store')}}" enctype="multipart/form-data" files="true">
                            {{csrf_field()}}

                        <input type="hidden" name="department_id"  value="{{$department->id}}"> 
                        <input type="hidden" name="institution_id"  value="{{$institution->id}}">

                        @if (Auth::user()->hasAnyRole('alumni|student'))

                         
                                <div class="form-group row">
                                    <label for="session_id" class="col-sm-2 col-form-label col-form-label-sm">Session:</label>
                                <div class="col-md-5">
                                    <select class="form-control hv-cursor-pointer" name="session_id">
                                        <option disabled selected>Select Session</option>
                                            <option value="all">
                                                All
                                            </option>
                                            
                                            <option value="{{Auth::user()->profile->session_id}}">
                                               {{Auth::user()->profile->session->name}}
                                            </option>
                                            
                                    </select>
                                </div>
                            </div>
                        
                        @elseif(Auth::user()->hasAnyRole('super-admin|admin'))

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
                        @endif
                            <div class="form-group  row">
                                <label for="job_title" class="col-sm-2 col-form-label col-form-label-sm">Job Title: <span class="req-red">*</span></label>
                                <div class="col-md-10">
                                    <div class="form-group  @if ($errors->has('job_title')) has-danger @endif ">
                                        <input class="form-control"
                                               id="job_title"
                                               type="text"
                                               name="job_title"
                                               value="{{old('job_title')}}">
                                        @if ($errors->has('job_title'))
                                            <div class="form-control-feedback">{{ $errors->first('job_title') }}</div>
                                        @endif
                                    </div>

                                </div>
                            </div>

                            <div class="form-group  row">
                                <label for="company_name" class="col-sm-2 col-form-label col-form-label-sm">Company Name: <span class="req-red">*</span></label>
                                <div class="col-md-10">
                                    <div class="form-group @if ($errors->has('company_name')) has-danger @endif">
                                        <input class="form-control"
                                               id="company_name"
                                               type="text"
                                               name="company_name"
                                               value="{{old('company_name')}}">
                                        @if ($errors->has('company_name'))
                                            <div class="form-control-feedback">{{ $errors->first('company_name') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group  row">
                                <label for="vacancy" class="col-sm-2 col-form-label col-form-label-sm">Vacancy:</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input class="form-control"
                                               id="url"
                                               type="text"
                                               name="vacancy"
                                               value="{{old('vacancy')}}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group  row">
                                <label for="description" class="col-md-2 col-form-label col-form-label-sm">Job Description / Responsibility: <span class="req-red">*</span></label></label>
                                <div class="col-md-10">
                                    <div class="form-group  @if ($errors->has('description')) has-danger @endif">
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

                            <div class="form-group  row  ">
                                <label for="job_type" class="col-sm-2 col-form-label col-form-label-sm">Job Nature: <span class="req-red">*</span></label>
                                <div class="col-md-10 @if ($errors->has('job_type')) has-danger @endif">
                                    <select class="form-control" name="job_type">
                                        <option value="" disabled="disabled" selected>- - Select Job Nature - -</option>
                                        @foreach(['Internship','Full-time','Part-time','Remote','Contract','Hourly'] as $jobType )
                                            <option value="{{$jobType}}">{{$jobType}}</option>
                                        @endforeach
                                        <span class="req-red">*</span>
                                    </select>
                                    @if ($errors->has('job_type'))
                                        <div class="form-control-feedback">{{ $errors->first('job_type') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group  row">
                                <label for="educational_requirements" class="col-md-2 col-form-label col-form-label-sm">Educational Requirements: <span class="req-red">*</span></label></label>
                                <div class="col-md-10">
                                    <div class="form-group   @if ($errors->has('educational_requirements')) has-danger @endif">
                                    <textarea class="form-control editableTextArea"
                                              name="educational_requirements"
                                              id="educational_requirements"
                                              rows="4">{{old('educational_requirements') }}</textarea>
                                        @if ($errors->has('educational_requirements'))
                                            <div class="form-control-feedback">{{ $errors->first('educational_requirements') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group  row">
                                <label for="job_requirements" class="col-md-2 col-form-label col-form-label-sm">Job Requirements: <span class="req-red">*</span></label></label>
                                <div class="col-md-10">
                                    <div class="form-group  @if ($errors->has('job_requirements')) has-danger @endif">
                                    <textarea class="form-control editableTextArea"
                                              name="job_requirements"
                                              id="job_requirements"
                                              rows="4">{{old('job_requirements') }}</textarea>
                                        @if ($errors->has('job_requirements'))
                                            <div class="form-control-feedback">{{ $errors->first('job_requirements') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group  row">
                                <label for="location" class="col-sm-2 col-form-label col-form-label-sm">Location: <span class="req-red">*</span></label>
                                <div class="col-md-10">
                                    <div class="form-group @if ($errors->has('company_name')) has-danger @endif">
                                        <input class="form-control"
                                               id="location"
                                               type="text"
                                               name="location"
                                               value="{{old('location')}}">
                                        @if ($errors->has('location'))
                                            <div class="form-control-feedback">{{ $errors->first('location') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group  row">
                                <label for="salary_range" class="col-sm-2 col-form-label col-form-label-sm">Salary Range: <span class="req-red">*</span></label>
                                <div class="col-md-10">
                                    <div class="form-group @if ($errors->has('salary_range')) has-danger @endif">
                                        <input class="form-control"
                                               id="salary_range"
                                               type="text"
                                               name="salary_range"
                                               value="{{old('salary_range')}}">
                                        @if ($errors->has('salary_range'))
                                            <div class="form-control-feedback">{{ $errors->first('salary_range') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group  row">
                                <label for="url" class="col-sm-2 col-form-label col-form-label-sm">Company Website:</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input class="form-control"
                                               id="url"
                                               type="text"
                                               name="url"
                                               value="{{old('url')}}">
                                    </div>
                                </div>
                            </div>


                            <div class="form-group  row">
                                <label for="other_benefits" class="col-md-2 col-form-label col-form-label-sm">Other Benefits: </label></label>
                                <div class="col-md-10">
                                    <div class="form-group ">
                                    <textarea class="form-control editableTextArea"
                                              name="other_benefits"
                                              id="other_benefits"
                                              rows="4">{{old('other_benefits') }}</textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group  row">
                                <label for="post_date" class="col-sm-2 col-form-label col-form-label-sm">Post Date: <span class="req-red">*</span></label>
                                <div class="col-md-10">
                                    <div class="form-group @if ($errors->has('post_date')) has-danger @endif">
                                        <input class="form-control"
                                               id="post_date"
                                               type="text"
                                               name="post_date"
                                               value="{{old('post_date')}}">

                                        @if ($errors->has('post_date'))
                                            <div class="form-control-feedback">{{ $errors->first('post_date') }}</div>
                                        @endif
                                    </div>

                                </div>
                            </div>

                            <div class="form-group  row">
                                <label for="end_date" class="col-sm-2 col-form-label col-form-label-sm">End Date: <span class="req-red">*</span></label>
                                <div class="col-md-10">
                                    <div class="form-group  @if ($errors->has('end_date')) has-danger @endif">
                                        <input class="form-control"
                                               id="end_date"
                                               type="text"
                                               name="end_date"
                                               value="{{old('end_date')}}">
                                        @if ($errors->has('end_date'))
                                            <div class="form-control-feedback">{{ $errors->first('end_date') }}</div>
                                        @endif
                                    </div>

                                </div>
                            </div>

                            <div class="form-group  row">
                                <label for="apply_instruction" class="col-md-2 col-form-label col-form-label-sm">Apply Instruction: <span class="req-red">*</span></label></label>
                                <div class="col-md-10">
                                    <div class="form-group  @if ($errors->has('job_requirements')) has-danger @endif">
                                    <textarea class="form-control editableTextArea"
                                              name="apply_instruction"
                                              id="apply_instruction"
                                              rows="4">{{old('apply_instruction') }}</textarea>
                                        @if ($errors->has('apply_instruction'))
                                            <div class="form-control-feedback">{{ $errors->first('apply_instruction') }}</div>
                                        @endif
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
                                    <input class="inputfile" id="file-1" name="image_url" type="file" name="file-1[]" data-multiple-caption="{count} files selected" multiple="">
                                    <label class="btn btn-outline-primary btn-sm" for="file-1"><span>Upload Photo</span></label>
                                </div>

                                <div class="col-md-6 text-right pt-2">
                                    <span class="req-red small text-right">*</span>
                                    <small> Required Fields</small>
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

                @include('jobs.partials.latestJobs',array('latestJobs'=>$latestJobs))

            </div>
        </div>
        <!--/.container-->
    </section>

@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker3.min.css"/>
    <link href="{{asset('css/right-scrollbar.css')}}" rel="stylesheet">
@endsection

@section('scripts')

    <script src="{{asset('unisharp/laravel-ckeditor/ckeditor.js')}}"></script>

    <script>
        CKEDITOR.replace('description');
        CKEDITOR.replace('educational_requirements');
        CKEDITOR.replace('job_requirements');
        CKEDITOR.replace('other_benefits');
    </script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>

    <script>

        $(document).ready(function () {

            $('#post_date').datepicker({
                format: 'dd-mm-yyyy',
                todayHighlight: true
            })

            $('#end_date').datepicker({
                format: 'dd-mm-yyyy',
                todayHighlight: true
            })

        })
    </script>
@endsection

