@php /** @var App\Models\Blog\BlogCategory $category */@endphp
<div>
    <div class="form-input">
        <label for="title" class="form-input-label">{{ __('Title') }}</label>
        <input type="text" name="title" id="title" value="{{ old('title', $category->title) }}"
               class="input">
        @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-input">
        <label for="slug" class="form-input-label">{{ __('Slug') }}</label>
        <input type="text" name="slug" id="slug" class="input"
               value="{{ old('slug', $category->slug) }}">
        @error('slug')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-input">
        <label for="parent_id" class="form-input-label">{{ __('Parent') }}</label>
        <select name="parent_id" id="parent_id"
                class="input">
            @php /** @var BlogCategory $categoryItem*/use App\Models\Blog\BlogCategory; @endphp
            <option value="">{{ __('No parent') }}</option>
            @foreach($categoryList as $categoryItem)
                <option value="{{ $categoryItem->id }}"
                        @if($category->parent_id === $categoryItem->id) selected="selected" @endif>{{
                    $categoryItem->id_title }}
                </option>
            @endforeach
        </select>
        @error('parent_id')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-input">
        <label for="description" class="form-input-label">{{ __('Description') }}</label>
        <textarea class="input" name="description"
                  id="description" cols="30"
                  rows="10">{{ old('description', $category->description) }}</textarea>
        @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
