@extends('layouts.master-auth')

@section('title', 'Register | Step-2')

@section ('content')

    <section class="font-1 py-6">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-8">
                    <h5>Hello,  {{ucfirst(session('profile')->get('first_name'))}}</h5>
                    <form method="post" action="{{route('register.step-3')}}">
                        {{csrf_field()}}
                        <div class="row align-items-center text-center justify-content-center" id="app">

                            <div class="row background-11 w-100 py-2 rounded" v-for="(row,index) in rows">
                                <div class="col-md-12 small text-left mt-2 mb-2 font-weight-bold">Educational Backgrounds</div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input class="form-control background-white" type="text" name="field_of_study[]" v-model="row.field_of_study" placeholder="Field of study">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control btn-cursor-pointer  background-white" name="degree_id[]" v-model="row.degree_id">
                                            <option value="" disabled selected>Select Degree</option>

                                            @foreach($degrees as $degree)
                                                <option value="{{$degree->id}}">{{$degree->name}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input class="form-control  background-white" type="text" name="passing_year[]" v-model="row.passing_year" placeholder="Passing Year">
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <input class="form-control  background-white" type="text" name="institution[]" v-model="row.institution" placeholder="Institution">
                                    </div>
                                </div>

                                <div class="col-md-12 text-right" v-if="rows.length > 1">
                                    <div class="form-group">
                                        <button class="btn btn-danger btn-xs hv-cursor-pointer" type="button" @click="removeRow(row)"> Remove</button>
                                    </div>
                                </div>

                                <div class="col-md-12 text-right" v-if="index == rows.length - 1">
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-xs hv-cursor-pointer" type="button" @click="addRow"> Add More</button>
                                    </div>
                                </div>
                            </div>

                            <div class="row background-11 w-100 py-2 mt-2 rounded">
                                <div class="col-md-12 small text-left mb-2 font-weight-bold">Professional Details</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input class="form-control  background-white" type="text" name="company_institution"  placeholder="Company/Institution" value="{{old('company_institution',session('profile')->get('company_institution'))}}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input class="form-control  background-white" type="text" name="position" placeholder="Position" value="{{old('position',session('profile')->get('position'))}}">
                                    </div>
                                </div>
                            </div>

                            <div class="row background-11 w-100 py-2 mt-2 mb-2 rounded">
                                <div class="col-md-12 small text-left mb-2  font-weight-bold">Personal Details</div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <select class="form-control btn-cursor-pointer  background-white" name="blood_group">
                                            <option value="" disabled selected>Select Blood Group</option>

                                            @foreach(['A+','A-','B+','B-','O+','O-','AB+','AB-'] as $bloodGroup)
                                                <option value="{{$bloodGroup}}" @if(session('profile')->get('blood_group')==$bloodGroup) selected @endif>{{$bloodGroup}}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input class="form-control  background-white" id="dob" type="" name="dob" placeholder="Date of Birth" value="{{old('dob',session('profile')->get('dob'))}}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input class="form-control  background-white" type="text" name="contact_no" placeholder="Contact Number" value="{{old('contact_no',session('profile')->get('contact_no'))}}">
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input class="form-control  background-white" type="text" name="registration_number" placeholder="Registration/Unique ID" value="{{old('registration_number',session('profile')->get('registration_number'))}}">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 text-left">
                                <input class="btn btn-outline-primary" type="submit" name="submit" value="Skip for now">
                                <input class="btn btn-primary" type="submit" name="submit" value="Continue">
                            </div>
                        </div>
                        <div class="zform-feedback mt-3"></div>
                    </form>
                </div>
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </section>

@endsection

@section('styles')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker.min.css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/css/bootstrap-datepicker3.min.css"/>
@endsection

@section('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.7.1/js/bootstrap-datepicker.min.js"></script>

    <script src="https://unpkg.com/vue@2.5.9/dist/vue.js"></script>

    <script>
        let app = new Vue({
            el: '#app',
            data: {
                rows: []
            },
            methods: {
                addRow: function () {
                    this.rows.push({field_of_study: "", degree_id: "", passing_year: "", institution: ""});
                },

                removeRow: function (row) {
                    let index = this.rows.indexOf(row);
                    this.rows.splice(index, 1);
                }
            }
        });

        var sessionProfile = @json(session('profile'));
        if(sessionProfile.degree_id && sessionProfile.degree_id.length) {
            for(var i = 0; i < sessionProfile.degree_id.length; i++) {
                var newRow = {
                    field_of_study: sessionProfile.field_of_study[i],
                    degree_id: sessionProfile.degree_id[i],
                    passing_year: sessionProfile.passing_year[i],
                    institution: sessionProfile.institution[i]
                };
                app.rows.push(newRow);
            }
        }

        var defaultRow = {
            field_of_study: "", degree_id: "", passing_year: "", institution: ""
        };
        app.rows.push(defaultRow);
    </script>

    <script>
        $('#dob').datepicker({
            format: 'dd-mm-yyyy',
            startView: 2,
            todayHighlight: true
        })
    </script>

@endsection