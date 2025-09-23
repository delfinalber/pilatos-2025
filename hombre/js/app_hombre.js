import '../css/registro_hombre.css';
import '../css/app_hombre.css';

/*
 * Copyright (c) 2025 . All rights reserved.
 */
// Validación del formulario
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

  //Validación del input código estudiante, formato ingreso números y máximo 11 dígitos
  // Código estudiante: sólo dígitos, máximo 11
  const cod = document.querySelector('input[name="cod_hombre"]');
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
 // limpiar formulario cuando se envia información siempre y cuando cumpla con todas las validaciones de los input
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
// sourcery skip: avoid-using-var
    var btn = e.target.closest('.btn-editar');
    if (btn) {
      document.getElementById('edit_id_hombre').value = btn.getAttribute('data-id');
      document.getElementById('edit_cod_hombre').value = btn.getAttribute('data-cod');
      var foto1 = btn.getAttribute('data-foto-1');
      var fotoDiv1 = document.getElementById('edit_img_hombre_1');
      if(foto1){
        fotoDiv1.innerHTML = '<img src="'+foto1+'" class="img-mini mb-2" alt="Foto actual">';
      } else {
        fotoDiv1.innerHTML = '';
      }
      var foto2 = btn.getAttribute('data-foto-2');
      var fotoDiv2 = document.getElementById('edit_img_hombre_2');
      if(foto2){
        fotoDiv2.innerHTML = '<img src="'+foto2+'" class="img-mini mb-2" alt="Foto actual">';
      } else {
        fotoDiv2.innerHTML = '';
      }
      var foto3 = btn.getAttribute('data-foto-3');
      var fotoDiv3 = document.getElementById('edit_img_hombre_3');
      if(foto3){
        fotoDiv3.innerHTML = '<img src="'+foto3+'" class="img-mini mb-2" alt="Foto actual">';
      } else {
        fotoDiv3.innerHTML = '';
      }
      var foto4 = btn.getAttribute('data-foto-4');
      var fotoDiv4 = document.getElementById('edit_img_hombre_4');
      if(foto4){
        fotoDiv4.innerHTML = '<img src="'+foto4+'" class="img-mini mb-2" alt="Foto actual">';
      } else {
        fotoDiv4.innerHTML = '';
      }
      document.getElementById('edit_nom_produc_hombre').value = btn.getAttribute('data-nom');
      document.getElementById('edit_descripcion_hombre').value = btn.getAttribute('data-descripcion');
      document.getElementById('edit_precio_hombre').value = btn.getAttribute('data-precio');
      
      var modalEditar = new bootstrap.Modal(document.getElementById('modalEditar'));
      modalEditar.show();
    }
  });

  // Al enviar el formulario de edición, actualizar hombre vía AJAX y redirigir
  document.getElementById('formEditar').addEventListener('submit', function(e) {
    e.preventDefault();
// sourcery skip: avoid-using-var
    var form = e.target;
    var formData = new FormData(form);
//Envia la información el modal por metodo POST
    fetch('acciones_hombre.php', {
      method: 'POST',
      body: formData
    })
    .then(resp => resp.ok ? resp.text() : Promise.reject('Error en la actualización hombre'))
    .then(() => {
      window.location.href = 'registro_hombre.php';
    })
    .catch(err => {
      alert('No se pudo actualizar el hombre: ' + err);
    });
  });
});
// (Eliminado: El código HTML del modal debe estar en el archivo HTML, no en el archivo JS)
