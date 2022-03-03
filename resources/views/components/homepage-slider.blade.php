<div class="b-carousel">
    <div id="home-slider">
        <div>
            <div class="home-slider__rectangle">
                <div class="home-slider__info">
                    <div class="home-slider__title">Скидка на все</div>
                    <p class="home-slider__subtitle">Успей все раскупить до конца текущего года!</p>
                    <button class="btn btn-active home-slider__btn">Узнать подробнее...</button>
                </div>
            </div>
            <img src="{{ asset('images/banners/pdtV7oJ9y2Ge4vkFOepz2s5FZTz5vSGETjPfg7RQ.png') }}" alt=""
                 class="b-carousel__img">
        </div>
    </div>
</div>
@section('script')
    <script>
        const slider = tns({
            container: '#home-slider',
            nav: false,
            autoplayButtonOutput: false,
            controlsText: ["", ""],
            autoplayHoverPause: true,
            "mouseDrag": true,
            items: 1,
            slideBy: 'page',
            autoplay: true
        });
    </script>
@endsection
