function initMap() {
    var coordenadasInputHidden = document.getElementById('evento_coordenadas');
    var coordenadas = coordenadasInputHidden.value;
    var infowindowContent = document.getElementById('infowindow');
    var map;
    var marker;

    // Ventana de información del marcador
    var infowindow = new google.maps.InfoWindow();
    infowindow.setContent(infowindowContent);

    // Crea el mapa, si existen coordenadas las marca
    if (coordenadas) {
        var latLong = coordenadas.split(',');
        map = new google.maps.Map(document.getElementById('map-form'), {
            center: new google.maps.LatLng(latLong[0], latLong[1]),
            zoom: 17,
            clickableIcons: false
        });
        marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29),
            position: new google.maps.LatLng(latLong[0], latLong[1])
        });
        infowindowContent.children['place-icon'].src = 'https://maps.gstatic.com/mapfiles/place_api/icons/geocode-71.png';
        infowindowContent.children['place-name'].textContent = document.getElementById('evento_ubicacion').value;
        infowindowContent.style = 'display: inline'
        infowindow.open(map, marker);
    }
    else {
        map = new google.maps.Map(document.getElementById('map-form'), {
            center: { lat: 39.4698, lng: -0.3764 },
            zoom: 14
        })
    };

    

    var input = document.getElementById('evento_ubicacion');
    var autocomplete = new google.maps.places.Autocomplete(input);

    autocomplete.setOptions({
        // Los datos que se devuelven cuando el usuario elige una ubicación
        fields: ['address_components', 'geometry', 'icon', 'name'],
        // Restringe los resultados sólo a España
        componentRestrictions: { country: 'es' },
        // Preferencia de muestra de resultados en un radio de 12km del centro de Valencia
        bounds: new google.maps.Circle({
            center: { lat: 39.4698, lng: -0.3764 },
            radius: 12000
        }).getBounds(),
    })

    

    marker = new google.maps.Marker({
        map: map,
        anchorPoint: new google.maps.Point(0, -29)
    });

    // Evento: Cambio de ubicación en el input
    autocomplete.addListener('place_changed', function () {
        infowindow.close();
        marker.setVisible(false);
        var place = autocomplete.getPlace();

        // Centra el mapa
        if (place.geometry.viewport) {
            map.fitBounds(place.geometry.viewport);
        } else {
            map.setCenter(place.geometry.location);
            map.setZoom(17);
        }
        // Muestra el marcador con la posición
        marker.setPosition(place.geometry.location);
        marker.setVisible(true);

        // Establece las coordenadas de la ubicación en el input hidden en formato JSON
        var coordenadas = marker.getPosition().toString().slice(1,-1);
        coordenadasInputHidden.value = coordenadas;

        // Obtiene las datos de la dirección de la ubicación
        var address = '';
        if (place.address_components) {
            address = [
                (place.address_components[1] && place.address_components[1].short_name || ''),
                (place.address_components[0] && place.address_components[0].short_name || ''),
                (place.address_components[2] && place.address_components[2].short_name || '')
            ].join(' ');
        }

        // Establece los datos de la ubicación en la ventana y la muestra
        infowindowContent.children['place-icon'].src = place.icon;
        infowindowContent.children['place-name'].textContent = place.name;
        infowindowContent.children['place-address'].textContent = address;
        infowindowContent.style = 'display: inline'
        infowindow.open(map, marker);



    });
}