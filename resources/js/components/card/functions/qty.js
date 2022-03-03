window.exports = getQuantity = (e, input) => {
    // Quantity items Products
    const isNumber = (val) => {
        val = parseInt(val);
        return ((typeof val === "number") && (!isNaN(val)) && (val !== 0)) ? val : 1;
    }

    ((e, input) => {
        const form = input.closest('form');
        const btn = form.querySelector('button.btn-add');
        const cart = form.closest('.cart__product');
        if (e.classList.contains("product-qty__plus")) {
            const preload = GetPreload({
                'wrap': input,
                'class': 'lds-dual-ring'
            });

            input.value = isNumber(input.value) + 1; // add to cart axios
            xmlHttpRequest(form.action, {inc: "++"}, (data) => {
                refreshCart(data.cartItemTotalSum, data.cartTotalSum, data.cartCount, cart);
                preload.remove();
                flash(data.dataMsg.message, data.dataMsg.status);
                if (data.dataMsg.status === 'info') {
                    underOrder(data.dataMsg, form);
                } else {
                    underOrder(null, form);
                }
            });
        } else if (e.classList.contains("product-qty__minus")) {

            if (input.value > 1) {
                const preload = GetPreload({
                    'wrap': input,
                    'class': 'lds-dual-ring'
                });
                input.value = isNumber(input.value) - 1; // add to cart axios
                xmlHttpRequest(form.action, {inc: "--"}, (data) => {
                    refreshCart(data.cartItemTotalSum, data.cartTotalSum, data.cartCount, cart);
                    preload.remove();
                    flash(data.dataMsg.message, data.dataMsg.status);
                    if (data.dataMsg.status === 'info') {
                        underOrder(data.dataMsg, form);
                    } else {
                        underOrder(null, form);
                    }
                });
            } else {
                if (!btn)
                    return;
                btn.classList.remove('btn-hide');
            }
        }
        input.addEventListener("input", function (e) {
            input.value = isNumber(input.value);
            const preload = GetPreload({
                'wrap': input,
                'class': 'lds-dual-ring'
            });
            xmlHttpRequest(form.action, input.value, (data) => {
                preload.remove();
            }); // add to cart axios

        });
    })(e, input);
}
