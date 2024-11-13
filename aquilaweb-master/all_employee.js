document.querySelector(".submitBtn").addEventListener("click", function(e) {
    e.preventDefault();
    
    let formData = new FormData(document.querySelector("#myForm"));
    
    fetch("add_employee.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert(data.message);
            location.reload(); // Reloads the page to show the updated employee list
        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error('Error:', error));
});
