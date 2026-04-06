/**
 * 🟦 Gestion des permissions
 */

'use strict';

let offCanvasEl; // Bootstrap Offcanvas instance

document.addEventListener('DOMContentLoaded', function () {
  const offCanvasElementPermission = document.querySelector('#manage-permissions');
  const offCanvasTitlePermission = offCanvasElementPermission.querySelector('.offcanvas-permission-title');
  const offCanvasTitlePermissionPositionName = offCanvasElementPermission.querySelector(
    '.offcanvas-permission-title-positionName'
  );

  const formAddNewPermission = document.getElementById('permissionForm');

  // ==========================
  // 🔄 Load existing permissions for position
  // ==========================
  function loadPositionPermissions(positionId) {
    const url = window.routes.get_permissions.replace(':id', positionId);

    // Reset all checkboxes first
    $('.permission-checkbox').prop('checked', false);
    $('#select-all-permissions').prop('checked', false);

    $.ajax({
      url: url,
      type: 'GET',
      success: function (response) {
        if (response.status === 'success' && response.permissions) {
          // Check the permissions that this position has
          response.permissions.forEach(function (permissionId) {
            $('input[name="permissions[]"][value="' + permissionId + '"]').prop('checked', true);
          });

          // Update select all checkbox state
          updateSelectAllState();
        }
      },
      error: function (error) {
        console.error('Error loading permissions:', error);
        notyf.error(window.translations.failed_to_fetch_permissions);
      }
    });
  }

  // ==========================
  // ✅ Select All / Deselect All
  // ==========================
  function updateSelectAllState() {
    const totalCheckboxes = $('.permission-checkbox').length;
    const checkedCheckboxes = $('.permission-checkbox:checked').length;
    $('#select-all-permissions').prop('checked', totalCheckboxes === checkedCheckboxes);
  }

  $('#select-all-permissions').on('change', function () {
    const isChecked = $(this).prop('checked');
    $('.permission-checkbox').prop('checked', isChecked);
  });

  $(document).on('change', '.permission-checkbox', function () {
    updateSelectAllState();
  });

  // ==========================
  // 📂 Open modal and load permissions
  // ==========================
  $(document).on('click', '.manage-btn', function () {
    const id = $(this).data('id');
    const name = $(this).data('name');

    $('#position_id').val(id);

    offCanvasTitlePermission.textContent = window.translations.manage_permissions;
    offCanvasTitlePermissionPositionName.textContent = name;

    // Load existing permissions
    loadPositionPermissions(id);

    offCanvasEl = new bootstrap.Offcanvas(offCanvasElementPermission);
    offCanvasEl.show();
  });

  // ==========================
  // 🧭 Boutons
  // ==========================
  $('#cancelBtnPermission').on('click', function () {
    offCanvasEl.hide();
  });

  // ==========================
  // 🟦 Soumission AJAX
  // ==========================
  $.ajaxSetup({
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  });

  $(formAddNewPermission).on('submit', function (e) {
    e.preventDefault();

    const originalText = $('#submitBtnPermission').html();
    $('#submitBtnPermission')
      .prop('disabled', true)
      .html('<span class="spinner-border spinner-border-sm me-2"></span>' + window.translations.submitting);

    const positionId = $('#position_id').val();
    const url = window.routes.update_permission.replace(':id', positionId);
    const method = 'PUT';

    $.ajax({
      url: url,
      type: method,
      data: $(formAddNewPermission).serialize(),
      success: function (response) {
        notyf.success(response.message);
        offCanvasEl.hide();
        window.location.reload();
      },
      error: function (error) {
        const respJson = error.responseJSON;
        notyf.error(respJson.message || window.translations.error_occurred);

        // Réinitialiser les erreurs
        $('#permissionForm .is-invalid').removeClass('is-invalid');
        $('#permissionForm .invalid-feedback').removeClass('d-block');

        if (respJson && respJson.errors) {
          const errors = respJson.errors;
          for (const key in errors) {
            const input = $('#permissionForm').find('[name="' + key + '"]');
            input.addClass('is-invalid');
            input.next('.invalid-feedback').addClass('d-block').text(errors[key][0]);
          }
        }
      },
      complete: function () {
        $('#submitBtnPermission').prop('disabled', false).html(originalText);
      }
    });
  });
});
