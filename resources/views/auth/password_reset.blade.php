<!DOCTYPE html>
<html>
<head>
    <title>Reset Password</title>
</head>
<body>
    <h1>Reset Password</h1>
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div>
            <label for="email">Email:</label>
            <input type="email" name="email" value="{{ old('email', $email) }}" required autofocus>
        </div>
        <div>
            <label for="password">New Password:</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <label for="password-confirm">Confirm Password:</label>
            <input type="password" name="password_confirmation" required>
        </div>
        <div>
            <button type="submit">Reset Password</button>
        </div>
    </form>
    @if ($errors->any())
        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
</body>
</html>
