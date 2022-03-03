window.exports = flash = (message = '', status = '') => {
    let t = null;
    const div = document.createElement('div');
    const close = document.createElement('span');
    close.className = 'alert-info__icon-close';

    div.className = `alert alert-flash ${status}`;
    div.innerHTML = `<p>${message}</p>`;
    div.appendChild(close);
    document.body.appendChild(div);

    close.addEventListener('click', () => {
        div.remove();
    });

    (() => {
        t = setTimeout(() => {
            div.remove();
        }, 3000);
    })();

    div.addEventListener('mouseenter', () => {
        clearTimeout(t);
    });
    div.addEventListener('mouseleave', () => {
        div.remove();
    });
}
