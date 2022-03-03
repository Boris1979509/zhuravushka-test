window.exports = xmlHttpRequest = (action, dataForm, callback) => {
    callback = callback || ((data) => {
    });
    Axios.post(action, dataForm).then((response) => {
        callback(response.data);
    }).catch(function (error) {
        if (!error.response) return;
        if (error.response.status === 422) { // Validate
            callback(error.response.data);
        }
    });
};
