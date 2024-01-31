$(document).ready(function () {
      function submitForm(event) {
          event.preventDefault();
  
   
          var name = $('#name').val();
          var email = $('#recipient_email').val();
  
          if (name.trim() === '' || email.trim() === '') {
              alert('Preencha todos os campos antes de enviar.');
              return false; 
          }
  
          var formData = new FormData(event.target);
  
          fetch(event.target.action, {
              method: 'POST',
              body: formData
          })
          .then(response => response.json())
          .then(data => {
              if (data.success) {
                  alert('Mensagem enviada com sucesso!');
              } else {
                  alert('Erro ao enviar mensagem: ' + data.message);
              }
          })
          .catch(error => {
              alert('Erro ao conectar ao servidor.');
          });
  
          return false; 
      }
  
      $('#enviarButton').click(function (event) {

          submitForm(event);
      });
  });
  