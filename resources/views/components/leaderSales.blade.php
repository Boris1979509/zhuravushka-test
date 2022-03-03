<div class="container">
    <div class="row">
        <section id="leader-sales">
            <div class="leader-sales">
                <p class="leader-sales__title">{{ __('LeadersSales') }}<!--<span class="see-all-link">Смотреть все</span>--></p>
                <div class="glider-contain">
                    <div class="glider" id="glider-leader-sales">
                        @include('shop.card')
                    </div>
                    <button aria-label="Previous" class="glider-prev" id="glider-prev-leaders-sales"></button>
                    <button aria-label="Next" class="glider-next" id="glider-next-leaders-sales"></button>
                </div>
            </div>
        </section>
    </div>
</div>
