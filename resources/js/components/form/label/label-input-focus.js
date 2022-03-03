module.exports = ((input) => {
    if (!input)
        return;

    Array.from(input, (item) => {
        if(item.value){
            item.setAttribute('data-empty', 'false');
        }
        item.addEventListener('input', (e) => {
            e.currentTarget.setAttribute('data-empty', !e.currentTarget.value);
        });
    });
})(document.querySelectorAll('input'));
