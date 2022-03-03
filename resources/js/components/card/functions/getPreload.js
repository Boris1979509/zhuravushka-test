/**
 *
 * @param setting
 * @constructor
 */
window.exports = GetPreload = (setting) => {
    if (setting.wrap === null) {
        return;
    }
    this.preloadElement = document.createElement("div");
    this.preloadElement.classList.add(setting.class);
    const parentDiv = setting.wrap.parentNode;
    parentDiv.insertBefore(this.preloadElement, setting.wrap);

    this.remove = () => {
        this.preloadElement.classList.add('hide');
        setTimeout(() => {
            this.preloadElement.remove();
        }, 300);

    }
    return this;
}
