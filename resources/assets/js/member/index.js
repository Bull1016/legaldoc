/**
 * 🟦 Gestion des organisations
 */

'use strict';

document.addEventListener('DOMContentLoaded', function () {
  $('.datatables-basic').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    ajax: window.routes.membersData,
    columns: [
      { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
      { data: 'pic_name', name: 'pic_name' },
      { data: 'contacts', name: 'contacts' },
      { data: 'created_at', name: 'created_at' },
      { data: 'actions', name: 'actions', orderable: false, searchable: false }
    ],
    order: [[3, 'desc']]
  });

  $(document).on('click', '.btn-delete', function () {
    const id = $(this).data('id');
    const url = $(this).data('url');

    Swal.fire({
      title: window.translations.member_delete_title,
      text: window.translations.member_delete_text,
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
            Swal.fire('Supprimé !', response.message || 'Le membre a été supprimé.', 'success');
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
