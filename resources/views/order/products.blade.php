<div class="order-registration__info sticky-bar">
    <div class="order-registration__info-container">
        <div class="title">{{ __('YourOrderTitle') }}</div>
        @php /** @var $product Product */use App\Models\Shop\Product;@endphp
        <div class="cart-products-wrap">
            @foreach($order->products as $product)
                <div class="cart">
                    <div class="cart__product-title">{{ $product->title }}</div>
                    <div
                        class="cart__product-item-total-sum">{{ numberFormat($product->getItemTotalSum()) }}
                        <span
                            class="rub">₽</span>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="cart-total-wrap">
            <div class="cart-delivery">
                <p class="cart-delivery__title">{{ __('Delivery') }}</p>
                <p class="cart-delivery__total">0 <span class="rub">₽</span></p>
            </div>
            <div class="cart-total">
                <p class="cart-total__title">{{ __('TotalOrder') }}</p>
                <p class="cart-total__total-sum">{{ numberFormat($order->getTotalSum()) }} <span
                        class="rub">₽</span></p>
            </div>
        </div>
    </div>
    <div class="confirm-order-container">
        <button type="submit"
                class="btn btn-active confirm-order-container__btn">{{ __('OrderConfirm') }}</button>
        <div class="confirm-order-container__primary-info">
            <p>{{ __('MessageConfirmOrder') }}</p>
        </div>
    </div>
</div>
