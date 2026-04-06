/**
 * 🟦 Gestion des zones
 */

'use strict';

let fv, offCanvasEl, dt; // dt = DataTable instance

document.addEventListener('DOMContentLoaded', function () {
  const formAddNewRecord = document.getElementById('positionForm');
  const offCanvasElement = document.querySelector('#add-new-record');
  const offCanvasTitle = offCanvasElement.querySelector('.offcanvas-title');

  let currentEditId = null; // Pour savoir si on est en mode édition

  // 🟠 Initialisation du DataTable
  dt = $('.datatables-basic').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    ajax: window.routes.data,
    columns: [
      { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
      { data: 'name', name: 'name' },
      { data: 'created_at', name: 'created_at' },
      { data: 'actions', name: 'actions', orderable: false, searchable: false }
    ],
    order: [[2, 'desc']]
  });

  // 🟢 Ouverture du Offcanvas pour création
  document.querySelector('.create-new').addEventListener('click', function () {
    offCanvasTitle.textContent = window.translations.add_new_position;
    formAddNewRecord.reset();
    fv.resetForm(true);
    offCanvasEl = new bootstrap.Offcanvas(offCanvasElement);
    offCanvasEl.show();
    $('#name').trigger('focus');
  });

  // 🟢 Ouverture du Offcanvas pour édition
  $(document).on('click', '.edit-btn', function () {
    currentEditId = $(this).data('id');
    const name = $(this).data('name');

    $('#position_id').val(currentEditId);
    $('#name').val(name);

    offCanvasTitle.textContent = window.translations.edit_position;

    offCanvasEl = new bootstrap.Offcanvas(offCanvasElement);
    offCanvasEl.show();
    $('#name').trigger('focus');
  });

  // ==========================
  // 🧭 Boutons
  // ==========================
  $('#cancelBtn').on('click', function () {
    offCanvasEl.hide();
  });

  // ==========================
  // 🧪 FormValidation.io
  // ==========================
  const fv = FormValidation.formValidation(formAddNewRecord, {
    fields: {
      name: {
        validators: {
          notEmpty: {
            message: window.translations.position_name_required
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

    const positionId = $('#position_id').val();
    const updating = positionId && positionId != 0 ? true : false;
    const url = updating ? window.routes.update.replace(':id', positionId) : window.routes.store;
    const method = updating ? 'PUT' : 'POST';

    $.ajax({
      url: url,
      type: method,
      data: $(formAddNewRecord).serialize(),
      success: function (response) {
        notyf.success(response.message);
        offCanvasEl.hide();
        dt.ajax.reload();
      },
      error: function (error) {
        const respJson = error.responseJSON;
        notyf.error(respJson.message);

        // Réinitialiser les erreurs
        $('#positionForm .is-invalid').removeClass('is-invalid');
        $('#positionForm .invalid-feedback').removeClass('d-block');

        if (respJson && respJson.errors) {
          const errors = respJson.errors;
          for (const key in errors) {
            const input = $('#positionForm').find('[name="' + key + '"]');
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

  // ==========================
  // 🟦 Suppression AJAX
  // ==========================
  $(document).on('click', '.btn-delete', function () {
    const id = $(this).data('id');
    const url = $(this).data('url');

    Swal.fire({
      title: window.translations.position_delete_title,
      text: window.translations.position_delete_text,
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#d33',
      cancelButtonColor: '#3085d6',
      confirmButtonText: 'Oui, supprimer',
      cancelButtonText: 'Annuler',
      showClass: {
        popup: 'animate__animated animate__shakeX'
      }
    }).then(result => {
      if (result.isConfirmed) {
        $.ajax({
          url: url,
          type: 'DELETE',
          data: {
            _token: $('meta[name="csrf-token"]').attr('content')
          },
          success: function (response) {
            Swal.fire('Supprimé !', response.message || 'La position a été supprimée.', 'success');
            $('.datatables-basic').DataTable().ajax.reload();
          },
          error: function (xhr) {
            Swal.fire('Erreur', xhr.responseJSON?.message || 'Une erreur est survenue.', 'error');
          }
        });
      }
    });
  });
});
