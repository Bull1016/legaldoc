/**
 * 🟦 Gestion des zones
 */

'use strict';

let dt; // dt = DataTable instance

document.addEventListener('DOMContentLoaded', function () {
  // 🟠 Initialisation du DataTable
  dt = $('.datatables-basic').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    ajax: window.routes.data,
    columns: [
      { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
      { data: 'name', name: 'name' },
      { data: 'duration', name: 'duration' },
      { data: 'created_at', name: 'created_at' },
      { data: 'actions', name: 'actions', orderable: false, searchable: false }
    ],
    order: [[1, 'desc']]
  });

  // 🟢 Ouverture du Offcanvas pour édition
  $(document).on('click', '.edit-btn', function () {
    currentEditId = $(this).data('id');
    const name = $(this).data('name');
    const location = $(this).data('location');

    $('#partner_id').val(currentEditId);
    $('#name').val(name);
    $('#location').val(location);

    $('#pic_required_span').fadeOut();

    offCanvasTitle.textContent = window.translations.edit_partner;

    offCanvasEl = new bootstrap.Offcanvas(offCanvasElement);
    offCanvasEl.show();
    $('#name').trigger('focus');
  });

  // ==========================
  // 🟦 Suppression AJAX
  // ==========================
  $(document).on('click', '.btn-delete', function () {
    const id = $(this).data('id');
    const url = $(this).data('url');

    Swal.fire({
      title: window.translations.partner_delete_title,
      text: window.translations.partner_delete_text,
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
            Swal.fire('Supprimé !', response.message || 'Le partenaire a été supprimée.', 'success');
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
