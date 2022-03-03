const btnQty = () => {

    const productQty = document.querySelectorAll('.addCart .product-qty');
    if (!productQty) return;
    Array.from(productQty, (item) => {
        const qtyInput = item.querySelector('.product-qty__input');
        item.addEventListener("click", (e) => {
            getQuantity(e.target, qtyInput);
        });
    });
};
window.exports = btnQty();
