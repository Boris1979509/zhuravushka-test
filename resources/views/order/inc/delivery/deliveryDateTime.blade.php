<div class="date-time-delivery" hidden>
    <div class="date-delivery">
        <div class="date-delivery__title">{{ __('DateDeliveryTitle') }}</div>
        <div class="date-delivery__options">
            <div class="date-delivery__options-item tomorrow">
                <span>{{ __('Tomorrow') . limitMonth(parseDate(carbon())->tomorrow()->format('j F')) }}</span>
            </div>
            <div class="date-delivery__options-item day-after-tomorrow">
                <span>{{ __('DayAfterTomorrow') . limitMonth(parseDate(carbon())->addDays(2)->format('j F')) }}</span>
            </div>
            <div class="delivery-date-other-block">
                <input type="text" id="other-date" name="delivery_date" autocomplete="off"
                       placeholder=" {{ __('SelectDateDelivery') }}" class="delivery-date-other">
                <img
                    src="{{ asset('images/icons/order-registration/order-arrow.svg') }}" alt="">
            </div>
        </div>
    </div>
    <div class="time-delivery">
        <div class="time-delivery__title">{{ __('TimeDeliveryTitle') }}</div>
        <div class="time-delivery__select-block">
            <select name="delivery_time" class="select">
                <option selected>{{ __('SelectTimeDelivery') }}</option>
                <option value="с 10:00 до 12:00">с 8:30 до 12:00</option>
                <option value="с 12:00 до 16:00">с 12:00 до 17:30</option>
            </select>
        </div>
    </div>
</div>
