module.exports = (() => {
    /* Init */
    const title = 'Сайт находится в разработке.';
    const description = 'Цены, указанные на сайте, могут быть не актуальны!';
    const cancel = 'Мне всё понятно';
    /* end */

    const pureFadeIn = (elem, display) => {
        let el = document.getElementById(elem);
        el.style.opacity = 0;
        el.style.display = display || "block";

        const fade = () => {
            let val = parseFloat(el.style.opacity);
            if (!((val += .1) > 1)) {
                el.style.opacity = val;
                requestAnimationFrame(fade);
            }
        }
        fade();
    };
    const pureFadeOut = (elem) => {
        let el = document.getElementById(elem);
        el.style.opacity = 1;

        const fade = () => {
            if ((el.style.opacity -= .1) < 0) {
                el.style.display = "none";
            } else {
                requestAnimationFrame(fade);
            }
        }
        fade();
    }
    const setCookie = (name, value, days) => {
        let expires = "";
        if (days) {
            let date = new Date();
            date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "") + expires + "; path=/";
    };
    const getCookie = (name) => {
        let nameEQ = `${name}=`;
        let ca = document.cookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i];
            while (c.charAt(0) === ' ')
                c = c.substring(1, c.length);
            if (c.indexOf(nameEQ) === 0)
                return c.substring(nameEQ.length, c.length);
        }
        return null;
    };
    const eraseCookie = (name) => {
        document.cookie = name + '=; Max-Age=-99999999;';
    };
    const pureCookieDismiss = () => {
        setCookie('pureCookieDismiss', '1', 30); // mouth
        pureFadeOut("modal-info");
    };
    const cookieConsent = () => {
        if (!getCookie('pureCookieDismiss')) {
            const modal = document.createElement('div');
            const close = document.createElement('span');
            close.className = 'cancel';
            close.innerText = cancel;

            modal.className = 'alert web-dev-info';
            modal.innerHTML = `<div class="title">${title}</div><div class="description">${description}</div>`;
            modal.appendChild(close);
            //document.body.appendChild(modal);

            close.addEventListener('click', () => {
                pureCookieDismiss(); // click close btn
            });
            document.getElementById('modal-info').append(modal);
            pureFadeIn("modal-info");
        }
    }
    window.addEventListener('load', (() => {
        setTimeout(() => {
            cookieConsent();
        }, 5000);
    }));
})();
