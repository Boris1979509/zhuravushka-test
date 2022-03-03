window.exports = refreshCart = (price, total, badgeCartCount, cart = null) => {
    if (cart) {
        cart.querySelector('.cart__sum-price').firstChild.data = `${price} `;
    }
    const CartTotalPrice = document.querySelector('.cart-total-wrap__total-price');
    if (CartTotalPrice) {
        CartTotalPrice.firstChild.data = `${total} `;
    }
    const cartPanel = document.querySelectorAll('.sub-header__right');
    Array.from(cartPanel, (item) => {
        if (undefined === total) {
            item.querySelector('.cart__icon').classList.remove('active');
            item.querySelector('.sub-header__label.cart-total-sum').innerHTML = '0 <span class="rub">₽</span>';
            item.querySelector('.cart__qty').innerHTML = '0';
        } else {
            item.querySelector('.cart__icon').classList.add('active');
            item.querySelector('.sub-header__label.cart-total-sum').innerHTML = `${total} <span class="rub">₽</span>`;
            item.querySelector('.cart__qty').innerHTML = badgeCartCount;
        }
    });
}
