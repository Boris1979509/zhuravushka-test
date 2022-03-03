@if(session('info') || isset($info))
    <div class="alert alert-info">
        <div class="alert-info__icon">
            <img src="{{ asset('images/icons/alerts/info.svg') }}" alt="info">
        </div>
        <div class="alert-info__message">
            <p>{{ session('info') ?? $info }}</p>
        </div>
        @if(session('info'))
            <span class="close alert-info__icon-close" onclick="this.closest('.alert').remove();"
                  title="{{ __('Close') }}"></span>
        @endif
    </div>
@endif
@if(session('error') || isset($error))
    <div class="alert alert-error">
        <div class="alert-error__icon">
            <img src="{{ asset('images/icons/alerts/error.svg') }}" alt="info">
        </div>
        <div class="alert-error__message">
            <p>{{ session('error') ?? $error }}</p>
        </div>
        @if(session('error'))
            <span class="close alert-error__icon-close" onclick="this.closest('.alert').remove();"
                  title="{{ __('Close') }}"></span>
        @endif
    </div>
@endif
@if(session('success') || isset($success))
    <div class="alert alert-success">
        <div class="alert-success__icon">
            <img src="{{ asset('images/icons/alerts/success.svg') }}" alt="info">
        </div>
        <div class="alert-success__message">
            <p>{{ session('success') ?? $success }}</p>
        </div>
        @if(session('success'))
            <span class="close alert-success__icon-close" onclick="this.closest('.alert').remove();"
                  title="{{ __('Close') }}"></span>
        @endif
    </div>
@endif
