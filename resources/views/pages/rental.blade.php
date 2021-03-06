<section id="services">
    <div class="container">
        <div class="row">
            <div class="services">
                @if($data = $page->parent->children)
                    @include('components.leftSideBar', compact('data'))
                @endif
                <div class="rental-info-block">
                    <p class="rental-info-block__article">
                        Преимущества аренды техники
                    <p class="rental-info-block__description">
                        Арендуя технику, вы экономите деньги и не тратите время и ресурсы на её обслуживание. Это
                        правильный
                        шаг в
                        следующих распространенных ситуациях:
                    </p>
                    <ul class="info-list">
                        <li class="info-list__item">Отсутствие целесообразности покупки в собственность (небольшой объем
                            работ = долгий
                            срок окупаемости)
                        </li>
                        <li class="info-list__item">Отсутствие лишних финансов на приобретение техники</li>
                        <li class="info-list__item">Нет дополнительных сил на обслуживание собственного парка техники
                        </li>
                    </ul>
                    <div class="sub-text">
                        <p>Наконец, главное – вы шагаете в ногу со временем, поддерживая производительность труда на
                            должном
                            уровне.
                            Отметим, что российский рынок механизации отделочных работ начал расти ещё в 2014 году и на
                            данный момент
                            как
                            большие, так и малые строительные компании (включая частные бригады) пользуются строительной
                            техникой, а не
                            полагаются на ручной способ. Получите возможность рационально подойти к делу и выполнить
                            больше!</p>
                        <p>Стоимость аренды указана в каталоге, по каждому аппарату. Для получения консультации просто
                            позвоните нам по
                            телефону: 8-919-282-4999.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
{{--    @include('pages.hardware')--}}
</section>


