/**
 * 🟦 Map
 */

'use strict';

document.addEventListener('DOMContentLoaded', function () {
  // ==========================
  // 🌍 Localisation avec Leaflet + Reverse Geocoding
  // ==========================

  let map;
  let marker;
  let currentCoords = {};

  // Ouvrir le modale
  $('#btnLocate').on('click', function () {
    const modalEl = document.getElementById('mapModal');
    const modal = new bootstrap.Modal(modalEl);
    modal.show();

    modalEl.addEventListener('shown.bs.modal', function handler() {
      // Force le conteneur à avoir une taille
      const container = document.getElementById('mapContainer');
      if (container) {
        container.style.height = '400px';
        container.style.width = '100%';
      }

      if (!map) {
        // Initialisation de la carte
        map = L.map('mapContainer').setView([6.3703, 2.3912], 12);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
          maxZoom: 19,
          attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        // Créer le marker (sera repositionné après)
        marker = L.marker([6.3703, 2.3912], { draggable: true }).addTo(map);

        // Quand l'utilisateur déplace le marqueur
        marker.on('dragend', function (e) {
          currentCoords = marker.getLatLng();
        });
      }

      // 🔎 Vérifier si on a déjà une valeur enregistrée
      const savedLat = parseFloat($('#latitude').val());
      const savedLng = parseFloat($('#longitude').val());

      // Géolocalisation utilisateur
      if (!isNaN(savedLat) && !isNaN(savedLng)) {
        // 👉 Cas édition : on centre sur la position sauvegardée
        currentCoords = { lat: savedLat, lng: savedLng };
        marker.setLatLng([savedLat, savedLng]);
        map.setView([savedLat, savedLng], 15);
      } else if (navigator.geolocation) {
        // 👉 Cas création : on tente la géolocalisation
        navigator.geolocation.getCurrentPosition(
          function (position) {
            const lat = position.coords.latitude;
            const lng = position.coords.longitude;
            currentCoords = { lat, lng };
            marker.setLatLng([lat, lng]);
            map.setView([lat, lng], 15);
          },
          function () {
            // Position par défaut si refus
            currentCoords = { lat: 6.3703, lng: 2.3912 };
            marker.setLatLng([6.3703, 2.3912]);
            map.setView([6.3703, 2.3912], 12);
          }
        );
      } else {
        currentCoords = { lat: 6.3703, lng: 2.3912 };
        marker.setLatLng([6.3703, 2.3912]);
        map.setView([6.3703, 2.3912], 12);
      }

      // Rafraîchir la carte
      setTimeout(() => {
        map.invalidateSize();
      }, 300);
    });
  });

  // Confirmer la localisation
  $('#confirmLocation').on('click', function () {
    if (!currentCoords) {
      notyf.error(window.translations.error_map);
      return;
    }

    const { lat, lng } = currentCoords;

    $('#mapModal').modal('hide');
    notyf.open({
      type: 'info',
      message: window.translations.retriving_map
    });

    // 🔄 Reverse Geocoding via Nominatim
    fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lng}&addressdetails=1`)
      .then(response => response.json())
      .then(data => {
        const displayAddress = data.display_name || '';
        $('#stateOr').val(displayAddress); // For Orgaanisation
        $('#location').val(displayAddress); // For Agenda
        $('#place').val(displayAddress); // For Activity
        $('#latitude').val(lat);
        $('#longitude').val(lng);
        $('#mapModal').modal('hide');
      })
      .catch(() => {
        notyf.error(window.translations.error_map);
      });
  });
});
