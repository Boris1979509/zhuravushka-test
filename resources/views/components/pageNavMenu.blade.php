@if($pagesNavMenu = $pages->where('parent_id', 0))
    <div class="container">
        <div class="row">
            <section id="page-nav-menu">
                <ul class="page-nav-menu">
                    @foreach($pagesNavMenu->where('parent_id', 0) as $pageItem)
                        <li class="page-nav-menu__item {{ isCurrentRoute('page', [$pageItem->slug]) }}">
                            <a href="{{ url('page', $pageItem->slug) }}" class="link page-nav-menu__link"
                               title="{{ $pageItem->title }}">
                                {{ $pageItem->title }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </section>
        </div>
    </div>
@endif
