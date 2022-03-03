window.exports = (function () {
    const subHeader = document.querySelector('.sub-header');
    let a = document.querySelector('.sticky-bar'), b = null, P = subHeader.clientHeight, mq = "1200px";
    if (!a) return;
    window.addEventListener('scroll', scroll, false);
    document.body.addEventListener('scroll', scroll, false);
    document.body.addEventListener('resize', scroll, false);

    function scroll() {
        if (window.matchMedia(`(max-width: ${mq})`).matches) return;
        if (b == null) {
            let Sa = getComputedStyle(a, ''), s = '';
            for (let i = 0; i < Sa.length; i++) {
                if (Sa[i].indexOf('overflow') === 0 || Sa[i].indexOf('padding') === 0 || Sa[i].indexOf('border') === 0 || Sa[i].indexOf('outline') === 0 || Sa[i].indexOf('box-shadow') === 0 || Sa[i].indexOf('background') === 0) {
                    s += Sa[i] + ': ' + Sa.getPropertyValue(Sa[i]) + '; '
                }
            }
            b = document.createElement('div');
            b.style.cssText = s + ' box-sizing: border-box; width: ' + a.offsetWidth + 'px;';
            a.insertBefore(b, a.firstChild);
            let l = a.childNodes.length;
            for (let i = 1; i < l; i++) {
                b.appendChild(a.childNodes[1]);
            }
            a.style.height = b.getBoundingClientRect().height + 'px';
            a.style.padding = '0';
            a.style.border = '0';
        }
        let Ra = a.getBoundingClientRect(),
            R = Math.round(Ra.top + b.getBoundingClientRect().height - document.querySelector('.sticky-content').getBoundingClientRect().bottom);  // селектор блока, при достижении нижнего края которого нужно открепить прилипающий элемент
        if ((Ra.top - P) <= 0 && window.matchMedia(`(min-width: ${mq})`).matches) {
            if ((Ra.top - P) <= R) {
                b.className = 'stop';
                b.style.top = -R + 'px';
            } else {
                b.className = 'sticky';
                b.style.top = P + 'px';
            }
        } else {
            b.className = '';
            b.style.top = '';
        }
        window.addEventListener('resize', function () {
            if (window.matchMedia(`(min-width: ${mq})`).matches) {
                a.children[0].style.width = getComputedStyle(a, '').width;
            } else {
                a.removeAttribute('style');
                a.children[0].style = "";
                b.className = '';
            }
        }, false);
    }
})();
