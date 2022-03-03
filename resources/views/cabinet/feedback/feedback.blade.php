<div class="feedback">
    <form action="{{ route('cabinet.feedback.send') }}" class="feedback__form" method="POST">
        @csrf
        <div class="feedback__title">{{ __('FeedBackTitle') }}</div>
        <div class="form-input">
            <select name="subject" class="select">
                <option selected value="">{{ __('SelectInList') }}</option>
                <option value="{{ __('SuggestionsImprovingService') }}">{{ __('SuggestionsImprovingService') }}</option>
                <option value="{{ __('Other') }}">{{ __('Other') }}</option>
            </select>
            @error('subject')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-input">
            <textarea name="message" id="message" cols="30" rows="4"
                      placeholder="{{ __('MessageTextArea') }}">{{ old('message') }}</textarea>
            @error('message')
            <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-input">
            <button type="submit" class="btn btn-active">{{ __('SendEmail') }}</button>
        </div>
    </form>
</div>
