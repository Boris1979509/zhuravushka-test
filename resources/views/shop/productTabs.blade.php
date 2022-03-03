<div class="product-tabs">
    <nav class="tabs-nav">
        <ul>
            <li class="tabs-nav__item active">{{ __('InfoProduct') }}</li>
            <li class="tabs-nav__item">@lang('Comments') <span class="count">0</span></li>
            <li class="tabs-nav__item">@lang('Sovety') <span class="count">0</span></li>
        </ul>
    </nav>

    <div class="tabs-content">
        <div class="tabs-content__item">
            @if($product->attributes->count())
                <h2 class="tabs-content__title">@lang('Specifications')</h2>
                <table class="table characteristics">
                    <tbody>
                    @foreach ($product->attributes as $attr)
                        <tr class="characteristics__props">
                            <td class="characteristics__props-name">{{ mb_ucfirst($attr->property->title) }}</td>
                            <td class="characteristics__props-value">{{ $attr->value->title }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                @include('flash.index', ['info' => __('During the adding process')])
            @endif
        </div>
        <div class="tabs-content__item">
            @include('flash.index', ['info' => __('NoComments')])
        </div>
        <div class="tabs-content__item">
            @include('flash.index', ['info' => __('NoRecommendations')])
        </div>
    </div>
</div>
