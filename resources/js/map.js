document.addEventListener('DOMContentLoaded', function() {
    // Aggiungi l'icona del punto dove si trova l'utente
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(position) {
            var userLat = position.coords.latitude;
            var userLng = position.coords.longitude;
            L.marker([userLat, userLng], { icon: L.icon({ iconUrl: '/images/svg/user_with_basket.svg', iconSize: [60, 60], iconAnchor: [20, 40], popupAnchor: [0, -40] }) }).addTo(map)
                .bindPopup('Tu sei qui').openPopup();
            map.setView([userLat, userLng], 10);
        }, function() {
            console.error("Impossibile ottenere la posizione dell'utente");
        });
    } else {
        console.error('Geolocalizzazione non supportata dal browser');
    }
    // Inizializza la mappa
    var map = L.map('map').setView([41.8719, 12.5674], 6);

    // Configura il layer OpenStreetMap
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
      maxZoom: 19,
      attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // Funzione per mostrare tutti gli agricoltori in Italia
    function loadFarmers() {
      fetch('/api/farmers')
        .then(response => response.json())
        .then(farmers => {
          if (farmers.length === 0) {
            L.marker([41.8719, 12.5674], { icon: L.icon({ iconUrl: '/images/svg/logo.svg', iconSize: [40, 40], iconAnchor: [20, 40], popupAnchor: [0, -40] }) }).addTo(map)
              .bindPopup('Nessun agricoltore trovato. Questo è un marker di esempio.').openPopup();
          } else {
            farmers.forEach(farmer => {
              L.marker([farmer.latitude, farmer.longitude], { icon: L.icon({ iconUrl: '/images/svg/logo.svg', iconSize: [40, 40], iconAnchor: [20, 40], popupAnchor: [0, -40] }) }).addTo(map)
                .bindPopup(`${farmer.name} - ${farmer.product}`);
            });
          }
        })
        .catch(error => {
          console.error('Errore durante il caricamento degli agricoltori:', error);
          L.marker([41.8719, 12.5674]).addTo(map)
            .bindPopup('Errore nel caricamento dei dati. Questo è un marker di esempio.').openPopup();
        });
    }

    // Carica gli agricoltori al caricamento della pagina
    loadFarmers();

    // Funzione per mostrare agricoltori entro 50 km dall'indirizzo inserito
    document.getElementById('search-button').addEventListener('click', function() {
      var address = document.getElementById('address').value;
      if (address.trim() !== '') {
        // Utilizza un geocoder per trovare le coordinate dell'indirizzo
        fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(address)}`)
          .then(response => response.json())
          .then(data => {
            if (data.length > 0) {
              var lat = data[0].lat;
              var lon = data[0].lon;
              map.setView([lat, lon], 10);

            // Aggiungi un marker per il punto dove si trova l'utente
            L.marker([lat, lon], { icon: L.icon({ iconUrl: '/images/svg/user_with_basket.svg', iconSize: [40, 40], iconAnchor: [20, 40], popupAnchor: [0, -40] }) }).addTo(map).bindPopup('La tua posizione');

              // Mostra marker per gli agricoltori entro i 50 km
              fetch(`/api/farmers?lat=${lat}&lon=${lon}&radius=50`)
                .then(response => response.json())
                .then(farmers => {
                  map.eachLayer(function(layer) {
                    if (layer instanceof L.Marker || layer instanceof L.Circle) {
                      map.removeLayer(layer);
                    }
                  });

                    L.circle([lat, lon], {
                      radius: 50000,
                      color: 'green',
                      fillColor: '#4C6B47',
                      fillOpacity: 0.5
                    }).addTo(map).bindPopup('Nessun agricoltore trovato entro 50 km.').openPopup();

                })
                .catch(error => {
                  console.error('Errore durante il caricamento degli agricoltori entro il raggio:', error);
                  alert('Errore durante la ricerca. Riprova più tardi.');
                });
            } else {
              alert('Indirizzo non trovato. Prova a inserire un indirizzo valido.');
            }
          })
          .catch(error => {
            console.error("Errore durante la ricerca dell'indirizzo:", error);
            alert('Errore durante la ricerca. Riprova più tardi.');
          });
      } else {
        // Mostra tutta la mappa d'Italia
        map.setView([41.8719, 12.5674], 6);
        loadFarmers();
      }
    });

    // Funzione per ripristinare la mappa su tutta l'Italia
    document.getElementById('clear-map-button').addEventListener('click', function() {
      document.getElementById('address').value = '';
      map.eachLayer(function(layer) {
        if (layer instanceof L.Marker || layer instanceof L.Circle) {
          map.removeLayer(layer);
        }
      });
      map.setView([41.8719, 12.5674], 6);
      loadFarmers();
    });
  });
