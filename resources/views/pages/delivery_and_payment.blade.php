<section id="services">
    <div class="container">
        <div class="row">
            <div class="services">
                @if($data = ($page->parent->children ?? $page->children))
                    @include('components.leftSideBar', compact('data'))
                @endif
                <div class="delivery-block">
                    {{--                    <div class="search-map">--}}
                    {{--                        <img src="{{ asset('images/delivery-search-map.png') }}" alt="map">--}}
                    {{--                    </div>--}}
                    @include('components.accordion')
                    {{--                    <div class="primary-info-block">--}}
                    {{--                        <p>--}}
                    {{--                            Строка поиска адреса расположена на карте. В поисковом поле укажите адрес предполагаемой--}}
                    {{--                            доставки или отметьте точку на карте вручную. В зависимости от тарифа Вам будут представлены--}}
                    {{--                            3 варианта стоимости доставки. В случае возникновения вопросов или невозможности определения--}}
                    {{--                            системой указанного адреса, позвоните по телефону +7 (4722) 400-999.--}}
                    {{--                        </p>--}}
                    {{--                    </div>--}}
                    <div class="payment-method-info">
                        <div class="payment-method-info__item">
                            <div class="payment-method-info__item-icon">
                                <img src="{{ asset('images/icons/services/commerce-and-shopping.svg') }}"
                                     alt="Оплата онлайн">
                            </div>
                            <div class="payment-method-info__item-body">
                                <div class="payment-method-info__item-title">Оплата онлайн</div>
                                <div class="payment-method-info__item-description">Оплату онлайн-заказа можно
                                    произвести
                                    на нашем сайте при помощи банковской карты, а товар получить по любому
                                    указанному
                                    вами адресу.
                                </div>
                            </div>
                        </div>
                        <div class="payment-method-info__item">
                            <div class="payment-method-info__item-icon">
                                <img src="{{ asset('images/icons/services/checklist.svg') }}"
                                     alt="Оплата наличными курьеру">
                            </div>
                            <div class="payment-method-info__item-body">
                                <div class="payment-method-info__item-title">Оплата наличными курьеру</div>
                                <div class="payment-method-info__item-description">Заказ можно оплатить наличными
                                    деньгами при получении товара от нашего курьера. Доставим товар по любому
                                    указанному
                                    вами адресу
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
