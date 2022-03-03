const tab = {
    nav: null, // holds all tabs
    txt: null, // holds all text containers
    gl: null,
    prev: null,
    next: null,
    init: function () {
        // tab.init() : init tab interface

        // Get all tabs + contents
        tab.nav = document.querySelectorAll("nav.tabs-nav .tabs-nav__item");
        tab.txt = document.querySelectorAll(".tabs-content .tabs-content__item");


        // Error checking
        if (tab.nav.length === 0 || tab.txt.length === 0 || tab.nav.length !== tab.txt.length) {
            return;
        } else {
            // Attach onclick events to navigation tabs

            for (let i = 0; i < tab.nav.length; i++) {
                tab.nav[i].dataset.pos = i;
                tab.nav[i].addEventListener("click", tab.switch);
            }

            // Default - show first tab
            tab.nav[0].classList.add("active");
            tab.txt[0].classList.add("active");
            tab.initGlider();
        }
    },
    initGlider: function () {
        tab.gl = document.querySelector(".tabs-content__item.active .glider");
        tab.prev = document.querySelector('.tabs-content__item.active .glider-prev');
        tab.next = document.querySelector('.tabs-content__item.active .glider-next');
        tab.glider();
    },

    switch: function () {
        // tab.switch() : change to another tab

        // Hide all tabs & text
        for (const t of tab.nav) {
            t.classList.remove("active");
        }
        for (const t of tab.txt) {
            t.classList.remove("active");
        }

        // Set current tab
        tab.nav[this.dataset.pos].classList.add("active");
        tab.txt[this.dataset.pos].classList.add("active");
        tab.initGlider();
        addCardTitleHeight();
    },
    glider: function () {
        if (!tab.gl) return;
        new Glider(tab.gl, {
            itemWidth: 'auto',
            duration: 0.25,
            slidesToShow: 1, // auto
            slidesToScroll: 1, // auto
            propagateEvent: false,
            draggable: false,
            arrows: {
                prev: tab.prev,
                next: tab.next,
            },
            responsive: [
                {
                    breakpoint: 700,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                    }
                },
                {
                    breakpoint: 776,
                    settings: {
                        slidesToShow: 2,
                        slidesToScroll: 2,
                    }
                },
                {
                    breakpoint: 890,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 3,
                    }
                },
                {
                    breakpoint: 960,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4,
                    }
                },
                {
                    breakpoint: 1200,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 4,
                    }
                }
            ]
        });
    }
};

window.addEventListener("load", () => {
    tab.init();
});
