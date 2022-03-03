@php /** @var Product $productItem */use App\Models\Shop\Product;@endphp
@foreach($products as $productItem)
    <div class="card">
        <div class="card__icons">
            @include('shop.cardIconFavorite')
            @include('shop.cardIconCompare')
        </div>
        <div class="card__body container-preload-lazy-load">
            <div class="preload"></div>
            <a href="{{ route('product', $productItem->slug) }}" title="{{ $productItem->title }}">
                <img data-src="{{ fileExist('images/products/' . $productItem->photo) }}"
                     class="card__img-top lazy-load"
                     alt="{{ $productItem->title }}">
            </a>
        </div>
        <div class="card__title">
            <a href="{{ route('product', $productItem->slug) }}"
               class="link card__link">{{ $productItem->title }}</a>
        </div>
        <div class="card__footer">
            <div>
                @include('shop.priceBlock', ['product' => $productItem])
                <form action="{{ route('cart.add', $productItem) }}" method="POST" class="addCart">
                    @csrf
                    <div class="product-qty">
                        <div class="product-qty__qty">
                            <span class="product-qty__minus"></span>
                            <input type="text" class="product-qty__input" value="1" name="qty">
                            <span class="product-qty__plus"></span>
                        </div>
                        <button class="btn btn-active btn-add">{{ __('CartButtonAdd') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
