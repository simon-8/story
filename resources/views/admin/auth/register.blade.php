@if($errors)
    @foreach($errors->all() as $error)
        <p>
            {{ $error }}
        </p>
    @endforeach
@endif
<form method="POST" action="{{ route('postAdminRegister') }}">
    {!! csrf_field() !!}

    <div>
        username
        <input type="text" name="username" value="{{ old('username') }}">
    </div>

    <div>
        Password
        <input type="password" name="password">
    </div>

    <div>
        Confirm Password
        <input type="password" name="password_confirm">
    </div>

    <div>
        <button type="submit">Register</button>
    </div>
</form>
