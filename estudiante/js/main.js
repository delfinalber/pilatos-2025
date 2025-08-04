/*
 * Copyright (c) 2025 . All rights reserved.
 */

document.addEventListener("DOMContentLoaded", function() {
    
    // Lógica para la página de registro de estudiantes
    const registroForm = document.getElementById('registroForm');
    if (registroForm) {
        registroForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const mensajeDiv = document.getElementById('mensaje');

            // Simple validación de cliente
            if (!formData.get('cod_estudiante') || !formData.get('nom_estudiante') || !formData.get('tel_estudiante') || !formData.get('email_estudiante') || !formData.get('foto_estudiante').name) {
                mostrarMensaje('Todos los campos son obligatorios.', 'alert-danger', mensajeDiv);
                return;
            }

            fetch('../php/registrar_estudiante.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    mostrarMensaje(data.message, 'alert-success', mensajeDiv);
                    registroForm.reset(); // Limpia el formulario
                    setTimeout(() => {
                        window.location.href = '../estudiante.html';
                    }, 2000);
                } else {
                    mostrarMensaje(data.message, 'alert-danger', mensajeDiv);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mostrarMensaje('Error en la comunicación con el servidor.', 'alert-danger', mensajeDiv);
            });
        });
    }

    // Lógica para la página de gestión de estudiantes
    if (document.getElementById('tablaEstudiantes')) {
        cargarEstudiantes();

        // Buscador
        const searchForm = document.getElementById('searchForm');
        searchForm.addEventListener('submit', function(e) {
            e.preventDefault();
            const searchInput = document.getElementById('searchInput').value;
            if (searchInput.trim() === '') {
                cargarEstudiantes();
            } else {
                cargarEstudiantes(`../php/buscar_estudiante.php?cod_estudiante=${searchInput}`);
            }
        });
    }

    // Lógica del modal de edición
    const editModal = document.getElementById('editModal');
    if (editModal) {
        editModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const id = button.getAttribute('data-id');
            
            fetch(`../php/obtener_estudiante.php?id=${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('edit_id_estudiante').value = data.estudiante.id_estudiante;
                        document.getElementById('edit_cod_estudiante').value = data.estudiante.cod_estudiante;
                        document.getElementById('edit_nom_estudiante').value = data.estudiante.nom_estudiante;
                        document.getElementById('edit_tel_estudiante').value = data.estudiante.tel_estudiante;
                        document.getElementById('edit_email_estudiante').value = data.estudiante.email_estudiante;
                        const fotoActual = document.getElementById('foto_actual');
                        fotoActual.src = data.estudiante.foto_estudiante ? data.estudiante.foto_estudiante : '../../img/fotos/default.png';
                    }
                });
        });

        // Guardar cambios del modal
        const saveChangesBtn = document.getElementById('saveChangesBtn');
        saveChangesBtn.addEventListener('click', function() {
            const editForm = document.getElementById('editForm');
            const formData = new FormData(editForm);

            // Confirmación antes de actualizar
            if (confirm('¿Estás seguro de que deseas guardar los cambios?')) {
                fetch('../php/editar_estudiante.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    const bootstrapModal = bootstrap.Modal.getInstance(editModal);
                    bootstrapModal.hide();
                    mostrarMensaje(data.message, data.success ? 'alert-success' : 'alert-danger', document.getElementById('mensaje-gestion'));
                    if (data.success) {
                        cargarEstudiantes();
                    }
                });
            }
        });
    }
});

function cargarEstudiantes(url = '../php/listar_estudiantes.php') {
    fetch(url)
        .then(response => response.json())
        .then(data => {
            const tabla = document.getElementById('tablaEstudiantes');
            tabla.innerHTML = '';
            if (data.length > 0) {
                data.forEach(estudiante => {
                    tabla.innerHTML += `
                        <tr>
                            <td><img src="${estudiante.foto_estudiante || '../../img/fotos/default.png'}" alt="Foto" width="50" class="img-thumbnail"></td>
                            <td>${estudiante.cod_estudiante}</td>
                            <td>${estudiante.nom_estudiante}</td>
                            <td>${estudiante.email_estudiante}</td>
                            <td>${estudiante.tel_estudiante}</td>
                            <td>
                                <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editModal" data-id="${estudiante.id_estudiante}">Editar</button>
                                <button class="btn btn-sm btn-danger" onclick="eliminarEstudiante(${estudiante.id_estudiante})">Eliminar</button>
                            </td>
                        </tr>
                    `;
                });
            } else {
                tabla.innerHTML = '<tr><td colspan="6" class="text-center">No se encontraron estudiantes.</td></tr>';
            }
        });
}

function eliminarEstudiante(id) {
    if (confirm('¿Estás seguro de que deseas eliminar a este estudiante? Esta acción no se puede deshacer.')) {
        fetch('../php/eliminar_estudiante.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ id_estudiante: id })
        })
        .then(response => response.json())
        .then(data => {
            mostrarMensaje(data.message, data.success ? 'alert-success' : 'alert-danger', document.getElementById('mensaje-gestion'));
            if(data.success) {
                cargarEstudiantes();
            }
        });
    }
}

function mostrarMensaje(mensaje, tipo, elemento) {
    elemento.className = `alert ${tipo}`;
    elemento.textContent = mensaje;
    elemento.classList.remove('d-none');
    setTimeout(() => {
        elemento.classList.add('d-none');
    }, 4000);
}