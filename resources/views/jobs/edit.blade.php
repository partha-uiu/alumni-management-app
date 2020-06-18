@extends('layouts.master-auth')

@section('title', 'Job | Edit')

@section('content')

    @include('common.nav-section')

    <section class="font-1 py-4">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-12">
                    <div class="mb-3">
                        <h5 class="mb-2">Edit Job</h5>
                    </div>
                    <div class="background-10 p-4">

                        @if(session('success'))
                            @include('common.notifications')
                        @endif


                        <form method="post" action="{{route('jobs.edit',['id'=>$job->id])}}" enctype="multipart/form-data" files="true">
                            {{csrf_field()}}

                            <div class="form-group  row">
                                <label for="job_title" class="col-sm-2 col-form-label col-form-label-sm">Job Title: <span class="req-red">*</span></label>
                                <div class="col-md-10">
                                    <div class="form-group  @if ($errors->has('job_title')) has-danger @endif ">
                                        <input class="form-control"
                                               id="job_title"
                                               type="text"
                                               name="job_title"
                                               value="{{$job->job_title}}">
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
                                               value="{{$job->company_name}}">
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
                                               value="{{ $job->vacancy ,old('vacancy')}}">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group  row">
                                <label for="description" class="col-md-2 col-form-label col-form-label-sm">Job Description / Responsibility: <span class="req-red">*</span></label></label>
                                <div class="col-md-10">
                                    <div class="form-group  @if ($errors->has('description')) has-danger @endif">
                                    <textarea class="form-control editableTextArea"
                                              name="description"
                                              id="description"
                                              rows="4">{{$job->description}}</textarea>
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
                                            <option value="{{$jobType}}" @if ($job->job_type==$jobType) selected @endif>{{$jobType}}</option>
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
                                    <div class="form-group @if($errors->has('educational_requirements')) has-danger @endif">
                                    <textarea class="form-control editableTextArea"
                                              name="educational_requirements"
                                              id="educational_requirements"
                                              rows="4">{{$job->educational_requirements}}</textarea>
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
                                              rows="4">{{$job->job_requirements}}dfdfd</textarea>
                                        @if ($errors->has('job_requirements'))
                                            <div class="form-control-feedback">{{ $errors->first('job_requirements') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            <div class="form-group  row">
                                <label for="location" class="col-sm-2 col-form-label col-form-label-sm">Location: <span class="req-red">*</span></label>
                                <div class="col-md-10">
                                    <div class="form-group @if ($errors->has('location')) has-danger @endif">
                                        <input class="form-control"
                                               id="location"
                                               type="text"
                                               name="location"
                                               value="{{$job->location}}">
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
                                               value="{{$job->salary_range}}">
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
                                               value="{{$job->url,old('url')}}">
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
                                              rows="4">{{$job->other_benefits,old('other_benefits') }}</textarea>
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
                                               value="{{Carbon\Carbon::createFromFormat('Y-m-d', $job->post_date)->format('d-M-Y')}}">

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
                                               value="{{Carbon\Carbon::createFromFormat('Y-m-d', $job->end_date)->format('d-M-Y')}}">
                                        @if ($errors->has('end_date'))
                                            <div class="form-control-feedback">{{ $errors->first('end_date') }}</div>
                                        @endif
                                    </div>

                                </div>
                            </div>

                            <div class="form-group  row">
                                <label for="apply_instruction" class="col-md-2 col-form-label col-form-label-sm">Apply Instruction: <span class="req-red">*</span></label></label>
                                <div class="col-md-10">
                                    <div class="form-group  @if ($errors->has('apply_instruction')) has-danger @endif">
                                    <textarea class="form-control editableTextArea"
                                              name="apply_instruction"
                                              id="apply_instruction"
                                              rows="4">{{$job->apply_instruction,old('apply_instruction') }}</textarea>
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
                                    <button type="submit" class="btn btn-outline-primary btn-block hv-cursor-pointer ">Update</button>
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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
    <script src="{{asset('unisharp/laravel-ckeditor/ckeditor.js')}}"></script>

    <script>
        CKEDITOR.replace('description');
        CKEDITOR.replace('educational_requirements');
        CKEDITOR.replace('job_requirements');
        CKEDITOR.replace('other_benefits');
    </script>
    <script>

        $(document).ready(function () {

            $('#post_date').datepicker({
                format: 'dd-M-yyyy',
                todayHighlight: true
            })

            $('#end_date').datepicker({
                format: 'dd-M-yyyy',
                todayHighlight: true
            })

        })
    </script>
@endsection

