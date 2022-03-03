window.exports = (() => {
    const formOrder = document.querySelector('#order-form1');
    if (!formOrder) return;
    const dateDeliveryOptionItem = document.querySelectorAll('.date-delivery__options > .date-delivery__options-item');
    const datepickerInput = document.querySelector('input[name=delivery_date]');

    const message = document.querySelector('.message');
    const datepicker = new Datepicker(datepickerInput, {
        language: 'ru'
    });
    /**
     * Set Date
     * @param day
     */
    const getDate = (day) => {
        let date = new Date();
        date.setDate(date.getDate() + day);
        datepicker.setDate(date, {render: true});
    }
    const handleClick = (e, list) => {
        list.forEach(node => {
            node.classList.remove('active');

        });
        if (e.currentTarget.classList.contains('tomorrow')) {
            getDate(1);
        }
        if (e.currentTarget.classList.contains('day-after-tomorrow')) {
            getDate(2);
        }
        e.currentTarget.classList.add('active');

    }
    dateDeliveryOptionItem.forEach((item) => {
        item.addEventListener('click', (e) => {
            handleClick(e, dateDeliveryOptionItem);
        });
    });
    formOrder.addEventListener('submit', function (e) {
        e.preventDefault();
        let data = {};
        Array.from(formOrder.elements, item => {
            data[item.name] = item.value;
        });
        // console.log(data);
        xmlHttpRequest(formOrder.action, data, (data) => {
            if (validator(formOrder, data)) {
                if (data.error) {
                    message.innerHTML = data.error;
                } else {
                    if(data.route){
                        window.location = data.route;
                    }
                }
            }
        });
    });
})();
