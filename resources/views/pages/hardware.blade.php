<div class="hardware">
    <div class="container">
        <div class="row">
            <p class="hardware__article">Оборудование</p>
            <table class="hardware__table">
                <tbody>
                @for($i = 0; $i <= 20; $i++)
                    @if($i === 0)
                        <tr class="hardware__item">
                            @continue
                            @endif
                            <td>
                                <img src="{{ asset('images/hardware.png') }}" alt="Оборудование" class="hardware__img">
                                <div class="hardware__description">Аппарат CTL 26 E AC пылеудаляющий и Эксцентриковая
                                </div>
                            </td>
                            @if($i % 5 === 0) </tr>
                        @if($i !== 20)
                            <tr class="hardware__item"> @endif
                    @endif
                @endfor
                </tbody>
            </table>
        </div>
    </div>
</div>
