<section id="services">
    <div class="container">
        <div class="row">
            <div class="services">
                @if($data = $page->parent->children)
                    @include('components.leftSideBar', compact('data'))
                @endif
                <div class="cut-metal">
                    <div class="cut-metal__info-primary">
                        <p class="cut-metal__item">Наша компания осуществляет ручную резку металлопроката с помощью УШМ
                            (болгарки) - это
                            наиболее простой и
                            доступный метод, который подходит для множества видов металлопроката средних и малых
                            форм.</p>
                        <p class="cut-metal__item">Резка металла
                            болгаркой отличается более точными результатами: на кромке реза не образуются окалины и
                            окислы,
                            что
                            позволяет существенно экономить расход металлопроката за счет меньших допусков.</p>
                        <p class="cut-metal__item">Более подробную информацию Вы можете получить, позвонив по телефон +7
                            (961) 199-92-92</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

