<form method="POST" action="{{ route('login') }}" id="login-form">
    @csrf
    <div class="form-input">
        <label for="phone-login" class="form-input-label">{{ __('Phone') }}<span class="require">*</span></label>
        <input id="phone-login" type="text" class="input mask-input" placeholder="+7 (961) 199-92-92"
               {{--                   pattern="(\+7[-_()\s]+|\+7\s?[(]{0,1}[0-9]{3}[)]{0,1}\s?\d{3}[-]{0,1}\d{2}[-]{0,1}\d{2})"--}}
               name="phone" value="{{ old('phone') }}"
               autocomplete="phone" autofocus>
        @error('phone')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-input">
        <label for="password-login" class="form-input-label">{{ __('Password') }}<span class="require">*</span></label>
        <input id="password-login" type="password" class="input" name="password"
               autocomplete="current-password">
        @error('password')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    {{--        <div class="form-input">--}}
    {{--            <input class="form-check-input" type="checkbox" name="remember"--}}
    {{--                   id="remember" {{ old('remember') ? 'checked' : '' }}>--}}
    {{--            <label for="remember">--}}
    {{--                {{ __('Remember Me') }}--}}
    {{--            </label>--}}
    {{--        </div>--}}
    <div class="form-input">
        <button type="submit" class="btn btn-active btn__login">
            {{ __('Login') }}
        </button>
    </div>
    <div class="form-input password-request">
        @if (Route::has('password.request'))
            <a rel="nofollow" class="link password-request__link" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
        @endif
    </div>
</form>


