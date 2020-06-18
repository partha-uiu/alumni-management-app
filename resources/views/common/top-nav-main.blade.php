        <div class="znav-container znav-oxford" id="znav-container" @if(isset($home->nav_color)) style="background-color:{{$home->nav_color}}" @else style="background-color:#002147 !important" @endif>
            <div class="container">
                <nav class="navbar navbar-toggleable-md">
                    <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                        <div class="hamburger hamburger--emphatic">
                            <div class="hamburger-box">
                                <div class="hamburger-inner"></div>
                            </div>
                        </div>
                    </button>

                    @if  ((Auth::check())&& (Auth::user()->hasAnyRole('super-admin|admin|editor|faculty-stuff')))
                        <a class="navbar-brand overflow-hidden pr-5" href="{{route('admin.home')}}">
                            @if(isset($home->alumni_association_title) ) {{ $home->alumni_association_title }}
                            @elseif(isset($home->logo_url))
                                <img src="{{asset('storage').'/'.$home->logo_url}}" height="50" width="80">
                            @endif

                        </a>
                    @elseif ((Auth::check())&& (Auth::user()->hasRole('alumni')))
                        <a class="navbar-brand overflow-hidden pr-5" href="{{route('user.home')}}">
                            @if(isset($home->alumni_association_title) ) {{ $home->alumni_association_title }}
                            @elseif(isset($home->logo_url))
                                <img src="{{asset('storage').'/'.$home->logo_url}}" height="50" width="80">
                            @endif
                        </a>
                    @else
                        <a class="navbar-brand overflow-hidden pr-5" href="{{route('cse-connect.home')}}">
                            @if(isset($home->alumni_association_title))  {{ $home->alumni_association_title }}
                            @elseif(isset($home->logo_url))
                                <img src="{{asset('storage').'/'.$home->logo_url}}" height="50" width="80">
                            @endif
                        </a>
                    @endif


                    <div class="collapse navbar-collapse" id="navbarNavDropdown">
                        <ul class="navbar-nav ml-auto">

                            @if  ((Auth::check())&& (Auth::user()->hasAnyRole('super-admin|admin|editor|faculty-stuff')))
                                <li><a href="{{route('admin.home')}}">Home</a></li>
                            @elseif ((Auth::check())&& (Auth::user()->hasRole('alumni')))
                                <li><a href="{{route('user.home')}}">Home</a></li>
                            @else
                                <li><a href="{{route('cse-connect.home')}}">Home</a></li>
                            @endif


                            <li><a href="{{route('about')}}">About</a></li>
                            <li><a href="{{route('committee')}}">Committee</a></li>
                            @if (Auth::check())
                                <li><a href="@if (Auth::user()->hasAnyRole('alumni|student')) {{route('profile', ['id' => auth()->id()])}} @endif">{{ Auth::User()->first_name}}</a></li>

                                <form id="logout-form" class="d-none" action="{{ route('logout') }}" method="POST">
                                    {{ csrf_field() }}
                                </form>
                                <li>
                                    <a href="JavaScript:void(0)" ><span class="fa fa-cog"></span></a>
                                    <ul class="dropdown auth-menu-dropdown">
                                        <li>
                                            @if  ((Auth::check())&& (Auth::user()->hasAnyRole('super-admin|admin|editor|faculty-stuff')))
                                                <a href="{{route('settings.user',['id'=>Auth::id()])}}">
                                                    Settings
                                                </a>
                                            @elseif ((Auth::check())&& (Auth::user()->hasRole('alumni')))
                                                <a href="{{route('settings.password')}}">
                                                        Settings
                                                </a>
                                            @endif

                                        </li>
                                        <li>
                                            <a href="{{route('logout')}}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                                Logout
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                            @guest

                                <li class="has-dropdown">

                                    <a href="JavaScript:void(0)" id="signInLink">Sign in</a>

                                    <ul class="dropdown login-menu-dropdown" id="signInBox">
                                        <li>
                                            <div class="px-3 py-2">
                                            
                                                  
                                                @include('common.notifications')

                                                <h5 class="fw-300 mb-3 text-center">Sign in with</h5>

                                                <div class="row">
                                                    <div class="col-6">
                                                        <a class="btn btn-icon btn-xs facebook btn-icon-left btn-block" href="{{ route('social.auth', 'facebook') }}">
                                                            <span class="fa fa-facebook"></span> Facebook
                                                        </a>
                                                    </div>
                                                    <div class="col-6">
                                                        <a class="btn btn-icon btn-xs btn-linkedin btn-icon-left btn-block" href="{{ route('social.auth', 'linkedin') }}">
                                                            <span class="fa fa-linkedin"></span> Linkedin
                                                        </a>
                                                    </div>
                                                </div>
                                                <div class="my-3 text-center">Or</div>

                                                <form method="POST" action="{{ route('login') }}">
                                                    {{ csrf_field() }}
                                                    <input id="email" type="email" class="form-control mb-3" name="email" value="{{ old('email') }}" placeholder="Email" required autofocus>
                                                    <input id="password" type="password" class="form-control mb-3" name="password" placeholder="Password" required>
                                                    <div class="row align-items-center">
                                                        <div class="col text-left">
                                                            <div class="fs--1 d-inline-block">
                                                                <div class="checkbox">
                                                                    <label class="form-check-label">
                                                                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                                                                        Remember Me
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col text-right">
                                                            <button class="btn-block btn btn-primary btn-sm" type="submit">Log in</button>
                                                        </div>
                                                    </div>
                                                </form>

                                                <hr class="color-9 mt-2">
                                                <div class="mt-2 text-left color-1">
                                                    <a class="btn forget-password" href="{{ route('password.request') }}">Forgot your password?</a>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            @endguest
                        </ul>
                    </div>
                </nav>
            </div>
        </div>