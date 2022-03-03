(() => {
    /**
     * @returns {number}
     */
    const getDistance = (el) => {
        return el.offsetTop; // height 33px top-bar
    }

    const subHeader = document.querySelector('.sub-header');
    const topBar = document.querySelector('.top-bar');
    const logoContainer = document.querySelector('.sub-header__logo-container');
    const catalogMenu = document.querySelector('.page-top-grid .catalog');
    const catalogMenuButton = document.getElementById('catalogMenu');
    const catalogSpoiler = document.querySelector('.catalog-spoiler-btn');
    const catalog = catalogMenuButton.querySelector('.catalog');
    const stickPoint = getDistance(subHeader);

    let stuck = false; //

    catalogSpoiler.addEventListener('click', () => {
        catalogMenuButton.toggleAttribute('hidden');
        if (!catalogMenuButton.hasAttribute('hidden')) {
            if (catalog.clientHeight > document.documentElement.clientHeight) {
                catalog.style = `height: ${document.documentElement.clientHeight - catalog.getBoundingClientRect().top + document.body.scrollTop}px; overflow-y: scroll;`
            } else {
                catalog.removeAttribute('style');
            }
        }
    });

    /**
     * Stick menu large button
     * @param item
     */
    const menuLargeButton = (item) => {

        if (item <= 0) {
            logoContainer.classList.add('large-btn');
        } else {
            logoContainer.classList.remove('large-btn');
            catalogMenuButton.setAttribute('hidden', 'hidden');
        }
    }

    const getStuck = () => {
        const distance = getDistance(subHeader) - window.pageYOffset;
        const offset = window.pageYOffset;
        // if isset menu
        const distanceMenu = (catalogMenu) ? (catalogMenu.offsetHeight - stickPoint) - window.pageYOffset : null;

        if ((distance <= 0) && !stuck) {
            if (!distanceMenu) {
                logoContainer.classList.add('large-btn');
            }
            subHeader.setAttribute("style", `position: fixed; top: 0;`);
            stuck = true;
        } else if (stuck && (offset <= stickPoint)) {
            subHeader.style.position = 'static';
            stuck = false;
        }
        if (distanceMenu)
            menuLargeButton(distanceMenu);
    }
    // Events
    window.onload = getStuck;
    window.onscroll = getStuck;
    /**
     *
     * @param event
     * @param elem
     * @param clickElem
     */
    const toggleShow = (event, elem, clickElem) => {
        if (!elem && clickElem) return;
        if (elem.contains(event) || clickElem.contains(event)) {
            return;
        }
        elem.setAttribute('hidden', 'hidden');
    }
    document.addEventListener('click', (event) => {
        toggleShow(event.target, catalogMenuButton, catalogSpoiler);
    });

})();
