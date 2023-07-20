document.getElementById("repoForm").addEventListener("submit", function(event) {
    event.preventDefault();
    
    let formData = new FormData(event.target);
    fetch("script.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        document.getElementById("responseMessage").innerText = result;
    })
    .catch(error => {
        console.error(error);
    });
});
