@component('mail::message')
## {{ __('Thanks for register') }}
@component('mail::button', ['url' => route('home'), 'color' => 'success'])
{{ __('StartShopping') }}
@endcomponent
<hr>
@component('mail::panel')
{{ __('Thanks') }}<br>
[{{ __('AppName') }}]({{ route('home') }})
@endcomponent
@endcomponent
