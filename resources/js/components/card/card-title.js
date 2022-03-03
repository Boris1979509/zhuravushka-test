window.exports = addCardTitleHeight = () => {
    const title = document.querySelectorAll('.card__title');
    if (!title) return;
    /**
     *
     * @param elem
     * @returns {number}
     */
    const getHeight = (elem) => {
        return parseInt(window.getComputedStyle(elem).minHeight);
    }

    title.forEach((item) => {
        const height = getHeight(item);
        if (item.clientHeight > height) {
            item.style = `height: ${height}px`;
            item.firstElementChild.classList.add('active');
        }
    });
}
