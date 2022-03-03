<div class="side-bar">
    <ul class="side-bar__list">
        @php /** @var Page $item */use App\Models\Shop\Page; @endphp
        @foreach($data as $item)
            <li class="side-bar__item {{ isCurrentRoute('page', [$item->slug]) }}">
                <a class="link side-bar__link" title="{{ $item->title }}"
                   href="{{ route('page', $item->slug) }}">{{ $item->title }}</a>
            </li>
        @endforeach
    </ul>
</div>

