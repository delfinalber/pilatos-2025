/*
 * Copyright (c) 2025 . All rights reserved.
 */

// estudiante.js
document.addEventListener('DOMContentLoaded', function () {

    // Selecciona todos los formularios de registro y edición
    const formularios = document.querySelectorAll('form');

    formularios.forEach(form => {
        form.addEventListener('submit', function(e) {
            // Previene el doble envío
            if (form.classList.contains('enviado')) {
                e.preventDefault();
                return false;
            }
            // Validaciones globales
            let valido = true;
            let mensajes = [];

            // Documento de identidad: solo números, longitud 6-12
            const cod = form.querySelector('input[name="cod_estudiante"]');
            if (cod && !/^\d{6,12}$/.test(cod.value.trim())) {
                valido = false;
                mensajes.push('El documento debe tener entre 6 y 12 números.');
                cod.classList.add('is-invalid');
            } else if (cod) {
                cod.classList.remove('is-invalid');
            }

            // Nombre: solo letras y espacios mínimo 3 caracteres
            const nombre = form.querySelector('input[name="nom_estudiante"]');
            if (nombre && !/^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]{3,50}$/.test(nombre.value.trim())) {
                valido = false;
                mensajes.push('El nombre solo debe contener letras y tener al menos 3 letras.');
                nombre.classList.add('is-invalid');
            } else if (nombre) {
                nombre.classList.remove('is-invalid');
            }

            // Teléfono: solo números, mínimo 7 a 13 dígitos
            const tel = form.querySelector('input[name="tel_estudiante"]');
            if (tel && !/^\d{7,13}$/.test(tel.value.trim())) {
                valido = false;
                mensajes.push('El teléfono debe tener entre 7 y 13 números.');
                tel.classList.add('is-invalid');
            } else if (tel) {
                tel.classList.remove('is-invalid');
            }

            // Email: formato email básico
            const email = form.querySelector('input[name="email_estudiante"]');
            if (email && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email.value.trim())) {
                valido = false;
                mensajes.push('Ingrese un email válido.');
                email.classList.add('is-invalid');
            } else if (email) {
                email.classList.remove('is-invalid');
            }

            // Foto: opcional solo en edición, obligatoria en registro, valida tipo y tamaño (máx 2MB)
            const fotoInput = form.querySelector('input[name="foto_estudiante"]');
            if (fotoInput) {
                const esRegistro = form.getAttribute('action') && form.getAttribute('action').includes('guardar_estudiante');
                if (esRegistro && !fotoInput.value) {
                    valido = false;
                    mensajes.push('Debe seleccionar una foto.')};
                const esEdicion = form.getAttribute('action') && form.getAttribute('action').includes('edi_estudiantes');
                if (esEdicion && fotoInput.value) {
                    const foto = fotoInput.files[0];
                    if (foto.size > 2 * 1024 * 1024) {
                        valido = false;
                        mensajes.push('La foto debe tener un peso máximo de 2MB.');
                        fotoInput.classList.add('is-invalid');
                    } else {
                        fotoInput.classList.remove('is-invalid');
                    }
                    if (foto.type !== 'image/jpeg' && foto.type !== 'image/png') {
                        valido = false;
                        mensajes.push('La foto debe ser en formato JPEG o PNG.');
                        fotoInput.classList.add('is-invalid');
                    } else {
                        fotoInput.classList.remove('is-invalid');
                    }
                }
            }

            if (!valido) {
                e.preventDefault();
                const mensajeError = document.getElementById('mensaje-gestion');
                mensajeError.className = 'alert alert-danger';
                mensajeError.innerHTML = mensajes.join('<br>');
                mensajeError.classList.remove('d-none');
                form.classList.add('enviado');
                return false;
            }   
        });
    });                                                     
});
            errorMsg.classList.remove('d-none');
            console.error('Error de conexión o respuesta no válida');
            if ('caches' in window) {
                caches.keys().then(function(names) {
                    for (let name of names) caches.delete(name);
                }); 
            }
