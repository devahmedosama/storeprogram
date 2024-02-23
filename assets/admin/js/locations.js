function initMap() {
    const myLatlng = { lat: 24.4234269, lng: 54.4605174 };
    const map = new google.maps.Map(document.getElementById("map"), {
      zoom: 10,
      center: myLatlng,
    });
    var marker;
    map.addListener("click", (mapsMouseEvent) => {
      document.getElementById('latitude').value =  mapsMouseEvent.latLng.lat();
      document.getElementById('longitude').value = mapsMouseEvent.latLng.lng();
       if (marker) {
            marker.setPosition(mapsMouseEvent.latLng);
        }else{
            marker = new google.maps.Marker({
              position: mapsMouseEvent.latLng,
              map: map,
              title:'Location'
            });
        }
    });
}