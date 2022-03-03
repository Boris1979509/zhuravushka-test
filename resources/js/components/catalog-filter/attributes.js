module.exports = (() => {
    const catalogSubsection = document.querySelector('.catalog__subsection');
    if (!catalogSubsection) return;
    const catalogAttributes = catalogSubsection.querySelectorAll('.catalog__attributes-title');

    catalogAttributes.forEach((item) => {
        item.addEventListener('click', () => {
            item.classList.toggle('active');
            item.nextElementSibling.firstElementChild.toggleAttribute('hidden');
        });
    });

    const checkboxes = catalogSubsection.querySelectorAll('input[type="checkbox"]');
    const form = catalogSubsection.querySelector('form');

    /* Send show filter */
    const show_filter = () => {
        form.submit();
    }
    /**
     *
     * @param element
     * @param wrap
     * @returns {string}
     */
    const position = (element, wrap) => {
        const h = element.clientHeight;
        return (((element.getBoundingClientRect().top) - (wrap.getBoundingClientRect().top)) - (h / 2)) + "px";
    }
    /**
     *
     * @param element
     */
    const createElement = (element) => {
        if (window.matchMedia('(min-width: 767px)').matches) {

            const wrap = element.closest('.catalog__attributes__parent');

            const a = document.createElement('a');
            /* create element */
            a.setAttribute('class', 'filter-label');
            a.setAttribute('href', 'javascript:void()');
            a.innerHTML = 'Показать';

            setTimeout(() => {
                a.style.top = position(element.closest('.form-input'), wrap);
                wrap.appendChild(a);
                a.addEventListener('click', show_filter);
            }, 500);
            setTimeout(() => {
                a.remove();
            }, 5000);
        }
    }

    checkboxes.forEach((item) => {
        item.addEventListener('change', (event) => {
            if (event.target.checked) {
                createElement(event.target);
            }
        });
    });

})();
