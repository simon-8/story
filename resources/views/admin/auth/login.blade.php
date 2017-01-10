@if($errors)
    @foreach($errors->all() as $error)
        <p>
            {{ $error }}
        </p>
    @endforeach
@endif

<form method="POST" action="{{ route('postAdminLogin') }}">
    {!! csrf_field() !!}

    <div>
        username
        <input type="username" name="username" value="{{ old('username') }}">
    </div>

    <div>
        Password
        <input type="password" name="password" id="password">
    </div>

    <div>
        <input type="checkbox" name="remember"> Remember Me
    </div>

    <div>
        <button type="submit">Login</button>
    </div>
</form>
