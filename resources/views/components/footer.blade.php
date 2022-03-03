<footer>
    <div class="footer">
        <div class="footer__footer-top">
            <div class="container">
                <div class="row footer-top__row">
                    <div class="footer__company">
                        <p class="footer__title">О компании</p>
                        <ul class="footer__nav">
                            @php /** @var Page $pageItem  */use App\Models\Shop\Page;@endphp
                            @foreach($pages as $key => $pageItem)
                                @if($key <= 2)
                                    <li class="footer__nav-item">
                                        <a href="{{ url('page', $pageItem->slug) }}" class="link footer__link"
                                           title="{{ $pageItem->title }}">
                                            {{ $pageItem->title }}
                                        </a>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    </div>
                    <div class="footer__catalog">
                        <p class="footer__title">Товары компании</p>
                        <ul class="footer__nav footer_columns">
                            @php /** @var ProductCategory $categoryItem */use App\Models\Shop\ProductCategory;@endphp
                            @foreach($productCategories->take(10)  as $categoryItem)
                                <li class="footer__nav-item">
                                    <a class="link footer__link" href="{{ route('category', $categoryItem->slug) }}"
                                       title="{{ $categoryItem->title }}">{{ $categoryItem->title }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="footer__pay">
                        <p class="footer__title">Мы принимаем к оплате</p>
                        <div class="pay">
                            <img src="{{ asset('images/pay/all-pay.png') }}" alt="all-pay" class="pay__icon">
                        </div>
                    </div>
                    <div class="footer__contacts">
                        <p class="footer__title">Мы в социальных сетях</p>
                        <div class="row footer__social">
                            <a class="footer__social-link  footer__social-link--facebook" href="#" target="_blank"
                               rel="nofollow">
                                <img src="{{ asset('images/social-icons/facebook.png') }}" alt="facebook">
                            </a>
                            <a class="footer__social-link  footer__social-link--instagram" href="#" target="_blank"
                               rel="nofollow">
                                <img src="{{ asset('images/social-icons/instagram.png') }}" alt="instagram">
                            </a>
                            <a class="footer__social-link  footer__social-link--ok" href="#" target="_blank"
                               rel="nofollow">
                                <img src="{{ asset('images/social-icons/ok.png') }}" alt="ok">
                            </a>
                            <a class="footer__social-link  footer__social-link--vk" href="#" target="_blank"
                               rel="nofollow">
                                <img src="{{ asset('images/social-icons/vk.png') }}" alt="vk">
                            </a>
                        </div>
                        <div class="footer__phone">
                            <div id="footer-online-phone">+7 (961) 199-92-92</div>
                            <span>Многоканальная линия</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer__logo-wrap">
                <div class="container">
                    <div class="row logo-wrap__row">
                        <a href="/" class="footer__logo" title="">
                            <img src="{{ asset('images/logo/logo-footer.svg') }}" alt="" class="footer__logo-img">
                        </a>
                        <a href="https://webstyle.top/" class="webstyle__link footer__text" target="_blank"
                           rel="noopener" title="Создание сайтов Белгород">
                            <img src="{{ asset('images/logo/webstyle-logo.svg') }}" alt="webstyle-logo"
                                 class="webstyle__img">
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer__copyright container">
            <p>2007 - 2020 ООО «Журавушка»<br>Продолжая работу с сайтом, вы даете согласие на использование сайтом
                cookies
                и обработку персональных данных в целях функционирования сайта, проведения ретаргетинга,
                статистических
                исследований, улучшения сервиса и предоставления релевантной рекламной информации на основе ваших
                предпочтений и интересов.</p>
        </div>
    </div>
</footer>
@include('components.footer-navbar-mobile')
