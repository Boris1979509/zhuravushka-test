@php
    /** @var Product $product */use App\Models\Shop\Product;
    /** @var Order $order */use App\Models\Shop\Order;
    /** @var User $order->user */use App\Models\User;
@endphp
<div class="admin-orders">
    <div class="admin-orders__item">
        @forelse($orders as $order)
            <div class="content-block">
                <div class="content-block__item">
                    <div class="content-block__title-prop">{{ __('CabinetNumberOrder') }}</div>
                    <div class="content-block__title-value">{{ $order->getOrderNumber() }}</div>
                </div>
                <div class="content-block__item">
                    <div class="content-block__title-prop">{{ __('CabinetDataCreatedOrder') }}</div>
                    <div
                        class="content-block__title-value">{{ parseDate(carbon($order->created_at))->format('j F Y') }}</div>
                </div>
                <div class="content-block__item">
                    <div class="content-block__title-prop">{{ __('CabinetTotalItem') }}</div>
                    <div class="content-block__title-value total">{{ numberFormat($order->total_cost) }} <span
                            class="rub">₽</span></div>
                </div>
                @if($order->isPaid())
                    <div class="content-block__item status-order-confirmed">
                        <div>
                            <div class="content-block__title-prop">{{ __('CabinetStatusOrder') }}</div>
                            <div class="content-block__title-value">{{ __('Paid') }}</div>
                        </div>
                    </div>
                @else
                    <div class="content-block__item status-pending-payment">
                        <div>
                            <div class="content-block__title-prop">{{ __('CabinetStatusOrder') }}</div>
                            <div class="content-block__title-value">{{ __('NoPaid') }}</div>
                        </div>
                    </div>
                @endif
                <span class="accordion__button-item"></span>
                <div class="content-block__sub-content">
                    <div class="content-block__sub-content-item">
                        <div class="content-block__item">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th class="content-block__title-prop">{{ __('CabinetNameOfGoods') }}</th>
                                    <th class="content-block__title-prop">{{ __('CabinetPricePerPiece') }}</th>
                                    <th class="content-block__title-prop">{{ __('CabinetOrderQty') }}</th>
                                    <th class="content-block__title-prop">{{ __('CabinetTotalPrice') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($order->products as $i => $product)
                                    @php $i++ @endphp
                                    <tr>
                                        <td class="content-block__title-value">{{ $i . ' ' .  $product->title }}</td>
                                        <td class="content-block__title-value total">{{ numberFormat($product->price) }}
                                            <span class="rub">₽</span>
                                        </td>
                                        <td class="content-block__title-value total">{{ $product->pivot->count . ' ' . $product->unit_pricing_base_measure }}</td>
                                        <td class="content-block__title-value total">{{ numberFormat($product->getItemTotalSum()) }}
                                            <span class="rub">₽</span>
                                        </td>
                                    </tr>
                                @endforeach
                                @if($order->user)
                                    <tr>
                                        <td colspan="4" style="text-align: right">
                                            @lang('User'): <a href="{{ route('admin.users.show', $order->user) }}"
                                                              target="_blank"
                                                              class="link edit">{{ $order->user['phone'] }}</a>
                                        </td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info">
                <div class="alert-info__icon">
                    <img src="{{ asset('images/icons/alerts/info.svg') }}" alt="info">
                </div>
                <div class="alert-info__message">
                    <p>{{ __('OrdersNotFound') }}</p>
                </div>
            </div>
        @endforelse
        @if($orders->total() > $orders->count())
            <div class="paginator-wrap">{{ $orders->links() }}</div>
        @endif
    </div>
</div>
