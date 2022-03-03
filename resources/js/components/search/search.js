module.exports = (() => {
    const input = document.querySelector(".b-search-mobile__input");
    const searchBtn = document.querySelector(".b-search-mobile__btn");
    const subHeader = document.querySelector(".sub-header");

    const adapter = () => {
        const width = subHeader.clientWidth - 30;
        const height = subHeader.clientHeight;
        if (input.classList.contains('square')) {
            input.style = `width: ${width}px`;
            input.nextElementSibling.style = `width: ${width}px; height: ${height}px`;
        } else {
            input.removeAttribute('style');
            setTimeout(() => {
                input.nextElementSibling.removeAttribute('style');
            }, 1500);
        }
    }
    const expand = () => {
        searchBtn.classList.toggle("close");
        input.classList.toggle("square");
        adapter();
    };

    searchBtn.addEventListener("click", expand);
    window.addEventListener("resize", adapter);
})();
