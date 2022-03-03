window.exports = countIcons = (data, className) => {
    const count = document.querySelectorAll(`.${className}__qty`);
    Array.from(count, (item) => {
        const countParentActive = item.closest('.icon');
        if (data === 0) {
            countParentActive.classList.remove('active');
        } else {
            countParentActive.classList.add('active');
        }
        item.innerHTML = data;
    });
};
