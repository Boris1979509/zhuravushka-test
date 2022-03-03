@component('mail::message')
# {{ __('YourOrderTitle') }} {{ $order->number }}
@if ($order->order_status === 'paid')
### {{ __('PaidOrderOnline') }}
@endif
**{{ __('Name') }}:** {{ $order->user_data['contacts']['name'] }}<br>
**{{ __('Phone') }}:** {{ $order->user_data['contacts']['phone'] }}
@component('mail::table')
{{ $table->render() }}
@endcomponent
{{ __('Total') }} {{ $order->total_cost }} {{ __('Rub') }}
@component('mail::subcopy')
{{ __('Thanks') }}<br>
[{{ __('AppName') }}]({{ config('app.url') }})
@endcomponent
@endcomponent
