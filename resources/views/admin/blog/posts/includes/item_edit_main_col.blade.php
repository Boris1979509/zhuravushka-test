@php /** @var App\Models\Blog\BlogPost $item */@endphp
<div>
    @if($item->exists)
        @include('flash.index', ($item->is_published) ? ['success' =>  __('Published')] : ['info' => __('Unpublished')])
    @endif
    <div>
        <nav class="tabs-nav">
            <ul>
                <li class="tabs-nav__item active">{{ __('Data') }}</li>
                <li class="tabs-nav__item">{{ __('Additional data') }}</li>
            </ul>
        </nav>
        <div class="tabs-content">
            <div class="tabs-content__item">
                <div class="form-input">
                    <label for="title" class="form-input-label">{{ __('Title') }}</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $item->title) }}"
                           class="input">
                    @error('title')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-input">
                    <label for="content" class="form-input-label">{{ __('Article') }}</label>
                    <textarea class="input" name="content"
                              id="content" cols="30"
                              rows="10">{{ old('content', $item->content) }}</textarea>
                    @error('content')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="tabs-content__item">
                <div class="form-input">
                    <label for="slug" class="form-input-label">{{ __('Slug') }}</label>
                    <input type="text" name="slug" id="slug" class="input"
                           value="{{ old('slug', $item->slug) }}">
                </div>
                <div class="form-input">
                    <label for="category_id" class="form-input-label">{{ __('Category') }}</label>
                    <select name="category_id" id="category_id"
                            class="input">
                        @php /** @var BlogCategory $categoryItem*/use App\Models\Blog\BlogCategory; @endphp
                        <option>{{ __('SelectInList') }}</option>
                        @foreach($categoryList as $categoryItem)
                            <option value="{{ $categoryItem->id }}"
                                    @if($item->category_id === $categoryItem->id) selected @endif>{{
                                $categoryItem->id_title }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-input">
                    <label for="excerpt" class="form-input-label">{{ __('Excerpt') }}</label>
                    <textarea class="input"
                              name="excerpt"
                              id="excerpt" cols="30"
                              rows="10">{{ old('excerpt', $item->excerpt) }}</textarea>
                    @error('excerpt')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-input">
                    @if($item->exists && $item->image)
                        <div class="image-thumb">
                            <img src="{{ asset('images/blog/' . $item->image) }}" alt="">
                        </div>
                    @endif
                    <label for="image" class="form-input-label">@lang('Image')</label>
                    <input type="file" name="image" id="image" accept="image/*">
                    @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-input">
                    <input type="hidden" name="is_published" value="0">
                    <input type="checkbox" class="form-check-input" name="is_published" id="is_published"
                           value="1" @if($item->is_published) checked='checked' @endif>
                    <label for="is_published" class="form-check-label">{{ __('PublishedAt') }}</label>
                </div>
            </div>
        </div>
    </div>
</div>
