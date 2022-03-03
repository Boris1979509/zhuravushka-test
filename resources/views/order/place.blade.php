@extends('layouts.app')
@section('description', '')
@section('title', __('Order Place'))
@section('content')
    <div class="container">
        <h1 class="title">{{ __('Order Place') }}</h1>
        @include('flash.index')
        <div class="message"></div>
        <form action="{{ route('order.confirm') }}" method="POST" class="form-label" id="order-form">
            @csrf
            <div class="order-registration">
                <div class="sticky-content">
                    <div class="order-registration__select-delivery">
                        <div class="title">{{ __('SelectDeliveryTitle') }}</div>
                        <div class="delivery-type">
                            @include('order.inc.delivery.deliveryTypeTransport')
                            @include('order.inc.delivery.deliveryTypePickUp')
                            {{--                        @include('order.inc.delivery.deliveryTypeSaving')--}}
                            {{--                        @include('order.inc.delivery.deliveryTypeExpress')--}}
                        </div>
                        {{--                    @include('order.inc.delivery.deliveryDateTime')--}}
                    </div>
                    <div class="order-registration__select-address-delivery">
                        <div class="delivery-address-block">
                            <div class="delivery-address-block__form">
                                <div class="title">{{ __('EnterAddressDeliveryTitle') }}</div>
                                <div class="row">
                                    <div class="form-input">
                                        <input type="text" class="input" name="city" id="city">
                                        <label for="city">{{ __('City') }}</label>
                                    </div>
                                    <div class="form-input">
                                        <input type="text" class="input" name="street" id="street">
                                        <label for="street">{{ __('Street') }}</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-input">
                                        <input type="number" class="input" name="house_number" id="houseNumber">
                                        <label for="houseNumber">{{ __('HouseNumber') }}</label>
                                    </div>
                                    <div class="form-input">
                                        <input type="number" class="input" name="apartment" id="apartment">
                                        <label for="apartment">{{ __('Apartment') }}</label>
                                    </div>
                                </div>
                            <!--<button type="submit"
                                    class="btn btn-active btn-find-place-map">{{-- __('FindAddressOnMapTitle') --}}</button>-->
                            </div>
                        <!--<div class="delivery-address-block__map">
                            <img src="{{-- asset('images/delivery-map.jpg') --}}" alt="">
                        </div>-->
                        </div>
                    </div>
                    <div class="order-registration__select-payment-method">
                        <div class="title">{{ __('SelectPaymentTitle') }}</div>
                        <div class="payment-type">
                            <div class="payment-type__cash active">
                                <input type="radio" id="payment-cash" name="payment_type" value="cash" checked>
                                <p class="title">{{ __('DriverCashTitle') }}</p>
                                <div class="description">
                                    {{ __('DriverCashDescription') }}
                                </div>
                                <div class="question-block"><span class="question">?</span></div>
                            </div>
                            <div class="payment-type__online">
                                <input type="radio" id="payment-online" name="payment_type" value="bank_card">
                                <p class="title">{{ __('PaymentOnline') }}</p>
                                <div class="description">{{ __('PaymentOnlineDescription') }}
                                </div>
                                <div class="question-block"><span class="question">?</span></div>
                            </div>
                        </div>
                    </div>
                    <div class="order-registration__contact-form">
                        <div class="title">{{ __('EnterContactInfo') }}</div>
                        <div class="order-registration__form-block">
                            <div class="form-input">
                                <input type="text" name="last_name" id="lastName" class="input"
                                       placeholder="" value="{{ auth()->user()->last_name ?? '' }}" required>
                                <label for="lastName">{{ __('LastName') }}<span class="require">*</span></label>
                            </div>
                            <div class="form-input">
                                <input type="text" name="name" id="name" class="input"
                                       placeholder="" value="{{ auth()->user()->name ?? ''}}" required>
                                <label for="name">{{ __('Name') }}<span class="require">*</span></label>
                            </div>
                            <div class="form-input">
                                <input type="text" name="middle_name" id="middleName" class="input"
                                       placeholder="">
                                <label for="middleName">{{ __('MiddleName') }}</label>
                            </div>
                            @guest
                                @include('auth.phoneRequest')
                            @endguest
                            <div class="form-input">
                                <input type="email" name="email" id="email" class="input" placeholder=""
                                       value="{{ auth()->user()->email ?? '' }}" required>
                                <label for="email">{{ __('E-Mail Address') }}<span class="require">*</span></label>
                            </div>
                            <div class="form-input">
                            <textarea name="message" id="orderMessage" cols="30" rows="4"
                              placeholder="{{ __('OrderMessage') }}"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                @include('order.products')
            </div>
        </form>
    </div>
@endsection
@section('script')
    <script>
        window.exports = (() => {
            const formOrder = document.querySelector('#order-form');
            if (!formOrder) return;
            const message = document.querySelector('.message');
            const datepickerInput = document.querySelector('input[name=delivery_date]');

            if (datepickerInput) {
                const dateDeliveryOptionItem = document.querySelectorAll('.date-delivery__options > .date-delivery__options-item');
                const datepicker = new Datepicker(datepickerInput, {
                    language: 'ru'
                });
                /**
                 * Set Date
                 * @param day
                 */
                const getDate = (day) => {
                    let date = new Date();
                    date.setDate(date.getDate() + day);
                    datepicker.setDate(date, {render: true});
                }
                const handleClick = (e, list) => {
                    list.forEach(node => {
                        node.classList.remove('active');

                    });
                    if (e.currentTarget.classList.contains('tomorrow')) {
                        getDate(1);
                    }
                    if (e.currentTarget.classList.contains('day-after-tomorrow')) {
                        getDate(2);
                    }
                    e.currentTarget.classList.add('active');

                }
                dateDeliveryOptionItem.forEach((item) => {
                    item.addEventListener('click', (e) => {
                        handleClick(e, dateDeliveryOptionItem);
                    });
                });
            }

            formOrder.addEventListener('submit', function (e) {
                e.preventDefault();
                let data = {};
                Array.from(formOrder.elements, item => {
                    data[item.name] = item.value;
                });
                data.payment_type = formOrder.elements.payment_type.value;
                data.delivery_type = formOrder.elements.delivery_type.value;
                xmlHttpRequest(formOrder.action, data, (data) => {
                    if (validator(formOrder, data)) {
                        if (data.error) {
                            message.innerHTML = data.error;
                        } else {
                            if (data.route) {
                                window.location = data.route;
                            }
                        }
                    }
                });
            });
        })();
    </script>
@endsection

