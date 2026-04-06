/**
 * Organisation Form Script
 */
'use strict';

(function () {
  // ==========================
  // 📌 Initialisation Select2
  // ==========================
  const select2 = $('.select2');
  if (select2.length) {
    select2.each(function () {
      const $this = $(this);
      $this.wrap('<div class="position-relative"></div>').select2({
        dropdownParent: $this.parent(),
        placeholder: $this.data('placeholder'),
        closeOnSelect: true,
        language: {
          noResults: function () {
            return window.translations.no_results;
          }
        }
      });
    });
  }

  // ==========================
  // 🧭 Boutons
  // ==========================
  $('#cancelBtn').on('click', function () {
    window.location.href = window.routes.membersIndex;
  });

  $('#resetBtn').on('click', function () {
    $('#memberForm')[0].reset();
    $('#memberForm .is-invalid').removeClass('is-invalid');
    $('#memberForm .invalid-feedback').removeClass('d-block');
    $('#photoPreview').hide();
    $('#previewPhoto').attr('src', '');
  });

  // ==========================
  // 🖼️ Aperçu de l'image
  // ==========================
  $('#photo').on('change', function (e) {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        $('#previewPhoto').attr('src', e.target.result);
        $('#photoPreview').show();
        // Masquer l'image actuelle si elle existe
        $('#currentPhoto').hide();
      };
      reader.readAsDataURL(file);
    } else {
      $('#photoPreview').hide();
      $('#previewPhoto').attr('src', '');
      $('#currentPhoto').show();
    }
  });

  // ==========================
  // 🧪 FormValidation.io
  // ==========================
  const form = document.getElementById('memberForm');
  const fv = FormValidation.formValidation(form, {
    fields: {
      name: {
        validators: {
          notEmpty: {
            message: window.translations.member_name_required
          }
        }
      },
      email: {
        validators: {
          notEmpty: { message: window.translations.member_email_required },
          emailAddress: { message: window.translations.member_email_invalid }
        }
      },
      phone: {
        validators: {
          notEmpty: { message: window.translations.member_phone_required },
          digits: { message: window.translations.member_phone_invalid }
        }
      },
      sex: {
        validators: {
          notEmpty: { message: window.translations.member_sex_required }
        }
      },
      job: {
        validators: {
          notEmpty: { message: window.translations.member_job_required }
        }
      },
      photo: {
        validators: {
          notEmpty: {
            enabled: !$('#memberForm').find('[name="member_id"]').val(),
            message: window.translations.member_photo_required || "L'image du membre est obligatoire"
          },
          file: {
            extension: 'jpg,jpeg,png,gif,webp',
            type: 'image/jpeg,image/png,image/gif,image/webp',
            maxSize: 2097152, // 2 MB
            message:
              window.translations.member_photo_invalid ||
              'Veuillez sélectionner une image valide (JPG, PNG, GIF, WEBP, max 2MB)'
          }
        }
      },
      birth: {
        validators: {
          notEmpty: {
            message: window.translations.member_birth_required
          }
        }
      }
    },
    plugins: {
      trigger: new FormValidation.plugins.Trigger(),
      bootstrap5: new FormValidation.plugins.Bootstrap5({
        rowSelector: '.mb-6',
        eleInvalidClass: 'is-invalid',
        eleValidClass: 'is-valid'
      }),
      submitButton: new FormValidation.plugins.SubmitButton(),
      autoFocus: new FormValidation.plugins.AutoFocus()
    }
  });

  // ==========================
  // 🟦 Soumission AJAX
  // ==========================
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });
  fv.on('core.form.valid', function () {
    const originalText = $('#submitBtn').html();
    $('#submitBtn')
      .prop('disabled', true)
      .html('<span class="spinner-border spinner-border-sm me-2"></span>' + window.translations.submitting);

    const memberId = $('#memberForm').find('[name="member_id"]').val();
    const url = memberId
      ? window.routes.membersUpdate.replace(':id', memberId)
      : window.routes.membersStore;

    // 🧾 Préparer le FormData (inclut fichiers)
    const formData = new FormData($('#memberForm')[0]);
    if (memberId) {
      formData.append('_method', 'PUT');
    }

    $.ajax({
      url: url,
      type: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        notyf.success(response.message);
        window.location.href = window.routes.membersIndex;
      },
      error: function (error) {
        const respJson = error.responseJSON;
        notyf.error(respJson.message);

        // Réinitialiser les erreurs
        $('#memberForm .is-invalid').removeClass('is-invalid');
        $('#memberForm .invalid-feedback').removeClass('d-block');

        if (respJson && respJson.errors) {
          const errors = respJson.errors;
          for (const key in errors) {
            const input = $('#memberForm').find('[name="' + key + '"]');
            input.addClass('is-invalid');
            input.next('.invalid-feedback').addClass('d-block').text(errors[key][0]);
          }
        }
      },
      complete: function () {
        $('#submitBtn').prop('disabled', false).html(originalText);
      }
    });
    setTimeout(function () {
      $('#submitBtn').prop('disabled', false).html(originalText);
    }, 500);
  });

  // Déclencheur de soumission classique
  $('#submitBtn').on('click', function () {
    fv.validate();
  });
})();
