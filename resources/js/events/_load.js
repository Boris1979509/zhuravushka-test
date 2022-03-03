const onloadMyFunction = (LazyLoad) => {
    addCardTitleHeight();
    loadUnderOrder();
    lazyLoad();
};

window.exports = window.addEventListener('load', onloadMyFunction);
