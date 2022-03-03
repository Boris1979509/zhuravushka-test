@php /** @var App\Models\Blog\BlogPost $item */@endphp
<div>
    <button type="submit" class="btn btn-outline btn-go-on">{{ __('Save') }}</button>
</div>
@if($category->exists)
    <div class="mt-1">
        <p>{{ __('ID') }}: {{ $category->id }}</p>
        <div class="form-input">
            <label for="" class="form-input-label">{{ __('Created') }}</label>
            <input type="text" class="input" value="{{ parseDate(carbon($category->created_at))->format('j F, Y') }}"
                   disabled="disabled">
        </div>
        <div class="form-input">
            <label for="" class="form-input-label">{{ __('Updated') }}</label>
            <input type="text" class="input" value="{{ parseDate(carbon($category->updated_at))->format('j F, Y') }}"
                   disabled="disabled">
        </div>
        @if($category->deleted_at)
            <div class="form-input">
                <label for="" class="form-input-label">{{ __('Deleted') }}</label>
                <input type="text" class="input" value="{{ parseDate(carbon($category->deleted_at))->format('j F, Y') }}"
                       disabled="disabled">
            </div>
        @endif
    </div>
@endif
