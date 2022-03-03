<div class="top-bar__user-login">
    <ul>
        @guest
            <li>
                @if(url()->current() !== route('login'))
                    <a class="link" id="login" href="javascript:void(0)">{{ __('Login') }}</a>
                @else
                    <a class="link" href="{{ route('login') }}">{{ __('Login') }}</a>
                @endif
            </li>
            <li>
                <a class="link" href="{{ route('register') }}">{{ __('Registration') }}</a>
            </li>
        @endguest
        @auth
            <li>
                <a class="link"
                   href="{{ route('cabinet.order') }}">{{ auth()->user()->name }}</a>
            </li>
            <li>
                @include('cabinet.logout.logout')
            </li>
        @endauth
    </ul>
</div>
