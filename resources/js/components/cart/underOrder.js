window.exports = (underOrder = (data, form) => {
    const qtyGoods = form.closest('.count').nextElementSibling;
    const underOrder = qtyGoods.closest('.cart__count').nextElementSibling;

    if (data) {

        if (data.underOrder) {
            qtyGoods.innerHTML = data.underOrder;
        }
        if (data.underOrderTotal) {
            underOrder.querySelector('.under-order').innerHTML = data.underOrderTotal;
        }
    } else {
        qtyGoods.innerHTML = '';
        underOrder.querySelector('.under-order').innerHTML = '';
    }
    loadUnderOrder();
});
