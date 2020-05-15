function initMap() { 
    var infowindowContent = document.getElementById('infowindow');
    var coordenadas = document.getElementById('coordenadas').innerHTML;

    var map;
    var marker;

    // Ventana de información del marcador
    var infowindow = new google.maps.InfoWindow();
    infowindow.setContent(infowindowContent);

    var latLong = coordenadas.split(',');
        map = new google.maps.Map(document.getElementById('map'), {
            center: new google.maps.LatLng(latLong[0], latLong[1]),
            zoom: 17
        });
        marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29),
            position: new google.maps.LatLng(latLong[0], latLong[1])
        });


        infowindowContent.children['place-icon'].src = 'https://maps.gstatic.com/mapfiles/place_api/icons/geocode-71.png';
        infowindowContent.children['place-name'].textContent = document.getElementById('ubicacion').innerHTML;
        infowindowContent.style = 'display: inline'
        infowindow.open(map, marker);
}