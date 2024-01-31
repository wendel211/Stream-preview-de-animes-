function uploadFile() {
    var formData = new FormData(document.getElementById('uploadForm'));

    fetch('uploads.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        document.getElementById('status').innerHTML = data.message;
    })
    .catch(error => {
        console.error('Erro ao enviar arquivo:', error);
        document.getElementById('status').innerHTML = 'Erro ao conectar ao servidor.';
    });
}
