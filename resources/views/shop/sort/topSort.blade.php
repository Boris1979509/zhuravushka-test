<div class="catalog__sorting">
    <div class="catalog__sorting-options">
        <span class="title">{{ __('SortBy') }}</span>
        <a href="{{ route('category', $category->slug) }}"
           class="catalog__sorting-link {{ isCurrentRoute('category', [$category->slug]) }}">{{ __('All') }}</a>
        <a href="{{ route('category', [$category->slug, 'sort=price']) }}"
           class="catalog__sorting-link {{ isCurrentRoute('category', [$category->slug, 'sort=price']) }}">{{ __('SortByPrice') }}</a>
        <a href="{{ route('category', [$category->slug,'sort=popular']) }}"
           class="catalog__sorting-link {{ isCurrentRoute('category', [$category->slug, 'sort=popular']) }}">{{ __('SortByPopular') }}</a>
        <a href="{{ route('category', [$category->slug,'sort=name']) }}"
           class="catalog__sorting-link {{ isCurrentRoute('category', [$category->slug, 'sort=name']) }}">{{ __('SortByName') }}</a>
        <div
            class="sort-in-stock catalog__sorting-link @if(request()->has('sortInStock')) active @endif">
            <form action="{{ route('category', $category->slug) }}" method="GET">
                <input type="checkbox" name="sortInStock" class="catalog__sorting-link"
                       id="sort-in-stock" onchange="this.form.submit()"
                       @if(request()->has('sortInStock')) checked @endif>
                <label for="sort-in-stock">{{ __('SortInStock') }}</label>
            </form>
        </div>
    </div>
    @include('shop.inc.cardRender')
</div>
