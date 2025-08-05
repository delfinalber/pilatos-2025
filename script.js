/*
 * Copyright (c) 2025 . All rights reserved.
 */

document.addEventListener('DOMContentLoaded', function () {
    // Seleccionamos el modal por su ID
    const loginModal = document.getElementById('loginModal');

    // Escuchamos el evento 'show.bs.modal', que es disparado por Bootstrap cuando el modal está a punto de mostrarse
    loginModal.addEventListener('show.bs.modal', function () {
        // Seleccionamos el contenedor del contenido del modal
        const modalContent = loginModal.querySelector('.modal-content');
        // Añadimos las clases de Animate.css para el efecto "tada"
        modalContent.classList.add('animate__animated', 'animate__tada');
    });

    // Opcional: Limpiar las clases de animación cuando el modal se cierra para que se repita cada vez.
    loginModal.addEventListener('hidden.bs.modal', function () {
        const modalContent = loginModal.querySelector('.modal-content');
        modalContent.classList.remove('animate__animated', 'animate__tada');
    });
});

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('loginForm');
    const usuarioInput = form.usuario;
    const passwordInput = form.password;
    const errorMsg = document.getElementById('msg-error');

    // Validación frontend
    form.addEventListener('submit', function (e) {
        e.preventDefault();

        // Validaciones HTML5
        if (!usuarioInput.checkValidity()) {
            usuarioInput.classList.add('is-invalid');
            return;
        } else {
            usuarioInput.classList.remove('is-invalid');
        }

        if (!passwordInput.checkValidity()) {
            passwordInput.classList.add('is-invalid');
            return;
        } else {
            passwordInput.classList.remove('is-invalid');
        }

        // Ajax para login
        const formData = new FormData(form);

        fetch('login.php', {
            method: 'POST',
            body: formData,
            headers: { 'Accept': 'application/json' }
        })
        .then(resp => resp.json())
        .then(data => {
            if (data.ok) {
                // Limpiar cache antes de redirigir
                if ('caches' in window) {
                    caches.keys().then(function(names) {
                        for (let name of names) caches.delete(name);
                    });
                }
                // Redirigir a registro.php
                window.location.replace("./estudiante/registro_estudiante.php");
            } else {
                // Mostrar ventana emergente personalizada
                mostrarVentanaEmergente("Usuario o contraseña incorrectos.");
                if ('caches' in window) {
                    caches.keys().then(function(names) {
                        for (let name of names) caches.delete(name);
                    });
                }
                // Redirigir después de 2 segundos
                setTimeout(() => {
                    window.location.replace("index.html");
                }, 2000);
            }
        }).catch(() => {
            errorMsg.classList.remove('d-none');
            errorMsg.textContent = "Error de red, intente nuevamente.";
        });
    });

    // Función para mostrar ventana emergente con colores personalizados
    function mostrarVentanaEmergente(mensaje) {
        // Colores de ejemplo basados en la imagen "tecnico.jpg"
        // Puedes ajustar estos valores según los colores reales de la imagen
        // Obtener los colores del modal para usarlos en la ventana emergente
        const modalContent = document.querySelector('#loginModal .modal-content');
        const style = getComputedStyle(modalContent);
        const colorFondo = style.backgroundColor;
        const colorBorde = style.borderColor || "#dee2e6";
        const colorTexto = style.color || "#212529";

        // Crear el overlay
        const overlay = document.createElement('div');
        overlay.style.position = 'fixed';
        overlay.style.top = 0;
        overlay.style.left = 0;
        overlay.style.width = '100vw';
        overlay.style.height = '100vh';
        overlay.style.background = 'rgba(0,0,0,0.4)';
        overlay.style.zIndex = 9999;
        overlay.style.display = 'flex';
        overlay.style.alignItems = 'center';
        overlay.style.justifyContent = 'center';

        // Crear la ventana emergente
        const popup = document.createElement('div');
        popup.style.background = colorFondo;
        popup.style.border = `4px solid ${colorBorde}`;
        popup.style.color = colorTexto;
        popup.style.padding = '32px 40px';
        popup.style.borderRadius = '16px';
        popup.style.boxShadow = '0 8px 32px rgba(0,0,0,0.3)';
        popup.style.fontSize = '1.3rem';
        popup.style.fontWeight = 'bold';
        popup.style.textAlign = 'center';
        popup.textContent = mensaje;

        overlay.appendChild(popup);
        document.body.appendChild(overlay);

        // Remover la ventana después de 2 segundos
        setTimeout(() => {
            document.body.removeChild(overlay);
        }, 2000);
    }
});

