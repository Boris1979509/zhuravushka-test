@extends('layouts.app')
@section('description', '')
@section('title', __('OrderInfo'))
@section('content')
    <section id="order-info">
        <div class="container">
            <div class="order-info">
                <div class="order-info__block-title">
                    <div class="icon-check"></div>
                    <div class="title">Заказ {{ $orderInfo->number }} успешно оформлен!</div>
                </div>
                @guest
                    <div class="alert alert-info">
                        <div class="alert-info__icon">
                            <img src="{{ asset('images/icons/alerts/info.svg') }}" alt="info">
                        </div>
                        <div class="alert-info__message">
                            <p>{{ __('ConfirmYourPhoneNumberUseProfile') }}</p>
                            <button class="btn btn-active btn-confirmed">{{ __('ConfirmedPhone') }}</button>
                        </div>
                    </div>
                @endguest
{{--                <div class="title">{{ __('ThanksForOrderTitle') }}</div>--}}
{{--                <div class="order-info__primary-info-block">--}}
{{--                    <div class="print">--}}
{{--                        <svg width="16" height="16" viewBox="0 0 16 16" fill="none"--}}
{{--                             xmlns="http://www.w3.org/2000/svg">--}}
{{--                            <path--}}
{{--                                d="M14.7556 4.18464H13.0586V1.09792C13.0586 0.803388 12.8198 0.564575 12.5253 0.564575H3.47475C3.18022 0.564575 2.94141 0.803356 2.94141 1.09792V4.18464H1.24444C0.55825 4.18464 0 4.74292 0 5.42911V10.7948C0 11.481 0.55825 12.0392 1.24444 12.0392H2.9415V14.9022C2.9415 15.1967 3.18028 15.4355 3.47484 15.4355H12.5252C12.8197 15.4355 13.0585 15.1967 13.0585 14.9022V12.0392H14.7556C15.4418 12.0392 16 11.481 16 10.7948V5.42911C16 4.74295 15.4418 4.18464 14.7556 4.18464ZM4.00806 1.63126H11.9919V4.18464H4.00806V1.63126ZM11.9918 14.3688H4.00819C4.00819 14.2646 4.00819 10.1344 4.00819 10.0055H11.9918C11.9918 10.1376 11.9918 14.2686 11.9918 14.3688ZM14.9333 10.7948C14.9333 10.8929 14.8536 10.9726 14.7556 10.9726H13.0585V9.47217C13.0585 9.17764 12.8197 8.93882 12.5252 8.93882H3.47484C3.18031 8.93882 2.9415 9.17761 2.9415 9.47217V10.9726H1.24444C1.14641 10.9726 1.06666 10.8929 1.06666 10.7948V5.42914C1.06666 5.33111 1.14641 5.25136 1.24444 5.25136C1.65363 5.25136 14.356 5.25136 14.7556 5.25136C14.8536 5.25136 14.9333 5.33111 14.9333 5.42914V10.7948Z"--}}
{{--                                fill="#858585"/>--}}
{{--                            <path--}}
{{--                                d="M12.5277 6.24963H11.1701C10.8755 6.24963 10.6367 6.48841 10.6367 6.78298C10.6367 7.07754 10.8755 7.31632 11.1701 7.31632H12.5277C12.8222 7.31632 13.061 7.07754 13.061 6.78298C13.061 6.48841 12.8222 6.24963 12.5277 6.24963Z"--}}
{{--                                fill="#858585"/>--}}
{{--                            <path--}}
{{--                                d="M10.3119 12.4949H5.6896C5.39506 12.4949 5.15625 12.7337 5.15625 13.0282C5.15625 13.3228 5.39503 13.5616 5.6896 13.5616H10.3118C10.6064 13.5616 10.8452 13.3228 10.8452 13.0282C10.8452 12.7337 10.6064 12.4949 10.3119 12.4949Z"--}}
{{--                                fill="#858585"/>--}}
{{--                            <path--}}
{{--                                d="M10.3119 10.8127H5.6896C5.39506 10.8127 5.15625 11.0515 5.15625 11.3461C5.15625 11.6406 5.39503 11.8794 5.6896 11.8794H10.3118C10.6064 11.8794 10.8452 11.6406 10.8452 11.3461C10.8452 11.0515 10.6064 10.8127 10.3119 10.8127Z"--}}
{{--                                fill="#858585"/>--}}
{{--                        </svg>--}}
{{--                        {{ __('OrderPrint') }}</div>--}}
{{--                </div>--}}
                <div class="order-info__customer">
                    <div class="title">{{ __('OrderInfo') }}</div>
                    <div class="customer-block">
                        <p class="customer-block__title">{{ __('Customer') }}</p>
                        <p class="customer-block__name">{{ $orderInfo->user_data['contacts']['last_name'] }} {{ $orderInfo->user_data['contacts']['name'] }}</p>
                        <p class="customer-block__phone">{{ $orderInfo->user_data['contacts']['phone'] }}</p>
                        <p class="customer-block__email">{{ $orderInfo->user_data['contacts']['email'] }}</p>
                    </div>
                </div>
                @if($orderInfo->user_data['delivery_type'] === 'pickup')
                    <div class="order-info__delivery">
                        <div class="customer-block">
                            <p class="customer-block__title">{{ __('OrderInfoDelivery') }}</p>
                            <p class="customer-block__description">{{ __('PickupText') }}</p>
                        </div>
                    </div>
                    @if($orderInfo->order_status !== 'paid')
                        <div class="order-info__payment">
                            <div class="customer-block">
                                <p class="customer-block__title">{{ __('OrderInfoPayment') }}</p>
                                <p class="customer-block__description">{{ __('PaymentText') }}</p>
                                <p class="customer-block__sub-description">{{ __('PaymentSubText') }}</p>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
            @include('order.info-products')
        </div>
    </section>
@endsection

