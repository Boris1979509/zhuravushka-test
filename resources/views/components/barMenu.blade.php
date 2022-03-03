<div class="catalog">
    <div class="catalog__list grid">
        @php /** @var ProductCategory $categoryItem */use App\Models\Shop\ProductCategory;use Illuminate\Support\Collection;
        /** @var  Collection $productCategories */
            $productCategories = isset($take) ? $productCategories->take($take) : $productCategories
        @endphp
        @foreach($productCategories as $categoryItem)
            <div class="catalog__item">
                <a href="{{ route('category' , $categoryItem->slug) }}" class="link catalog__link"
                   title="{{ $categoryItem->title }}">
                    <img class="catalog__link-img"
                         src="{{ asset('images/icons/thumb/elektrika-i-osveshhenie.svg') }}"
                         alt="{{ $categoryItem->title }}">
                    {{ $categoryItem->title  }}</a>
                @if(($categoryItem->children)->count())
                    <div class="catalog__sub-catalog">
                        @foreach($categoryItem->children as $childrenItem)
                            <a href="{{ route('category', $childrenItem->slug) }}"
                               class="link catalog__sub-catalog-link"
                               title="{{ $childrenItem->title }}">{{ $childrenItem->title }} ({{
                                $childrenItem->productsCount }})</a>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
        @if(isset($take))
            <div class="catalog__item">
                <a href="{{ route('catalog') }}" class="link catalog__link" title="{{  __('SeeAllCatalog') }}">
                    <img class="catalog__link-img"
                         src="{{ asset('images/icons/thumb/elektrika-i-osveshhenie.svg') }}"
                         alt="{{  __('SeeAllCatalog') }}">{{ __('SeeAllCatalog') }}</a>
            </div>
        @endif
    </div>
</div>
