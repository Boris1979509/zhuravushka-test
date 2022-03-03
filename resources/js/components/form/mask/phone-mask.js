module.exports = ((maskedInputs) => {
    if (!maskedInputs)
        return;
    const maskInput = (input) => {
        const mask = "+7 (000) 000-00-00";
        const value = input.value;
        const literalPattern = /[0\*]/;
        const numberPattern = /[0-9]/;
        let newValue = "";
        try {
            const maskLength = mask.length;
            let valueIndex = 0;
            let maskIndex = 0;

            for (; maskIndex < maskLength;) {
                if (maskIndex >= value.length) break;

                if (mask[maskIndex] === "0" && value[valueIndex].match(numberPattern) === null) break;

                // Found a literal
                while (mask[maskIndex].match(literalPattern) === null) {
                    if (value[valueIndex] === mask[maskIndex]) break;
                    newValue += mask[maskIndex++];
                }
                newValue += value[valueIndex++];
                maskIndex++;
            }

            input.value = newValue;
        } catch (e) {
            console.log(e);
        }
    }

    Array.from(maskedInputs, (item) => {
        item.addEventListener('input', () => {
            maskInput(item)
        });
    });
})(document.querySelectorAll('.mask-input'));
