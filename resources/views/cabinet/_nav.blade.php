<div class="cabinet__sorting">
    <div class="cabinet__sorting-options">
        <a href="{{ route('cabinet.order') }}"
           class="cabinet__sorting-link{{ $page === '' ? ' active' : '' }}">{{ __('CabinetOrder') }} ({{ $user->orders->count() }})</a>
        <a href="{{ route('cabinet.comment') }}"
           class="cabinet__sorting-link{{ $page === 'comment' ? ' active' : '' }}">{{ __('CabinetComment') }} (0)</a>
        <a href="{{ route('cabinet.feedback') }}"
           class="cabinet__sorting-link{{ $page === 'feedback' ? ' active' : '' }}">{{ __('CabinetFeedBack') }}</a>
        <a href="{{ route('cabinet.profile.home') }}"
           class="cabinet__sorting-link{{ $page === 'profile' ? ' active' : '' }}">{{ __('ProfileSetting') }}</a>
    </div>
    <div class="cabinet__sorting-logout">
        @include('cabinet.logout.logout')
    </div>
</div>

