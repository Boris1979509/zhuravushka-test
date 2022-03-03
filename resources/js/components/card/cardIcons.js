const cardIcons = {
    favorite: null,
    compare: null,
    card: null,
    data: {},
    id: null,
    init: () => {
        cardIcons.card = document.querySelectorAll(".card__icons");
        if (!cardIcons.card)
            return;

        Array.from(cardIcons.card, (item) => {
            cardIcons.favorite = item.querySelectorAll(".favorite");
            cardIcons.compare = item.querySelectorAll(".compare");

            Array.from(cardIcons.favorite, (item) => {
                if (item.classList.contains('favorite__active')) {
                    item.setAttribute('title', 'Убрать из избранного');
                } else {
                    item.setAttribute('title', 'Добавить в избранное');
                }
                item.onclick = function () {
                    cardIcons.switch(this);
                };
            });
            Array.from(cardIcons.compare, (item) => {
                if (item.classList.contains('compare__active')) {
                    item.setAttribute('title', 'Убрать из сравнения');
                } else {
                    item.setAttribute('title', 'Добавить в сравнение');
                }
                item.onclick = function () {
                    cardIcons.switch(this);
                };
            });
        });
    },
    switch: (elem) => {
        cardIcons.id = elem.getAttribute('data-id');

        elem.classList.toggle(`${elem.classList[0]}__active`);

        if (elem.classList.contains(`${elem.classList[0]}__active`)) {
            cardIcons.data = {
                controller: elem.classList[0],
                action: 'add',
                id: cardIcons.id
            };
        } else {
            cardIcons.data = {
                controller: elem.classList[0],
                action: 'remove',
                id: cardIcons.id
            };
        }
        cardIcons.send(cardIcons.data);
        cardIcons.init();

    },
    refresh: (data) => {
        const url = location.href;
        if (url.indexOf(data) !== -1) {
            setTimeout(() => {
                location.reload();
            }, 1500);
        }
    },
    send: (data) => {
        const url = `${location.origin}/${data.controller}/${data.id}/${data.action}`;
        xmlHttpRequest(url, {}, (data) => {
            if (data.status) {
                flash(data.message, data.status);
                cardIcons.refresh(cardIcons.data.controller);
                countIcons(data.count, cardIcons.data.controller);
            }
        });
    }
}
window.addEventListener('load', cardIcons.init);

