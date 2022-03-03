<div class="price">
    @if(!is_null($product->old_price))
        <div class="price__item">
            <p class="price__title-old">{{ __('OldPrice') }}</p>
            <span class="price__old">{{ $product->old_price }}</span>
            <span class="rub">₽</span>
        </div>
    @endif
    <div class="price__item">
        @if(!is_null($product->old_price))<p class="price__title-new">{{ __('NewPrice') }}</p>@endif
        <span class="bold price__new">{{ numberFormat($product->price) }}&nbsp;₽</span>
        <span class="last-text-new">за {{ $product->unit_pricing_base_measure }}.</span>
    </div>
</div>
