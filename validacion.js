// validacion.js

document.addEventListener('DOMContentLoaded', function() {
    
    // 1. Vincular el evento submit a nuestra función validarForm
    const form = document.getElementById('loginForm');
    if(form){
        form.addEventListener('submit', function(e) {
            // Llamamos a la función principal
            let esValido = validarForm();
    
            // Si la función devuelve false, evitamos que se envíe el formulario
            if (!esValido) {
                e.preventDefault();
            }
        });
    }

    // 2. Vincular eventos para limpiar errores mientras escribes
    document.getElementById('userInput').addEventListener('input', function() {
        limpiarError('user');
    });

    document.getElementById('passInput').addEventListener('input', function() {
        limpiarError('pass');
    });

});

function validarForm() {
    // Obtenemos los valores
    let usuario = document.getElementById('userInput').value.trim();
    let password = document.getElementById('passInput').value.trim();

    var comprobador = true;

    // --- VALIDACIÓN USUARIO ---
    if (usuario === "") {
        marcarError('user', "er1"); 
        comprobador = false;
    }

    // --- VALIDACIÓN CONTRASEÑA ---
    if (password === "") {
        marcarError('pass', "er1");
        comprobador = false;
    } else if (password.length < 6) { // CORREGIDO: Coincide con el texto de error (6 caracteres)
        marcarError('pass', "er2");
        comprobador = false;
    }

    return comprobador;
}

function marcarError(parametro, er) {
    let inputId = parametro + 'Input'; 
    let errorId = parametro + 'Error';
    
    let inputElem = document.getElementById(inputId);
    let errorElem = document.getElementById(errorId);

    // 1. Poner el borde rojo
    inputElem.classList.add('is-invalid');

    // 2. Mostrar el texto de error
    errorElem.style.display = 'block';

    // 3. Texto del error
    if (er === "er1") {
        if(parametro === 'user') errorElem.innerText = "El nombre de usuario es obligatorio";
        if(parametro === 'pass') errorElem.innerText = "La contraseña es obligatoria";
    } else if (er === "er2") {
        if(parametro === 'pass') errorElem.innerText = "La contraseña debe tener al menos 6 caracteres";
    }
}

function limpiarError(parametro) {
    let inputId = parametro + 'Input';
    let errorId = parametro + 'Error';

    // Quitamos borde rojo
    document.getElementById(inputId).classList.remove('is-invalid');
    
    // Ocultamos el texto
    document.getElementById(errorId).style.display = 'none';
}