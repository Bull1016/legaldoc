/**
 * 🟦 Gestion des régions
 */

'use strict';

let fv, offCanvasEl, regiondt; // dt = DataTable instance

document.addEventListener('DOMContentLoaded', function () {
  const offCanvasElementRegion = document.querySelector('#manage-regions');
  const offCanvasTitleRegion = offCanvasElementRegion.querySelector('.offcanvas-region-title');
  const offCanvasTitleRegionCountryName = offCanvasElementRegion.querySelector('.offcanvas-region-title-countryName');

  const formAddNewRegion = document.getElementById('regionForm');
  const offCanvasElementRegionForm = document.querySelector('#add-new-record-region-form');
  const offCanvasTitleRegionForm = offCanvasElementRegionForm.querySelector('.offcanvas-title-region-form');

  $(document).on('click', '.manage-btn', function () {
    const id = $(this).data('id');
    const url = $(this).data('url');
    const name = $(this).data('name');

    $('.create-new-region').data('country-id', id);

    offCanvasTitleRegion.textContent = window.translations.manage_regions;
    offCanvasTitleRegionCountryName.textContent = name;

    offCanvasEl = new bootstrap.Offcanvas(offCanvasElementRegion);
    offCanvasEl.show();

    // 🔴 IMPORTANT: Détruire le DataTable existant avant de le réinitialiser
    if (regiondt) {
      regiondt.destroy();
    }

    regiondt = $('.datatables-regions').DataTable({
      processing: true,
      serverSide: true,
      responsive: true,
      ajax: url,
      columns: [
        { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
        { data: 'nameTown', name: 'nameTown' },
        { data: 'created_at', name: 'created_at' },
        { data: 'actions', name: 'actions', orderable: false, searchable: false }
      ],
      order: [[2, 'desc']]
    });
  });

  // ==========================
  // 🧪 FormValidation.io
  // ==========================
  const fv = FormValidation.formValidation(formAddNewRegion, {
    fields: {
      nameTown: {
        validators: {
          notEmpty: {
            message: window.translations.region_name_required
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

  // 🟢 Ouverture du Offcanvas pour création
  document.querySelector('.create-new-region').addEventListener('click', function () {
    offCanvasTitleRegionForm.textContent = window.translations.add_new_region;
    formAddNewRegion.reset();
    fv.resetForm(true);
    offCanvasEl = new bootstrap.Offcanvas(offCanvasElementRegionForm);
    offCanvasEl.show();
    $('#area_id').val($(this).data('country-id'));
    $('#region_id').val(0);
    $('#nameTown').trigger('focus');
  });

  // 🟢 Ouverture du Offcanvas pour édition
  $(document).on('click', '.edit-region-btn', function () {
    const currentEditId = $(this).data('id');
    const areaId = $(this).data('area');
    const nameTown = $(this).data('name');

    $('#region_id').val(currentEditId);
    $('#area_id').val(areaId);
    $('#nameTown').val(nameTown);

    offCanvasTitleRegionForm.textContent = window.translations.edit_region;

    offCanvasEl = new bootstrap.Offcanvas(offCanvasElementRegionForm);
    offCanvasEl.show();
    $('#nameTown').trigger('focus');
  });

  // ==========================
  // 🧭 Boutons
  // ==========================
  $('#cancelBtnRegion').on('click', function () {
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
  fv.on('core.form.valid', function () {
    const originalText = $('#submitBtnRegion').html();
    $('#submitBtnRegion')
      .prop('disabled', true)
      .html('<span class="spinner-border spinner-border-sm me-2"></span>' + window.translations.submitting);

    const areaId = $('#area_id').val();
    const regionId = $('#region_id').val();
    const updating = regionId && regionId != 0 ? true : false;
    const url = updating
      ? window.routes.update_region.replace(':area', areaId).replace(':region', regionId)
      : window.routes.store_region.replace(':area', areaId);
    const method = updating ? 'PUT' : 'POST';

    $.ajax({
      url: url,
      type: method,
      data: $(formAddNewRegion).serialize(),
      success: function (response) {
        notyf.success(response.message);
        offCanvasEl.hide();
        regiondt.ajax.reload();
        $('.datatables-basic').DataTable().ajax.reload();
      },
      error: function (error) {
        const respJson = error.responseJSON;
        notyf.error(respJson.message);

        // Réinitialiser les erreurs
        $('#regionForm .is-invalid').removeClass('is-invalid');
        $('#regionForm .invalid-feedback').removeClass('d-block');

        if (respJson && respJson.errors) {
          const errors = respJson.errors;
          for (const key in errors) {
            const input = $('#regionForm').find('[name="' + key + '"]');
            input.addClass('is-invalid');
            input.next('.invalid-feedback').addClass('d-block').text(errors[key][0]);
          }
        }
      },
      complete: function () {
        $('#submitBtnRegion').prop('disabled', false).html(originalText);
      }
    });
    setTimeout(function () {
      $('#submitBtnRegion').prop('disabled', false).html(originalText);
    }, 500);
  });

  // ==========================
  // 🟦 Suppression AJAX
  // ==========================
  $(document).on('click', '.btn-region-delete', function () {
    const id = $(this).data('id');
    const url = $(this).data('url');
    const areaId = $(this).data('area');

    Swal.fire({
      title: window.translations.region_delete_title,
      text: window.translations.region_delete_text,
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
            Swal.fire('Supprimé !', response.message || 'La region a été supprimée.', 'success');
            $('.datatables-regions').DataTable().ajax.reload();
          },
          error: function (xhr) {
            Swal.fire('Erreur', xhr.responseJSON?.message || 'Une erreur est survenue.', 'error');
          }
        });
      }
    });
  });
});
