module.exports = ((register) => {
    if (!register) return;
    const message = document.querySelector('.message');

    const clearAllFormInputs = () => {
        const form = document.querySelectorAll('form');
        form.forEach((item) => {
            item.reset();
        })
    }

    register.addEventListener('submit', function (e) {
        e.preventDefault();
        const data = {};
        Array.from(register.elements, item => {
            data[item.name] = item.value;
        });
        xmlHttpRequest(register.action, data, (data) => {
            if (validator(register, data)) {
                if (data.error) {
                    window.scrollTo({top: 0, behavior: 'smooth'});
                    message.innerHTML = data.error;
                } else {
                    location.href = data.url;
                }
                // message.innerHTML = data.success || data.error;
                // window.scrollTo({top: 0, behavior: 'smooth'});
                // const loginContainer = document.querySelector('.sub-header__login');
                // loginContainer.removeAttribute('hidden');
                // clearAllFormInputs();
            }
        });
    });
})(document.querySelector('#register-form'));
