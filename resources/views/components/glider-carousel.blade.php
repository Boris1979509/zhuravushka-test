@if(isset($children))
    @foreach($children->take(1) as $childrenItem)
        @foreach($childrenItem->products->take(8) as $productItem)
        <div>
            <div class="card">
                <div class="card__body container-preload-lazy-load">
                    <div class="preload"></div>
                    <a href="{{ route('product', $productItem->slug) }}" title="{{ $productItem->title }}">
                        <img data-src="{{ fileExist("images/products/{$productItem->photo}") }}"
                             class="card__img-top lazy-load"
                             alt="{{ $productItem->title }}">
                    </a>
                </div>
                <div class="card__title">
                    <a href="{{ route('product', $productItem->slug) }}"
                       class="link card__link">{{ $productItem->title }}</a>
                </div>
                <div class="card__footer">
                    @include('shop.priceBlock', ['product' => $productItem])
                </div>
            </div>
        </div>
        @endforeach
    @endforeach
@endif

