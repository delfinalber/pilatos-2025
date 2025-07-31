/*
 * Copyright (c) 2025 . All rights reserved.
 */

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
                window.location.replace("registro.php");
            } else {
                errorMsg.classList.remove('d-none');
                errorMsg.textContent = data.error || "Credenciales incorrectas.";
            }
        }).catch(err => {
            errorMsg.classList.remove('d-none');
            errorMsg.textContent = "Error de red, intente nuevamente.";
        });
    });
});
