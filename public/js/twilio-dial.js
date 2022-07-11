var twilio = {
    sid: null
}
document.getElementById('call').addEventListener('click', event => {
    const number = document.getElementById('number').value;
    axios.post('/call/' + number)
        .then(function (response) {
            console.log(response.data);
            twilio.sid = response.data.properties.sid;
        })
        .catch(function (error) {
            console.warn(error);
        })
        .then(function () {
            // always executed
        });
});

document.getElementById('end-call').addEventListener('click', event => {

    axios.post('/endcall/' + twilio.sid)
        .then(function (response) {
            // handle success
            console.log(response);
        })
        .catch(function (error) {
            // handle error
            console.log(error);
        })
        .then(function () {
            // always executed
        });
});

document.getElementById('music-start').addEventListener('click', event => {

    axios.post('/music-start/' + twilio.sid)
        .then(function (response) {
            // handle success
            console.log(response);
        })
        .catch(function (error) {
            // handle error
            console.log(error);
        })
        .then(function () {
            // always executed
        });
});
