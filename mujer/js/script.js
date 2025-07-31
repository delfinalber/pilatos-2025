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