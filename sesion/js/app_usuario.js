(() => {
  'use strict';

  // Validación Bootstrap
  const forms = document.querySelectorAll('.needs-validation');
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', e => {
      if (!form.checkValidity()) { e.preventDefault(); e.stopPropagation(); }
      form.classList.add('was-validated');
    });
  });

  // Campo contraseña: sin validaciones específicas

  // Campo email: validación nativa (formulario de creación)
  const emailInput = document.querySelector('#formCrear input[name="usuario"]');
  emailInput?.addEventListener('input', () => {
    emailInput.setCustomValidity(emailInput.validity.typeMismatch ? 'Formato de email inválido' : '');
  });

  // Campo de búsqueda: validación básica
  const searchInput = document.querySelector('input[name="buscar"]');
  searchInput?.addEventListener('input', () => {
    // Permitir búsqueda parcial de emails
    searchInput.setCustomValidity('');
  });

  // Confirmar eliminación (enlaces con data-confirm)
  document.addEventListener('click', e => {
    const a = e.target.closest('[data-confirm]');
    if (a) {
      const ok = confirm(a.getAttribute('data-confirm'));
      if (!ok) e.preventDefault();
    }
  });

  // Limpiar formulario tras éxito ?ok=1
  const params = new URLSearchParams(location.search);
  if (params.get('ok') === '1') {
    const f = document.getElementById('formCrear');
    f?.reset(); f?.classList.remove('was-validated');
    history.replaceState({}, '', location.pathname);
  }
})();
