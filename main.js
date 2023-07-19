// main.js
document.getElementById('pushButton').addEventListener('click', function () {
    fetch('push.php')
        .then(response => response.text())
        .then(result => {
            document.getElementById('mensaje').innerText = result;
        })
        .catch(error => {
            document.getElementById('mensaje').innerText = 'Error: ' + error;
        });
});
