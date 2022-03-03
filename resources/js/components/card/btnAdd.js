window.exports = (btnAdd = () => {
    const forms = document.querySelectorAll("form.addCart");
    if (!forms) return;
    Array.from(forms, (item) => {
        const formElements = item.elements;
        Array.from(formElements, (el) => {
            if (el.nodeName === "BUTTON") {
                el.addEventListener("click", function (e) {
                    e.preventDefault();
                    el.classList.add('btn-hide');
                    const preload = new GetPreload({
                        'wrap': el,
                        'class': 'lds-dual-ring'
                    });
                    xmlHttpRequest(item.action, {inc: "++"}, (data) => {
                        refreshCart(data.cartItemTotalSum, data.cartTotalSum, data.cartCount);
                        preload.remove();
                        flash(data.dataMsg.message, data.dataMsg.status);
                    });

                })
            } else {
                return null;
            }
        });
    });
})();
