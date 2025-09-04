import '../css/registro_estudiante.css';
import '../css/app.css';

/*
 * Copyright (c) 2025 . All rights reserved.
 */

(() => {
  'use strict';
  // Bootstrap validation
  const forms = document.querySelectorAll('.needs-validation');
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', e => {
      if (!form.checkValidity()) { e.preventDefault(); e.stopPropagation(); }
      form.classList.add('was-validated');
    });
  });

  // Tel input: solo dígitos y máximo 12, min 7
  const tel = document.querySelector('input[name="tel_estudiante"]');
  tel?.addEventListener('input', () => {
    tel.value = tel.value.replace(/\D/g,'').slice(0,12);
    tel.setCustomValidity(tel.value.length<7 ? 'Min. 7 dígitos' : '');
  });

  // Email input: validación básica
  const email = document.querySelector('input[name="email_estudiante"]');
  email?.addEventListener('input', () => {
    email.setCustomValidity(email.validity.typeMismatch ? 'Formato de email inválido' : '');
  });
  
  // Código estudiante: sólo dígitos, máximo 11
  const cod = document.querySelector('input[name="cod_estudiante"]');
  cod?.addEventListener('input', () => {
    cod.value = cod.value.replace(/\D/g,'').slice(0,11);
    cod.setCustomValidity(cod.value?'':'Requerido');
  });

  // Confirmar eliminación
  document.addEventListener('click', e => {
    const a = e.target.closest('[data-confirm]');
    if (a && !confirm(a.getAttribute('data-confirm')))
      e.preventDefault();
  });

  // Limpiar form tras éxito ?ok=1
  const params = new URLSearchParams(location.search);
  if (params.get('ok') === '1') {
    const f = document.getElementById('formCrear');
    f?.reset(); f?.classList.remove('was-validated');
    history.replaceState({}, '', location.pathname);
  }
})();
// Carga información en el modal editar
document.addEventListener('DOMContentLoaded', function() {
  // Delegación para soportar recarga dinámica de la tabla
  document.body.addEventListener('click', function(e) {
    var btn = e.target.closest('.btn-editar');
    if (btn) {
      document.getElementById('edit_id_estudiante').value = btn.getAttribute('data-id');
      document.getElementById('edit_cod_estudiante').value = btn.getAttribute('data-cod');
      document.getElementById('edit_nom_estudiante').value = btn.getAttribute('data-nom');
      document.getElementById('edit_email_estudiante').value = btn.getAttribute('data-email');
      document.getElementById('edit_tel_estudiante').value = btn.getAttribute('data-tel');
      var foto = btn.getAttribute('data-foto');
      var fotoDiv = document.getElementById('edit_foto_actual');
      if(foto){
        fotoDiv.innerHTML = '<img src="'+foto+'" class="img-mini mb-2" alt="Foto actual">';
      } else {
        fotoDiv.innerHTML = '';
      }
      var modalEditar = new bootstrap.Modal(document.getElementById('modalEditar'));
      modalEditar.show();
    }
  });

  // Al enviar el formulario de edición, actualizar estudiante vía AJAX y redirigir
  document.getElementById('formEditar').addEventListener('submit', function(e) {
    e.preventDefault();
    var form = e.target;
    var formData = new FormData(form);

    fetch('acciones.php', {
      method: 'POST',
      body: formData
    })
    .then(resp => resp.ok ? resp.text() : Promise.reject('Error en la actualización'))
    .then(() => {
      window.location.href = 'registro_estudiante.php';
    })
    .catch(err => {
      alert('No se pudo actualizar el estudiante: ' + err);
    });
  });
});
// (Eliminado: El código HTML del modal debe estar en el archivo HTML, no en el archivo JS)
