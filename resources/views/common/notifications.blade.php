{{--success--}}
@if(session('success'))
    <div class="alert alert-success text-left mb-4">
        <button class="close" type="button" data-dismiss="alert"><span>×</span></button>
        {{ session('success') }}
    </div>
@endif

{{--error--}}
@if(!empty($errors))
    @if (count( $errors ) > 0)
        <div class="alert alert-danger text-left mb-4">
            <button class="close" type="button" data-dismiss="alert"><span>×</span></button>
            @foreach ($errors->all() as $error)
                <div>{{$error}}</div>
            @endforeach
        </div>
    @endif
@endif

@if(session('error'))
    <div class="alert alert-danger text-left mb-4">
        <button class="close" type="button" data-dismiss="alert"><span>×</span></button>
        {{ session('error') }}
    </div>
@endif