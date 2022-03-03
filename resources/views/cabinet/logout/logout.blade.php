<a class="link logout" href="{{ route('logout') }}" onclick="event.preventDefault();
                                       document.querySelector('.logout-form').submit();">{{ __('LogOut') }}</a>
<form class="logout-form" action="{{ route('logout') }}" method="POST" hidden>
    @csrf
</form>
