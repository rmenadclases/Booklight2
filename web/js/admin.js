// Espera a que se cargue completamente la ventana
window.onload = function () {
    // Selecciona todos los botones de eliminar
    var deleteButtons = document.querySelectorAll('.delete-button');
    // Agrega un event listener a cada botón de eliminar
    deleteButtons.forEach(function (button) {
        button.addEventListener('click', deleteElement,false);
    });
    //Grafica
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var librosPopulares = JSON.parse(xhr.responseText);

            var titulos = librosPopulares.map(function (libro) {
                return libro.titulo;
            });

            var likes = librosPopulares.map(function (libro) {
                return libro.likes;
            });

        //petición ajax

        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: titulos, // Usamos los títulos de los libros populares como etiquetas
                datasets: [{
                    label: 'books with the most likes',
                    data: likes, // Usamos los likes de los libros populares como datos
                    backgroundColor: '#29303F',
                    borderColor: '##29303F',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        min: 0,
                        ticks: {
                            stepSize: 1 //especifica el incremento deseado en el eje y, el de los likes
                        }
                    }
                }
            }
        });
    }
};
    xhr.open("GET", "index.php?ctl=librosPopulares", true);
    xhr.send();
};
function deleteElement(){
    this.parentElement.parentElement.parentElement.style="display:none;";
}
//Form validation
(() => {
    'use strict'

    // Fetch all the forms we want to apply custom Bootstrap validation styles to
    const forms = document.querySelectorAll('.needs-validation')

    // Loop over them and prevent submission
    Array.from(forms).forEach(form => {
      form.addEventListener('submit', event => {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })
  })()

//Reset validation
bReset = document.querySelectorAll('[type=reset]');
for (button of bReset) {
    button.onclick = resetValidation;
}
function resetValidation(){
    const forms = document.querySelectorAll('.was-validated')
    Array.from(forms).forEach(form => {
        form.classList.remove('was-validated');
    })
    document.getElementsByClassName('invalid-username')[0].classList.add('d-none');
    user.setCustomValidity("");
    document.getElementsByClassName('invalid-email')[0].classList.add('d-none');
    user.setCustomValidity("");
}