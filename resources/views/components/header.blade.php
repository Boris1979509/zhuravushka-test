<header>
    <div class="header">
        <div class="top-bar"><!-- Start top-bar -->
            <div class="container">
                <div class="row top-bar__row">
                    <!---->
                    <nav>
                        <ul class="top-bar__nav">
                            @php /** @var Page $pageItem  */use App\Models\Shop\Page;@endphp
                            @foreach($pages as $key => $pageItem)
                                @if($key <= 2)
                                    <li class="top-bar__nav-item">
                                        <a href="{{ url('page', $pageItem->slug) }}" class="link top-bar__nav-link"
                                           title="{{ $pageItem->title }}">
                                            {{ $pageItem->title }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                            <li class="top-bar__nav-item">
                                <a href="{{ route('blog') }}" class="link top-bar__nav-link"
                                   title="{{ __('Sovety') }}">{{ __('Sovety') }}</a>
                            </li>
                        </ul>
                    </nav>
                    <!---->
                    <div class="top-bar__phone">
                        <span class="top-bar__icon-phone">+7 (961) 199-92-92 (Пн - Сб: 8:30 - 17:30)</span>
                    </div>
                    <div class="top-bar__phone mobile">
                        <span class="top-bar__icon-phone">+7 (961) 199-92-92</span>
                    </div>
                    <div class="top-bar__right">
                        @include('components.login-top-bar')
                    </div>
                </div>
            </div>
        </div><!-- End top-bar -->
        <!-- Start sub-header -->
        <div class="sub-header">
            <div class="container">
                <div class="row sub-header__row">

                    <!--logo-container-->
                    <div class="sub-header__logo-container row">
                        <a href="{{ route('home') }}" class="sub-header__logo-img" title="{{ __('Home') }}"></a>
                        <button class="btn btn-active catalog-spoiler-btn"></button>
                    </div>
                    <!--end logo-container-->

                    <!-- Start search header -->
                    <div class="sub-header__search">
                        <form action="{{ route('search') }}" class="b-search">
                            <input type="search" name="search" class="input b-search__input"
                                   placeholder="Найдется все! И не только" autocomplete="off">
                            <span class="b-search__icon loupe" onclick="
                                       document.querySelector('.b-search').submit();"></span>
                        </form>
                        <div class="sub-header__container">
                            <form action="{{ route('search') }}" class="b-search-mobile">
                                <input type="search" name="search" class="b-search-mobile__input" autocomplete="off">
                                <div class="b-search-mobile__bg"></div>
                                <button type="reset" class="b-search-mobile__btn"></button>
                            </form>
                        </div>
                        <div class="search-dropdown" hidden>
                            <img src="{{ asset('images/triangle.png') }}" class="search-triangle">
                            <span class="search-title">{{ __('SearchResult') }}</span>
                            <div class="search-result"></div>
                        </div>
                    </div>
                    @include('components.sub-header-navbar')
                </div>
                @if(url()->current() !== route('login'))
                    <div class="sub-header__login" hidden>
                        @include('auth.login')
                    </div>
                @endif
                <div id="catalogMenu" hidden>
                    @include('components.barMenu')
                </div>
            </div>
        </div>
        <!-- End sub-header -->
    </div>
</header>
