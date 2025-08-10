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

document.addEventListener('DOMContentLoaded', function() {
                  var modalEditar = new bootstrap.Modal(document.getElementById('modalEditar'));
                  document.querySelectorAll('.btn-editar').forEach(function(btn) {
                    btn.addEventListener('click', function() {
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
                      modalEditar.show();
                    });
                  });

                  // Al enviar el formulario de edición, limpiar cache e historial y redirigir
                  document.getElementById('formEditar').addEventListener('submit', function() {
                    // Permitir el envío normal del formulario (POST a acciones.php)
                    // Cuando acciones.php termine, debe hacer:
                    // header("Location: registro_estudiante.php");
                    // exit;
                    // Para limpiar el historial y cache al regresar, puedes usar este script en registro_estudiante.php:
                    if (window.performance && window.performance.getEntriesByType) {
                      const navEntries = window.performance.getEntriesByType('navigation');
                      if (navEntries.length > 0 && navEntries[0].type === 'back_forward') {
                        window.location.reload(true);
                      }
                    }
                  });
                });
