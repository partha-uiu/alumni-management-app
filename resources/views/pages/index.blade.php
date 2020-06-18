@extends('layouts.master')

@section('title', 'Pages')


@section('styles')
    <link href="{{asset('lib/owl.carousel/dist/assets/owl.carousel.min.css')}}" rel="stylesheet">
    <link href="{{asset('lib/owl.carousel/dist/assets/owl.theme.default.min.css')}}" rel="stylesheet">
@endsection

<!-- Main stylesheet and color file-->

@section('content')

    @include('common.nav-section')

    <hr class="color-9 mt-0">
    
    <section class="font-1 py-4">
    
        <div class="container">
            @include('common.notifications')
            <div class="row justify-content-center">
                <div class="col-12 col-lg-8">
                    <div class="tabs">
                        <div class="nav-bar">
                            <div class="nav-bar-item @if(session('homeTab')) active @elseif( (!session('homeTab')) && (!session('aboutTab')) && (!session('committeeTab')) ) active @endif">Update home page</div>
                            <div class="nav-bar-item @if(session('aboutTab'))  active @endif">Update about page</div>
                            <div class="nav-bar-item  @if(session('committeeTab'))  active @endif">Update committee page</div>
                        </div>
                        <div class="tab-contents overflow-hidden">
                            <div class="tab-content @if(session('homeTab')) active @elseif( (!session('homeTab')) && (!session('aboutTab')) && (!session('committeeTab')) ) active @endif">
                                <div class="background-oxford color-white p-3 mb-3">
                                    <p class="mb-2">Update home page</p>
                                </div>

                                <form class="background-11 p-3" method="post" action="{{route('home.update')}}" enctype="multipart/form-data" files="true">
                                    {{csrf_field()}}
                                    <div class="row align-items-center text-center justify-content-center">
                                        <div class="col-6">
                                            <p>Enter Alumni Association Title</p>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input class="form-control background-white" type="text" name="alumni_association_title" value="{{$home->alumni_association_title or ''}}" placeholder="Enter header title text">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <p>Or upload the logo</p>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <div class="form-group text-left">
                                                    <img class="mb-2" @if(isset($home->logo_url)) src="{{asset('storage').'/'.$home->logo_url}}" @else  src="{{asset('images/no-image-default.jpg')}}" @endif height="100" width="100">
                                                    @if(isset($home->logo_url))
                                                        <a class="btn btn-xs" href="{{route('home-logo.destroy')}}" onclick="return chkLogoDelete();">
                                                            <i class="fa fa-trash"></i>Delete
                                                        </a>
                                                    @endif
                                                    <input class="inputfile" id="file-1" type="file" name="logo_url" data-multiple-caption="{count} files selected" multiple="">
                                                    <label class="btn btn-outline-primary btn-sm" for="file-1"><span>Or upload the logo</span></label>
                                                </div>
                                            </div>


                                        </div>
                                        <div class=" col-6 text-right">
                                            <p>Insert the home page image</p>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group text-left">

                                                <img class="mb-2" @if(isset($home->home_image_url)) src="{{asset('storage').'/'.$home->home_image_url}}" @else src="{{asset('images/no-image-default.jpg')}}" @endif  height="100" width="100">
                                                @if(isset($home->home_image_url))
                                                    <a class="btn btn-xs" href="{{route('home-background.destroy')}}" onclick="return chkBackgroundDelete();">
                                                        <i class="fa fa-trash"></i>Delete
                                                    </a>
                                                @endif

                                                <input class="inputfile" id="file-2" type="file" name="home_image_url" data-multiple-caption="{count} files selected" multiple="">
                                                <label class="btn btn-outline-primary btn-sm" for="file-2"><span>Choose a file</span></label>
                                            </div>
                                        </div>
                                        <div class="col-6 text-right">
                                            <p>Insert Navbar Color Code</p>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input class="form-control" type="color" value="{{$home->nav_color or ''}}" name="nav_color" placeholder="Navigation background color code">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <p>Box title 1</p>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input class="form-control background-white" type="text" name="box_title_1" value="{{$home->box_title_1 or ''}}" placeholder="Box title 1">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <p>Box description 1</p>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <textarea class="form-control background-white" type="text" name="box_description_1" placeholder="Box description 1">{{$home->box_description_1 or ''}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <p>Box title 2</p>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input class="form-control background-white" type="text" name="box_title_2" value="{{$home->box_title_2 or ''}}" placeholder="Box title 1">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <p>Box description 2</p>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <textarea class="form-control background-white" type="text" name="box_description_2" placeholder="Box description 2">{{$home->box_description_2 or ''}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <p>Box title 3</p>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input class="form-control background-white" type="text" name="box_title_3" value="{{$home->box_title_3 or ''}}" placeholder="Box title 3">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <p>Box description 3</p>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <textarea class="form-control background-white" type="text" name="box_description_3" placeholder="Box description 3">{{$home->box_description_3 or ''}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <p>Box title 4</p>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input class="form-control background-white" type="text" name="box_title_4" value="{{$home->box_title_4 or ''}}" placeholder="Box title 4">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <p>Box description 4</p>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <textarea class="form-control background-white" type="text" name="box_description_4" placeholder="Box description 4">{{$home->box_description_4 or ''}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <p>Content box 5 title</p>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input class="form-control background-white" type="text" name="content_box_5_title" value="{{$home->content_box_5_title or ''}}" placeholder="Content box 5 title">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <p>Content box 5 description</p>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <textarea class="form-control background-white" type="text" name="content_box_5_description" placeholder="Content box 5 description">{{$home->content_box_5_description or ''}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <p>Contact heading</p>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input class="form-control background-white" type="text" name="contact_heading" value="{{$home->contact_heading or ''}}" placeholder="Contact heading">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <p>Contact description</p>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <textarea class="form-control background-white" type="text" name="contact_description" placeholder="Contact description">{{$home->contact_description or ''}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="color-white mt-3 btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-content  @if(session('aboutTab'))  active @endif">
                                <div class="background-oxford color-white p-3 mb-3">
                                    <p class="mb-0">Update about page</p>
                                </div>
                                <form class="background-11 p-3" method="post" action="{{route('about.update')}}">

                                    {{csrf_field()}}
                                    <div class="row align-items-center text-center justify-content-center">
                                        <div class="col-6">
                                            <p>Enter Alumni Title</p>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input class="form-control background-white" type="text" name="alumni_title" value="{{$about->alumni_title or ''}}" placeholder="i.e. CSE SUST">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <p>Department slogan title</p>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input class="form-control background-white" type="text" name="department_slogan_title" value="{{$about->department_slogan_title or ''}}" placeholder="Slogan title">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <p>Department slogan elaboration</p>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <textarea class="form-control background-white" type="text" name="department_slogan_elaboration" placeholder="slogan elaboration text">{{$about->department_slogan_elaboration or ''}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <p>Mission and Vision Title</p>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input class="form-control background-white" type="text" name="mission_vision_title" value="{{$about->mission_vision_title or ''}}" placeholder="Mission and Vision title">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <p>Mission and Vision description</p>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <textarea class="form-control background-white" type="text" name="mission_vision_description" placeholder="Mission and Vision description">{{$about->mission_vision_description or ''}}</textarea>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <p>Founded In</p>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input class="form-control background-white" type="text" name="foundation_date" value="{{$about->foundation_date or ''}}" placeholder="Year">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <p>Total Alumni</p>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input class="form-control background-white" type="text" name="total_alumni" value="{{$about->total_alumni or ''}}" placeholder="Total alumni number">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <p>Current Students</p>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <input class="form-control background-white" type="text" name="current_students" value="{{$about->current_students or ''}}" placeholder="Current Students number">
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="color-white my-2 btn btn-primary">Update</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="tab-content @if(session('committeeTab'))  active @endif">
                                <div class="col-lg-12" id="app">
                                    <div class="background-oxford color-white p-3 mb-3">
                                        <p class="mb-0">Update committee page</p>
                                    </div>

                                    <form class="background-11 p-3 " method="post" action="{{route('committee.update')}}" enctype="multipart/form-data" files="true">
                                        {{csrf_field()}}
                                         <input type="hidden" name="department_id"  value="{{$department->id}}"> 
                                         <input type="hidden" name="institution_id"  value="{{$institution->id}}">

                                        <div class="row align-items-center text-center justify-content-center">

                                            <input type="hidden" name="committee">
                                            <div class="col-6">
                                                <p>Enter Title</p>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <input class="form-control background-white" type="text" name="title" value="{{$committeeTitle->title or '' }}" placeholder="i.e. Committee 2017-2018">
                                                </div>
                                                @if ($errors->has('title'))
                                                    <div class="alert alert-danger">
                                                        <span class="form-text">
                                                                {{ $errors->first('title') }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-6">
                                                <p>Description text</p>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <textarea id="committee_description" class="form-control background-white" type="text" name="description" placeholder="Enter description">{{$committeeTitle->description or ''}}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-4 offset-md-8">
                                                <button class="btn btn-outline-primary  hv-cursor-pointer">Save</button>
                                            </div>
                                        </div>
                                    </form>
                                    <form class="background-11 p-3 " method="post" action="{{route('committee.update')}}" enctype="multipart/form-data" files="true">
                                        {{csrf_field()}}
                                        <div class="mt-2 w-100">
                                            <hr class="color-white">
                                        </div>
                                        <input type="hidden" name="committee_members">

                                        <div class="row align-items-center text-center justify-content-center" v-for="(row,index) in rows">

                                            <div class="col-6">
                                                <p>Member name</p>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <input class="form-control background-white" type="text" name="member_name[]" v-model="row.member_name" placeholder="Enter member name">
                                                </div>
                                                @if ($errors->has('member_name.*'))
                                                    <div class="alert alert-danger">
                                                        <span class="form-text">
                                                                {{ $errors->first('member_name.*') }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-6">
                                                <p>Member title</p>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <input class="form-control background-white" type="text" name="member_title[]" v-model="row.member_title" placeholder="Enter member title">
                                                </div>

                                                @if ($errors->has('member_title.*'))
                                                    <div class="alert alert-danger">
                                                        <span class="form-text">
                                                                {{ $errors->first('member_title.*') }}
                                                        </span>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="col-6 text-right">
                                                <p>Insert member image</p>
                                            </div>
                                            <div class="col-6 mb-2">
                                                <div class="form-group text-left">
                                                    <input class="inputfile" v-bind:id="index" type="file" name="member_image[]" data-multiple-caption="{count} files selected" multiple="">
                                                    <label class="btn btn-outline-primary btn-sm" v-bind:for="index">
                                                        <svg v-if="index>0" xmlns="http://www.w3.org/2000/svg" width="20" height="17" viewBox="0 0 20 17">
                                                            <path d="M10 0l-5.2 4.9h3.3v5.1h3.8v-5.1h3.3l-5.2-4.9zm9.3 11.5l-3.2-2.1h-2l3.4 2.6h-3.5c-.1 0-.2.1-.2.1l-.8 2.3h-6l-.8-2.2c-.1-.1-.1-.2-.2-.2h-3.6l3.4-2.6h-2l-3.2 2.1c-.4.3-.7 1-.6 1.5l.6 3.1c.1.5.7.9 1.2.9h16.3c.6 0 1.1-.4 1.3-.9l.6-3.1c.1-.5-.2-1.2-.7-1.5z"></path>
                                                        </svg>
                                                        <span>Choose a file</span></label>

                                                </div>
                                                <span class="text-left" v-if="index >0">
                                            <a class="btn btn-outline-danger btn-xs hv-cursor-pointer" type="button" @click="removeRow(row)"> Remove</a>
                                        </span>
                                            </div>

                                        </div>
                                        <div class="row align-items-center">
                                            <div class="col-6 text-right">
                                                <button type="submit" class="color-white my-3 btn btn-primary hv-cursor-pointer">Add Member</button>
                                            </div>
                                            <div class="col-6 text-left">
                                                <button class="my-3 btn btn-outline-primary hv-cursor-pointer" type="button" @click="addRow">Add More Member</button>
                                            </div>
                                        </div>
                                    </form>
                                    @if(count($committeeMembers))
                                        <table class="table mt-2 table-responsive">
                                            <tr>
                                                <th>Member Image</th>
                                                <th>Member name</th>
                                                <th>Member title</th>
                                                <th>Edit</th>
                                                <th>Delete</th>
                                            </tr>

                                            @foreach($committeeMembers as $committeeMember)
                                                <tr>
                                                    <td><img class="radius-round" @if($committeeMember->member_image)
                                                        src="{{asset('storage').'/'.$committeeMember->member_image}}"
                                                             @else src="{{asset('images/sample.png')}}"
                                                             @endif
                                                             alt="Member"></td>
                                                    <td>{{$committeeMember->member_name}}</td>
                                                    <td> {{$committeeMember->member_title}}</td>

                                                    <td><a href="{{route('committee-member.edit',['id'=>$committeeMember->id])}}"><i class="fa fa-pencil"></i></a></td>
                                                    <td><a href="{{route('committee-member.destroy',['id'=>$committeeMember->id])}}" onclick="return chkDelete();"><i class="fa fa-trash"></i></a></td>
                                                </tr>
                                            @endforeach
                                        </table>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/.row-->
        </div>
        <!--/.container-->
    </section>
@endsection

<!--  -->
<!--    JavaScripts-->
<!--    =============================================-->
@section('scripts')
    <script src="https://unpkg.com/vue@2.5.9/dist/vue.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>

    <script src="assets/lib/owl.carousel/dist/owl.carousel.min.js"></script>
    <script src="{{asset('unisharp/laravel-ckeditor/ckeditor.js')}}"></script>

    <script>
        CKEDITOR.replace('contact_description');
        CKEDITOR.replace('box_description_1');
        CKEDITOR.replace('box_description_2');
        CKEDITOR.replace('box_description_3');
        CKEDITOR.replace('box_description_4');
        CKEDITOR.replace('content_box_5_description');
        CKEDITOR.replace('department_slogan_elaboration');
        CKEDITOR.replace('mission_vision_description');

    </script>
    <script>

        let app = new Vue({
            el: '#app',
            data: {
                rows: [
                    {
                        member_name: "", member_title: "", member_image: ""
                    },
                ]
            },
            methods: {
                addRow: function () {
                    this.rows.push({member_name: "", member_title: "", member_image: ""});
                },

                removeRow: function (row) {
                    let index = this.rows.indexOf(row)
                    this.rows.splice(index, 1);
                }

            },
            mounted() {
                CKEDITOR.replace('description');
            }

        });

        function chkDelete() {
            return confirm('Are you sure you want to delete this member ?');
        }

        function chkLogoDelete() {
            return confirm('Are you sure you want to delete the logo ?');
        }

        function chkBackgroundDelete() {
            return confirm('Are you sure you want to delete the background image ?');
        }

    </script>




@endsection