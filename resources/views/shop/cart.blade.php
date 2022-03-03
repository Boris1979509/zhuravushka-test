@php /** @var Product $product*/use App\Models\Shop\Product;@endphp
@php /** @var CartService $cartService*/use App\UseCases\Cart\CartService;@endphp
<section id="cart">
    <div class="container">
        <h1 class="title">{{ __('Cart') }}</h1>
        @if(!isset($order) && !cart())
            <div class="row">
                @include('flash.index', ['info' => __('CartEmptyMessage')])
            </div>
        @else
            <div class="cart-wrap">
                <table class="table cart sticky-content">
                    <tbody>
                    @foreach ($order->products as $product)
                        <tr class="cart__product">
                            <td class="cart__img container-preload-lazy-load">
                                <div class="preload"></div>
                                <a href="{{ route('product', $product->slug) }}" target="_blank">
                                    <img data-src="{{ fileExist("images/products/{$product->photo}") }}"
                                         alt="{{ $product->title }}"
                                         class="cart__image lazy-load">
                                </a>
                            </td>
                            <td class="cart__name">
                                <a href="{{ route('product', $product->slug) }}" target="_blank"
                                   class="link cart__name-link" title="{{ $product->title }}">
                                    {{ $product->title }}
                                </a>
                            </td>
                            <td class="cart__count">
                                <div class="count">
                                    <form action="{{ route('cart.add', $product) }}" method="POST"
                                          class="addCart">
                                        @csrf
                                        <div class="product-qty">
                                            <div class="product-qty__qty">
                                                    <span class="product-qty__minus">
                                                    </span>
                                                <input type="text" class="product-qty__input"
                                                       value="{{ $product->pivot->count }}">
                                                <span class="product-qty__plus">
                                                    </span>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="qty-goods">
                                    @if($underOrder = $cartService->underOrder($product->pivot, $product))
                                        @include('shop.underOrder.underOrder')
                                    @endif
                                </div>
                            </td>
                            <td class="cart__sum">
                                <p class="cart__sum-price">{{  numberFormat($product->getItemTotalSum()) }} <span
                                        class="rub">₽</span></p>
                                <div class="under-order">
                                    @if($underOrder = $cartService->underOrder($product->pivot, $product))
                                        @include('shop.underOrder.underOrderTotal')
                                    @endif
                                </div>
                            </td>
                            <td>
                                <form action="{{ route('cart.remove', $product) }}" class="del-form" method="POST">
                                    @csrf
                                    <button type="submit" title="{{ __('ButtonCartRemove') }}"
                                            class="cart__del"></button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="cart-total-wrap sticky-bar">
                    <div class="checkout-wrap">
                    <!--<div class="cart-sale">
                            <p class="cart-total-wrap__title">{{-- __('Sale') --}}</p>
                            <p class="cart-total-wrap__total-price-sale">0 <span class="rub">₽</span></p>
                        </div>-->
                        <div class="cart-total">
                            <p class="cart-total-wrap__title bold">{{ __('Total') }}</p>
                            <p class="cart-total-wrap__total-price bold">{{ numberFormat($order->getTotalSum()) }} <span
                                    class="rub">₽</span></p>
                        </div>
                        <div class="cart-checkout">
                            <a class="btn btn-active cart-checkout__btn"
                               href="{{ route('order.place') }}">{{ __('OrderLinkTitle') }}</a>
                        </div>
                    </div>
                    <div class="primary-info" hidden>
                        <p>{{ __('UnderOrderInfo') }}</p>
                    </div>
                </div>
                {{--                @if($products->total() > $products->count())--}}
                {{--                    <div class="paginator-wrap">{{ $products->links() }}</div>--}}
                {{--                @endif--}}
            </div>
        @endif
    </div>
</section>
