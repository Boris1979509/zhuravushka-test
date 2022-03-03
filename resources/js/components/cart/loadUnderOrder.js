window.exports = (loadUnderOrder = () => {
    const cartWrap = document.querySelector('.cart-wrap > .cart');
    if (!cartWrap) return;
    const goodsOrder = cartWrap.querySelectorAll('.qty-goods__order');
    if (goodsOrder.length > 0) {
        document.querySelector('.primary-info').removeAttribute('hidden');
    } else {
        document.querySelector('.primary-info').setAttribute('hidden', 'hidden');
    }
})();
