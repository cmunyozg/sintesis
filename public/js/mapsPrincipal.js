function initMap() {
    var elementsDatos = document.querySelectorAll('.datos');
    var infowindowContent = document.getElementById('infowindow');
    var map;
    var markers = [];

    // Ventana de información del marcador
    var infowindow = new google.maps.InfoWindow();
  
    var arrayDatos = [];
    for (var i = 0; i < elementsDatos.length; i++) {
        arrayDatos.push(elementsDatos[i].innerHTML);
    }

    map = new google.maps.Map(document.getElementById('map'), {
        center: { lat: 39.4750, lng: -0.3764 },
        zoom: 13,
        clickableIcons: false
    });

    for (var i = 0; i < arrayDatos.length; i++) {
        var datos = arrayDatos[i].split(','); // 0 -> ID, 1 -> Título, 2-> Lat, 3-> Long, 4-> Fecha/Hora 

        var marker = new google.maps.Marker({
            map: map,
            anchorPoint: new google.maps.Point(0, -29),
            position: new google.maps.LatLng(datos[2], datos[3]),
            titulo: datos[1],
            id: datos[0],
            date: datos[4],
            //icon: "https:"
        });

        google.maps.event.addListener(marker, 'click', function () {
            infowindow.close();
            infowindowContent.href = '/event/'+this.id+'>';
            infowindowContent.children['titulo'].innerHTML = '<strong>'+this.titulo+'</strong>';
            infowindowContent.children['info'].innerHTML = '<a href="/event/'+this.id+'">'+this.date +'</a>';

            infowindowContent.style = 'display: inline'
            infowindow.setContent(infowindowContent);
            infowindow.open(map, this);
            console.log(infowindow.getPosition)
            console.log(this.position)
        });

        markers.push(marker);

    }

    var markerCluster = new MarkerClusterer(map, markers, { imagePath: 'https://raw.githubusercontent.com/googlemaps/v3-utility-library/master/packages/markerclustererplus/images/m' });
}

    // infowindowContent.children['place-icon'].src = 'https://maps.gstatic.com/mapfiles/place_api/icons/geocode-71.png';
    // infowindowContent.children['place-name'].textContent = document.getElementById('ubicacion').innerHTML;
    // infowindowContent.style = 'display: inline'
    // infowindow.open(map, marker);
