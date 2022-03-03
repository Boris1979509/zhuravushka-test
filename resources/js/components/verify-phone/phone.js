module.exports = ((mainBlock) => {
    if (!mainBlock) return;
    /***************************************************/
    const requestBlock = mainBlock.querySelector('.request-block');
    const requestBlockBtn = requestBlock.querySelector("button#request-btn"); // btn request
    const requestPhoneInput = requestBlock.querySelector("input[name=phone]"); // input phone
    const verifyBlock = mainBlock.querySelector(".verify-block");

    const requestAction = '/phone';
    const verifyAction = '/verify';
    /**/
    let time = 60;
    let timer = null;
    const tokenLength = 4;
    /*********************************/
    /**
     * Attr set disabled readonly
     */
    const setAttributeRequest = () => {
        requestBlockBtn.setAttribute('disabled', 'disabled');
        requestPhoneInput.setAttribute('readonly', 'readonly');
    }
    /**
     * Attr remove disabled readonly
     */
    const removeAttributeRequest = () => {
        requestBlockBtn.removeAttribute('disabled');
        requestPhoneInput.removeAttribute('readonly');
    }
    /**
     * Message
     * @param message
     * @param status
     */
    const message = (message, status = 'invalid-feedback') => {
        verifyBlock.innerHTML = `<div class="${status}">${message}</div>`;
    }
    /**
     * Clear timer
     */
    const clearTimer = () => {
        clearInterval(timer);
    }
    /**
     * Start timer
     * @param t
     */
    const startTimer = (t) => {
        const timerShow = verifyBlock.querySelector('.verify-block-timer');
        timer = setInterval(() => {
            if (t <= 0) {
                verifyBlock.innerHTML = '';
                clearTimer();
                removeAttributeRequest();
            } else {
                timerShow.innerHTML = `<span class="confirm-timer">Повторная отправка будет доступна через ${t} сек.</span>`;
                setAttributeRequest();
            }
            --t;
        }, 1000)
    }
    /**
     * Verify
     * @param tokenClient
     */
    const verify = (tokenClient) => {
        const data = {
            tokenClient: tokenClient,
        }
        xmlHttpRequest(verifyAction, data, (data) => {
            /* VERIFY FALSE */
            if (!data.verified) {
                message(data.message);
                removeAttributeRequest();
            } else {
                /* VERIFY TRUE */
                verifyBlock.innerHTML = '';
                message(data.message, 'success-feedback');
                setAttributeRequest();
            }
            clearTimer();
        });
    }

    /**
     * Input confirm token
     */
    const getVerifyInput = () => {
        const verifyBlockInput = verifyBlock.querySelector('input[name=verifyToken]');
        verifyBlockInput.focus();
        if (verifyBlockInput) {
            const array = [];
            verifyBlockInput.addEventListener('input', (e) => {
                if (e.data) {
                    array.push(e.data);
                }
                if (array.length === tokenLength) {
                    const tokenClient = array.join('');
                    verify(tokenClient);
                }
            });
            verifyBlockInput.addEventListener('paste', (event) => {
                const tokenClient = (event.clipboardData || window.clipboardData).getData('text');
                verify(tokenClient);
            });
        }
    }
    /**
     * Send request phone
     * @param data
     */
    const dataSend = (data) => {
        if (!data) return;
        xmlHttpRequest(requestAction, data, (data) => {
            validator(mainBlock, data);
            if (data.hasOwnProperty('resultVerify')) {
                const attempts = data.resultVerify.attempts;
                if (attempts || !data.resultVerify.status) {
                    message(data.resultVerify.message);
                }
            }
            if (data.view && !data.resultVerify.attempts) {
                verifyBlock.innerHTML = data.view;
                startTimer(time);
                getVerifyInput();
            }
        });

    }

    /**
     * Send
     */
    requestBlockBtn.addEventListener('click', (e) => {
        e.preventDefault();
        const data = {
            phone: requestPhoneInput.value,
        }
        dataSend(data);
    });
})(document.querySelector('.phone-verify'));
