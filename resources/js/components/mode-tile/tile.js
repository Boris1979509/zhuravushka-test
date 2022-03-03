module.exports = (() => {
    const handleClick = (e, list) => {
        list.forEach(node => {
            node.classList.remove('active');
        });
        e.currentTarget.classList.add('active');
    }
    const cartContainer = document.querySelector('.card-container');
    const icons = document.querySelectorAll('.sorting-icons > div');
    if (!icons) return;
    icons.forEach((item) => {
        item.addEventListener('click', (e) => {
            handleClick(e, icons);
            cartContainer.classList.toggle('simple-card-mode');
        });
    });
})();
