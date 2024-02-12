/*MOSTRAR Y OCULTAR INPUT REPLY ACTUALIZADO*/
var arrayElementos = document.getElementsByClassName('reply-btn');

for (let index = 0; index < arrayElementos.length; index++) {
    arrayElementos[index].addEventListener("click", () => {
        mostrarOcultar(arrayElementos[index], index);
    });
}
function mostrarOcultar(element, index) {
    document.getElementsByClassName('reply-input')[index].classList.toggle('d-none');
    element.classList.toggle('d-none');
}