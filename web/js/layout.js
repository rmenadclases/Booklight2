//collapse js
document.getElementById('recover').onclick = function(){
    document.getElementById('recover-form').classList.toggle('d-none');
};

//Sign up verification
    user = document.getElementById('validationCustomUsername');
    user.addEventListener('blur', verifyUser, false);
    email = document.getElementById('validationCustomEmail');
    email.addEventListener('blur', verifyEmail, false);
    var emailRecover = document.getElementById('validationCustomRecoverPassword');
    emailRecover.addEventListener('blur', verifyRecovery, false);

    //validation - boot
    (() => {
    'use strict'
    const forms = document.querySelectorAll('.needs-validation')
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
    function verifyUser(){
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.exists) {
                    document.getElementsByClassName('invalid-username')[0].classList.remove('d-none');
                    user.setCustomValidity("Invalid field.");
                } else {
                    document.getElementsByClassName('invalid-username')[0].classList.add('d-none');
                    user.setCustomValidity("");
                }
            }
        };
        xhr.open("GET", "index.php?ctl=existeUsuario&user=" + encodeURIComponent(user.value), true);
        xhr.send();
    }
    function verifyEmail(){
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.exists) {
                    document.getElementsByClassName('invalid-email')[0].classList.remove('d-none');
                    email.setCustomValidity("Invalid field.");
                } else {
                    document.getElementsByClassName('invalid-email')[0].classList.add('d-none');
                    email.setCustomValidity("");
                }
            }
        };
        xhr.open("GET", "index.php?ctl=existeEmail&email=" + encodeURIComponent(email.value), true);
        xhr.send();
    }

    function verifyRecovery(){
        var xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.exists) {
                    document.getElementsByClassName('invalid-recovery')[0].classList.add('d-none');
                    emailRecover.setCustomValidity("");
                } else {
                    document.getElementsByClassName('invalid-recovery')[0].classList.remove('d-none');
                    emailRecover.setCustomValidity("Invalid field.");
                }
            }
        };
        xhr.open("GET", "index.php?ctl=existeEmail&email=" + encodeURIComponent(emailRecover.value), true);
        xhr.send();
    }

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
