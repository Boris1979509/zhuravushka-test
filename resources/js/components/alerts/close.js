window.exports = close = () => {
    const close = document.querySelector('.alert .close');
    if (!close) return;
    close.addEventListener('click', () => {
        close.closest('.alert').remove();
    });
}
