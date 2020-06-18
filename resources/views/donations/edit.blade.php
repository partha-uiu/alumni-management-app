@extends('layouts.master-auth')

@section('title', 'Donation | Edit')

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker3.min.css"/>
    <link href="{{asset('css/right-scrollbar.css')}}" rel="stylesheet">
@endsection

@section('content')
    @if (Auth::user()->hasRole('alumni')&& Auth::user()->is_approved==0)
        @include('common.not-approved')
    @endif

    @include('common.nav-section')
    <hr class="color-9 my-0">
    <section class="font-1 py-4">

        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-12">
                    <div class="mb-3">
                        <h5 class="mb-2">Edit Doantion</h5>
                    </div>
                    <div class="background-10 p-4">
                        @if(session('success'))
                            @include('common.notifications')
                        @endif

                        <form method="post" action="{{route('donations.edit',['id'=>$donation->id])}}" enctype="multipart/form-data" files="true">
                            {{csrf_field()}}

                            <div class="form-group  row">
                                <label for="job_title" class="col-sm-2 col-form-label col-form-label-sm">Heading: <span class="req-red">*</span></label>
                                <div class="col-md-10">
                                    <div class="form-group  @if ($errors->has('title')) has-danger @endif">
                                        <input class="form-control"
                                               id="donation_title"
                                               type="text"
                                               name="title"
                                               value="{{$donation->title,('title')}}">
                                        @if ($errors->has('title'))
                                            <div class="form-control-feedback">{{ $errors->first('title') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group  row">
                                <label for="description" class="col-md-2 col-form-label col-form-label-sm"> Description:<span class="req-red">*</span></label>
                                <div class="col-md-10">
                                    <div class="form-group  @if ($errors->has('description')) has-danger @endif">
                                    <textarea class="form-control"
                                              name="description"
                                              id="description"
                                              rows="4">{{$donation->description,old('description') }}</textarea>
                                        @if ($errors->has('description'))
                                            <div class="form-control-feedback">{{ $errors->first('description') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group  row">
                                <label for="payment_info" class="col-md-2 col-form-label col-form-label-sm"> Payment Information:<span class="req-red">*</span></label>
                                <div class="col-md-10">
                                    <div class="form-group @if ($errors->has('payment_info')) has-danger @endif">
                                    <textarea class="form-control"
                                              name="payment_info"
                                              id="payment_info"
                                              rows="4">{{$donation->payment_info,old('payment_info') }}</textarea>

                                        @if ($errors->has('payment_info'))
                                            <div class="form-control-feedback">{{ $errors->first('payment_info') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="form-group  row">
                                <label for="start_date" class="col-sm-2 col-form-label col-form-label-sm">Start Date:</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input class="form-control"
                                               id="start_date"
                                               type="text"
                                               name="start_date"
                                               value="@if($donation->start_date){{Carbon\Carbon::createFromFormat('Y-m-d', $donation->start_date)->format('d-M-Y')}} @endif">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group  row">
                                <label for="end_date" class="col-sm-2 col-form-label col-form-label-sm">End Date:</label>
                                <div class="col-md-10">
                                    <div class="form-group">
                                        <input class="form-control"
                                               id="end_date"
                                               type="text"
                                               name="end_date"
                                               value="@if($donation->end_date){{Carbon\Carbon::createFromFormat('Y-m-d', $donation->end_date)->format('d-M-Y')}}@endif">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                </div>

                            </div>

                            <div class="row">

                                <div class="col-md-6 text-left">
                                    <img height="100" width="100" src="@if ($donation->image_url) {{ asset('storage').'/'.$donation->image_url }} @endif">

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

                @include('donations.partials.latestDonations',array('latestDonations'=>$latestDonations))

            </div>
        </div>

        <!--/.row-->
        <!--/.container-->
    </section>

@endsection

@section('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>
    <script src="{{asset('unisharp/laravel-ckeditor/ckeditor.js')}}"></script>

    <script>
        CKEDITOR.replace('description');
        CKEDITOR.replace('payment_info');
    </script>

    <script>

        $(document).ready(function () {

            $('#start_date').datepicker({
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