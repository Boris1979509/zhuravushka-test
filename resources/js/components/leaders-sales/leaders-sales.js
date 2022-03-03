((elem) => {
    if (!elem)
        return;
    const glider = new Glider(elem, {
        itemWidth: 'auto',
        slidesToShow: 1, // auto
        slidesToScroll: 1, // auto
        propagateEvent: false,
        draggable: false,
        duration: 0.25,
        arrows: {
            prev: '#glider-prev-leaders-sales',
            next: '#glider-next-leaders-sales'
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
                    slidesToShow: 5,
                    slidesToScroll: 5,
                }
            }

        ]
    });
})(document.getElementById('glider-leader-sales'));

