document.querySelector('.contact_form').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('http://localhost:8000/Contacts.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.text())
    .then(data => {
        if (data.trim() === 'success') {
            alert("Submitted successfully!");
            this.reset();
        } else {
            alert("Error: " + data);
        }
    });
});