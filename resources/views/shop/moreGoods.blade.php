<h3>{{ __('DontForgetToBuy') }}</h3>
<div class="glider-contain">
    <div class="glider" id="more-goods">
        @include('shop.card', ['products' => $moreGoods])
    </div>
    <button aria-label="Previous" class="glider-prev" id="glider-prev-more-goods"></button>
    <button aria-label="Next" class="glider-next" id="glider-next-more-goods"></button>
    <div role="tablist" class="glider-dots" id="more-goods-dots"></div>
</div>
@section('script')
    <script>
        ((elem) => {
            if (!elem)
                return;
            new Glider(elem, {
                itemWidth: 'auto',
                duration: 0.25,
                slidesToShow: 1, // auto
                slidesToScroll: 1, // auto
                propagateEvent: false,
                draggable: false,
                dots: '#more-goods-dots',
                arrows: {
                    prev: '#glider-prev-more-goods',
                    next: '#glider-next-more-goods'
                },
                responsive: [
                    {
                        breakpoint: 700,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
                        }
                    },
                    {
                        breakpoint: 776,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
                        }
                    },
                    {
                        breakpoint: 890,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                        }
                    },
                    {
                        breakpoint: 1199,
                        settings: {
                            slidesToShow: 4,
                            slidesToScroll: 4,
                        }
                    },
                    {
                        breakpoint: 1200,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
                        }
                    }
                ]
            });
        })(document.getElementById('more-goods'));
    </script>
@endsection
