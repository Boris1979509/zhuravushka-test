(() => {
    const accordions = document.querySelectorAll(".accordion__button-item");
    if (!accordions) return;
    accordions.forEach((item) => {
        const content = item.nextElementSibling;
        if (item.classList.contains('active')) {
            content.style.maxHeight = content.scrollHeight + "px";
        }
        item.addEventListener('click', () => {
            item.classList.toggle('active');
            if (content.style.maxHeight) {
                content.style.maxHeight = null;
            } else {
                content.style.maxHeight = content.scrollHeight + "px";
            }
        });
    });
})();
