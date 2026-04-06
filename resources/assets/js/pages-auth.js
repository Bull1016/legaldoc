/**
 *  Pages Authentication - Custom AJAX Submit
 */
'use strict';

document.addEventListener('DOMContentLoaded', function () {
  (() => {
    const formAuthentication = document.querySelector('#formAuthentication');

    if (formAuthentication && typeof FormValidation !== 'undefined') {
      const fv = FormValidation.formValidation(formAuthentication, {
        fields: {
          email: {
            validators: {
              notEmpty: {
                message: 'Entrer votre mail.'
              },
              emailAddress: {
                message: 'Veuillez entrer un mail valide.'
              }
            }
          },
          password: {
            validators: {
              notEmpty: {
                message: 'Entrer votre mot de passe.'
              },
              stringLength: {
                min: 6,
                message: 'Le mot de passe doit contenir six caractères minimum.'
              }
            }
          }
        },
        plugins: {
          trigger: new FormValidation.plugins.Trigger(),
          bootstrap5: new FormValidation.plugins.Bootstrap5({
            eleInvalidClass: '',
            eleValidClass: '',
            rowSelector: '.form-control-validation'
          }),
          submitButton: new FormValidation.plugins.SubmitButton(),
          autoFocus: new FormValidation.plugins.AutoFocus()
        },
        init: instance => {
          instance.on('plugins.message.placed', e => {
            if (e.element.parentElement.classList.contains('input-group')) {
              e.element.parentElement.insertAdjacentElement('afterend', e.messageElement);
            }
          });
        }
      });

      // ⚠️ bien dans le même bloc que fv
      fv.on('core.form.valid', function () {
        const formData = new FormData(formAuthentication);
        const submitButton = formAuthentication.querySelector('[type="submit"]');
        const btnText = submitButton.textContent;

        submitButton.disabled = true;
        submitButton.textContent = 'Connexion... ';

        fetch(formAuthentication.action, {
          method: formAuthentication.method,
          body: formData,
          headers: {
            'X-Requested-With': 'XMLHttpRequest',
            Accept: 'application/json'
          }
        })
          .then(response => response.json().then(data => ({ status: response.status, body: data })))
          .then(({ status, body }) => {
            if (body.notyf) {
              if (body.notyf.type === 'success') notyf.success(body.notyf.message);
              if (body.notyf.type === 'error') notyf.error(body.notyf.message);
            }

            if (status === 200 && body.redirect) {
              window.location.href = body.redirect;
            }
          })
          .catch(error => {
            notyf.error(error.notyf.message);
          })
          .finally(() => {
            submitButton.disabled = false;
            submitButton.textContent = btnText;
          });
      });
    }

    // Formatage champs numériques
    const numeralMaskElements = document.querySelectorAll('.numeral-mask');
    const formatNumeral = value => value.replace(/\D/g, '');
    if (numeralMaskElements.length > 0) {
      numeralMaskElements.forEach(numeralMaskEl => {
        numeralMaskEl.addEventListener('input', event => {
          numeralMaskEl.value = formatNumeral(event.target.value);
        });
      });
    }
  })();
});
