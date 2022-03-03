@component('mail::message')
    ## Ваш заказ {{ $order->number }}
    @if ($order->order_status === 'paid')
        ### Заказ оплачен на сайте
    @endif
    **Имя:** {{  $order->user_data['contacts']['name'] }}
    **Телефон:** {{  $order->user_data['contacts']['phone'] }}
    @component('mail::table')
        | Название | Цена | Количество | Сумма |
        |:-------- |:-----|:-----------|:------|
        @foreach ($order->products as $product)
            | {{ $product->title }} |
            {{ $product->price }} руб. |
            {{ $product->pivot->count }} {{ $product->unit_pricing_base_measure }} |
            {{ round($product->price * $product->pivot->count, 2) }} руб. |
        @endforeach
        | **Итого:** {{ $order->total_cost }} руб. |
        |:-----------------------------------------|
    @endcomponent
    <hr>
    @component('mail::subcopy')
        {{ __('Thanks') }}<br>
        [{{ __('AppName') }}]({{ route('home') }})
    @endcomponent
@endcomponent
