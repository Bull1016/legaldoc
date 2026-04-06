/**
 * 🟦 Gestion des zones
 */

'use strict';

let fv, offCanvasEl, dt; // dt = DataTable instance

document.addEventListener('DOMContentLoaded', function () {
  const formAddNewRecord = document.getElementById('userForm');
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
      { data: 'name_role', name: 'name_role' },
      { data: 'email', name: 'email' },
      { data: 'created_at', name: 'created_at' },
      { data: 'actions', name: 'actions', orderable: false, searchable: false }
    ],
    order: [[3, 'desc']]
  });

  // 🟢 Ouverture du Offcanvas pour création
  document.querySelector('.create-new').addEventListener('click', function () {
    offCanvasTitle.textContent = window.translations.add_new_user;
    formAddNewRecord.reset();
    fv.resetForm(true);
    offCanvasEl = new bootstrap.Offcanvas(offCanvasElement);
    offCanvasEl.show();
    $('#password_required_span').fadeIn();
    $('#name').trigger('focus');
    $('#user_id').val(0);
  });

  // 🟢 Ouverture du Offcanvas pour édition
  $(document).on('click', '.edit-btn', function () {
    currentEditId = $(this).data('id');
    const name = $(this).data('name');
    const email = $(this).data('email');
    const roleId = $(this).data('role-id');

    $('#name').val(name);
    $('#email').val(email);
    $('#role').val(roleId);
    $('#user_id').val(currentEditId);

    $('#password_required_span').fadeOut();

    offCanvasTitle.textContent = window.translations.edit_user;

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
            message: window.translations.user_name_required
          }
        }
      },
      role: {
        validators: {
          notEmpty: {
            message: window.translations.user_role_required
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

    const userId = $('#user_id').val();
    const updating = userId && userId != 0 ? true : false;
    const url = updating ? window.routes.update.replace(':id', userId) : window.routes.store;
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
        $('#userForm .is-invalid').removeClass('is-invalid');
        $('#userForm .invalid-feedback').removeClass('d-block');

        if (respJson && respJson.errors) {
          const errors = respJson.errors;
          for (const key in errors) {
            const input = $('#userForm').find('[name="' + key + '"]');
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
      title: window.translations.user_delete_title,
      text: window.translations.user_delete_text,
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
            Swal.fire('Supprimé !', response.message || "L'utilisateur a été supprimé.", 'success');
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
