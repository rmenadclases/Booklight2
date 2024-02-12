
/*MOSTRAR Y OCULTAR TEXTO DE DESC*/
    btnRead = document.getElementsByClassName('read-more')[0];
    btnRead.addEventListener('click',showText,false);
    function showText(){
        event.preventDefault();
        document.getElementsByClassName('desc')[0].classList.toggle('hide-text');
        document.getElementsByClassName('desc')[0].classList.toggle('show-text');
        document.getElementsByClassName('desc')[0].classList.toggle('overflow-hidden');
        if(btnRead.textContent == 'Read more'){
            btnRead.textContent = 'Close';
        }else
            btnRead.textContent = 'Read more';
    }
/*MOSTRAR Y OCULTAR INPUT REPLY*/
    document.getElementsByClassName('reply-btn')[0].onclick = function(){
        document.getElementsByClassName('reply-input')[0].classList.toggle('d-none');
        this.classList.toggle('d-none');
    }
/*BOOTSTRAP TOOLTIPS*/
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))