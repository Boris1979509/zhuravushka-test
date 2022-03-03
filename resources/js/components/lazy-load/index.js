const LazyLoad = require('vanilla-lazyload');

window.exports = lazyLoad = () => {
    /* Create preloader */
    const createPreloader = () => {
        const preload = document.createElement('div');
        preload.className = 'preload';
        return preload;
    };
    /* Loading ... */
    const callback_loading = (element) => {
        const parent = element.closest('.container-preload-lazy-load');
        parent.append(createPreloader());
    };
    /* Loaded! */
    const callback_loaded = (element) => {
        const parent = element.closest('.container-preload-lazy-load');
        const preload = parent.querySelector('.preload');
        if (preload) {
            setTimeout(() => {
                preload.remove();
            }, 1000);
        }
    };
    new LazyLoad({
        threshold: 0,
        elements_selector: '.lazy-load',
        //callback_loading: callback_loading,
        callback_loaded: callback_loaded
    });
};
