document.addEventListener('DOMContentLoaded', function() {

    const credenciales = {
        email : '',
        password : ''
    }

    //Elemento de la interfaz para la funcionalidad
    const inputEmail = document.querySelector('#email');
    const inputPassword = document.querySelector('#password');
    const form = document.querySelector('#form');
    const btnLogin = document.querySelector('.my-form__button');

    //eventos para cada input
    inputEmail.addEventListener('input', validar);
    inputPassword.addEventListener('input', validar);

    comprobarCredenciales();

    function validar(e){

        if (e.target.value.trim() === '') {
            mostrarAlerta(`El campo ${e.target.id} es obligatorio`, e.target.closest('.text-field'));
            credenciales[e.target.name] = '';
            comprobarCredenciales();
            return;
        }

        if (e.target.id === 'email' && !validarEmail(e.target.value)) {
            mostrarAlerta(`El email no es valido`, e.target.closest('.text-field'));
            credenciales[e.target.name] = '';
            comprobarCredenciales();
            return;
        }

        limpiarAlerta(e.target.closest('.text-field'));

        //Se asigna los valores al arreglo credenciales
        credenciales[e.target.name] = e.target.value.trim().toUpperCase();
        comprobarCredenciales();
    }

    function mostrarAlerta(mensaje, referencia) {

        limpiarAlerta(referencia);

        const errorLabel = document.createElement('P');
        errorLabel.textContent = mensaje;
        errorLabel.classList.add('label-alerta');
        
        //inyectar debajo del label
        referencia.after(errorLabel);
    }

    function limpiarAlerta(referencia) {
        const alerta = referencia.nextElementSibling;
        //apuntamos fuera de la referencia , ya que el hijo esta fuera

        if (alerta && alerta.classList.contains('label-alerta')) {
            alerta.remove();
        }
    }

    function validarEmail(email) {
        const regex =  /^\w+([.-_+]?\w+)*@\w+([.-]?\w+)*(\.\w{2,10})+$/;
        const resultado = regex.test(email);
        return resultado;
    }

    function comprobarCredenciales() {
        if (Object.values(credenciales).includes('')) {
            btnLogin.classList.add('my-form__button__disable');
            btnLogin.disabled = true;
            return
        }

        btnLogin.classList.remove('my-form__button__disable');
        btnLogin.disabled = false
    }
});

