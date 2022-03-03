<div class="form-input form-label">
    <input type="text" name="verifyToken" maxlength="4" placeholder=""
           id="verifyToken"
           class="input" autocomplete="off" data-empty="false">
    @error('verifyToken')
    <div class="invalid-feedback">{{ $message }}</div>
    @enderror
    <label for="verifyToken">{{ __('CodeConfirmBy') }}</label>
</div>
<div class="form-input verify-block-timer"></div>

