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
  // ✍️ Initialisation Quill
  // ==========================
  document.addEventListener('DOMContentLoaded', function () {
    const toolbar = [
      [
        {
          font: []
        },
        {
          size: []
        }
      ],
      ['bold', 'italic', 'underline', 'strike'],
      [
        {
          color: []
        },
        {
          background: []
        }
      ],
      [
        {
          header: '1'
        },
        {
          header: '2'
        },
        'blockquote'
      ],
      [
        {
          list: 'ordered'
        },
        {
          indent: '-1'
        },
        {
          indent: '+1'
        }
      ],
      ['link', 'image', 'video']
    ];
    const snowEditor = new Quill('#snow-editor', {
      bounds: '#snow-editor',
      placeholder: window.translations.org_description,
      modules: {
        syntax: true,
        toolbar: toolbar
      },
      theme: 'snow'
    });

    // À chaque changement dans l'éditeur, on met à jour l'input hidden
    snowEditor.on('text-change', function () {
      document.getElementById('descriptionOr').value = snowEditor.root.innerHTML;
    });

    // 📌 Préreplissage de Quill lors de l'édition
    const descriptionValue = document.getElementById('descriptionOr').value;
    if (descriptionValue) {
      snowEditor.clipboard.dangerouslyPasteHTML(descriptionValue);
    }
  });

  // ==========================
  // 🧭 Boutons
  // ==========================
  $('#cancelBtn').on('click', function () {
    window.location.href = window.routes.organisationsIndex;
  });

  $('#resetBtn').on('click', function () {
    $('#organisationForm')[0].reset();
    $('#organisationForm .is-invalid').removeClass('is-invalid');
    $('#organisationForm .invalid-feedback').removeClass('d-block');
    $('#picOrPreview').hide();
    $('#previewImage').attr('src', '');
  });

  // ==========================
  // Si #numberOr change et que la valeur de #whatsapp est nulle,
  // on met la valeur de #numberOr dans #whatsapp ;
  // Si #numberOr change et que la valeur de #whatsapp est egale a l'ancien #numberOr,
  // on met la nouvelle valeur de #numberOr dans #whatsapp ;
  // ==========================
  let oldNumberOr = $('#numberOr').val();
  $('#numberOr').on('input', function () {
    if ($('#whatsapp').val() === '' || $('#whatsapp').val() === oldNumberOr) {
      $('#whatsapp').val($(this).val());
    }
    oldNumberOr = $(this).val();
  });


  // ==========================
  // 🖼️ Aperçu de l'image
  // ==========================
  $('#picOr').on('change', function (e) {
    const file = e.target.files[0];
    if (file) {
      const reader = new FileReader();
      reader.onload = function (e) {
        $('#previewImage').attr('src', e.target.result);
        $('#picOrPreview').show();
        // Masquer l'image actuelle si elle existe
        $('#currentPicOr').hide();
      };
      reader.readAsDataURL(file);
    } else {
      $('#picOrPreview').hide();
      $('#previewImage').attr('src', '');
      $('#currentPicOr').show();
    }
  });

  // ==========================
  // 🧪 FormValidation.io
  // ==========================
  const form = document.getElementById('organisationForm');
  const fv = FormValidation.formValidation(form, {
    fields: {
      nameOr: {
        validators: {
          notEmpty: {
            message: window.translations.org_name_required
          }
        }
      },
      mailOr: {
        validators: {
          notEmpty: { message: window.translations.org_email_required },
          emailAddress: { message: window.translations.org_email_invalid }
        }
      },
      numberOr: {
        validators: {
          notEmpty: { message: window.translations.org_phone_required },
          digits: { message: window.translations.org_phone_invalid }
        }
      },
      town_id: {
        validators: {
          notEmpty: { message: window.translations.org_region_required }
        }
      },
      stateOr: {
        validators: {
          notEmpty: { message: window.translations.org_state_required }
        }
      },
      picOr: {
        validators: {
          notEmpty: {
            enabled: !$('#organisationForm').find('[name="organisation_id"]').val(),
            message: window.translations.org_pic_required || "L'image de l'organisation est obligatoire"
          },
          file: {
            extension: 'jpg,jpeg,png,gif,webp',
            type: 'image/jpeg,image/png,image/gif,image/webp',
            maxSize: 2097152, // 2 MB
            message:
              window.translations.org_pic_invalid ||
              'Veuillez sélectionner une image valide (JPG, PNG, GIF, WEBP, max 2MB)'
          }
        }
      },
      descriptionOr: {
        validators: {
          notEmpty: {
            message: window.translations.org_description_required
          }
        }
      },
      whatsapp: {
        validators: {
          notEmpty: {
            message: window.translations.org_whatsapp_required
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

    const organisationId = $('#organisationForm').find('[name="organisation_id"]').val();
    const url = organisationId
      ? window.routes.organisationsUpdate.replace(':id', organisationId)
      : window.routes.organisationsStore;

    // 🧾 Préparer le FormData (inclut fichiers)
    const formData = new FormData($('#organisationForm')[0]);
    if (organisationId) {
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
        window.location.href = window.routes.organisationsIndex;
      },
      error: function (error) {
        const respJson = error.responseJSON;
        notyf.error(respJson.message);

        // Réinitialiser les erreurs
        $('#organisationForm .is-invalid').removeClass('is-invalid');
        $('#organisationForm .invalid-feedback').removeClass('d-block');

        if (respJson && respJson.errors) {
          const errors = respJson.errors;
          for (const key in errors) {
            const input = $('#organisationForm').find('[name="' + key + '"]');
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
