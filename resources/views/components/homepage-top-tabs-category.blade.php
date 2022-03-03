<div class="homepage-top-tabs-category">
    <nav class="tabs-nav">
        <ul>
            @foreach($homePageTop as $parentItem)
                <li class="tabs-nav__item">{{ $parentItem->title }}</li>
            @endforeach
        </ul>
    </nav>
    <div class="tabs-content">
        @foreach($homePageTop as $parentItem)
            <div class="tabs-content__item">
                <div class="glider-contain">
                    <div class="glider" id="glider-{{ $parentItem->slug }}">
                        @include('components.glider-carousel', ['children' => $parentItem->children])
                    </div>
                    <button aria-label="Previous" class="glider-prev"></button>
                    <button aria-label="Next" class="glider-next"></button>
                </div>
            </div>
        @endforeach
    </div>
</div>
