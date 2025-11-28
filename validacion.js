// validacion.js

// Esperamos a que el DOM cargue completo
document.addEventListener('DOMContentLoaded', function() {
    
    const form = document.getElementById('loginForm');

    form.addEventListener('submit', function(e) {
        
        // Referencias a los elementos
        const userInput = document.getElementById('userInput');
        const passInput = document.getElementById('passInput');
        const userError = document.getElementById('userError');
        const passError = document.getElementById('passError');
        
        let esValido = true;

        // 1. VALIDACIÓN DE USUARIO (Que no esté vacío)
        if (userInput.value.trim() === "") {
            e.preventDefault(); // Detenemos el envío solo si hay error
            userInput.classList.add('is-invalid');
            userError.style.display = 'block';
            esValido = false;
        } else {
            userInput.classList.remove('is-invalid');
            userError.style.display = 'none';
        }

        // 2. VALIDACIÓN DE CONTRASEÑA (Mínimo 6 caracteres)
        if (passInput.value.trim().length < 6) {
            e.preventDefault(); // Detenemos el envío solo si hay error
            passInput.classList.add('is-invalid');
            passError.style.display = 'block';
            esValido = false;
        } else {
            passInput.classList.remove('is-invalid');
            passError.style.display = 'none';
        }

        // Si esValido sigue siendo true, el formulario se enviará al servidor PHP
        if (esValido) {
            // Opcional: Mostrar alerta antes de enviar
            // alert("Validación correcta. Enviando al servidor...");
        }
    });

    // Limpiar errores mientras el usuario escribe
    const inputs = document.querySelectorAll('.form-control');
    inputs.forEach(item => {
        item.addEventListener('input', function() {
            if(this.classList.contains('is-invalid')){
                this.classList.remove('is-invalid');
                // Ocultar el div de error que está justo después del input
                const errorDiv = this.nextElementSibling;
                if(errorDiv && errorDiv.classList.contains('error-text')) {
                    errorDiv.style.display = 'none';
                }
            }
        });
    });

});