
document.getElementById('call').addEventListener('click',event => {
    const number = document.getElementById('number').value;
    axios.post('/call/'+number)
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
