window.exports = validator = (form, data = null) => {
    if (!form) return;
    const errorMessage = form.querySelectorAll('.invalid-feedback');
    errorMessage.forEach((element) => {
        element.remove();
    });
    if (data.errors) {
        const elements = (form.tagName === 'FORM') ? form.elements : form.querySelectorAll('input');
        Array.from(elements, (el) => {
            const error = document.createElement('div');
            error.className = 'invalid-feedback';
            if (data.errors[el['name']]) {
                error.innerText = data.errors[el['name']][0];
                //el.insertAdjacentHTML('afterend', `<div class="invalid-feedback">${errorItem}</div>`);
                el.closest('.form-input').appendChild(error);
            }
        });
        return false;
    }
    return true;
}
