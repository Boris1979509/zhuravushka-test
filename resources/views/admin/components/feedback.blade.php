<div class="feedback">
    <form action="#" class="feedback__form">
        <div class="feedback__title">{{ __('FeedBackTitle') }}</div>
        <div class="form-input">
            <select name="" class="select">
                <option selected>Предложение по улучшению сервиса</option>
                <option value="">Предложение по улучшению сервиса</option>
                <option value="">Предложение по улучшению сервиса</option>
                <option value="">Предложение по улучшению сервиса</option>
            </select>
        </div>
        <div class="form-input">
            <textarea name="orderMessage" id="orderMessage" cols="30" rows="4"
                      placeholder="{{ __('MessageTextArea') }}"></textarea>
        </div>
        <div class="form-input">
            <button type="submit" class="btn btn-active">{{ __('SendEmail') }}</button>
        </div>
    </form>
</div>
