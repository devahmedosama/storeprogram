function initMap() {
    const myLatlng = { lat: 24.4234269, lng: 54.4605174 };
    const map = new google.maps.Map(document.getElementById("map"), {
      zoom: 10,
      center: myLatlng,
    });

    const geocoder = new google.maps.Geocoder();

    var marker;
    const infowindow = new google.maps.InfoWindow();
    const locationButton = document.createElement("button");
    var marker;
    var address = 'Your Location';
    locationButton.textContent = "Pan to Current Location";
    locationButton.classList.add("custom-map-control-button");
    map.controls[google.maps.ControlPosition.TOP_CENTER].push(locationButton);
    locationButton.addEventListener("click", (event) => {
        // Try HTML5 geolocation.
        event.preventDefault();
        if (navigator.geolocation) {
          navigator.geolocation.getCurrentPosition(
            (position) => {
              const pos = {
                lat: position.coords.latitude,
                lng: position.coords.longitude,
              };
              setLocation(pos,'current');
              map.setCenter(pos);
              map.setZoom(16);
            },
            () => {
              handleLocationError(true, infoWindow, map.getCenter());
            }
          );
        } else {
          // Browser doesn't support Geolocation
          handleLocationError(false, infoWindow, map.getCenter());
        }
      });
      google.maps.event.addListener(map, "click", function (e) {
                      setLocation(e.latLng,'click');

                      });
      function setLocation(latLng,state) {
          if (state == 'click') {
            document.getElementById('latitude').value =   latLng.lat();
            document.getElementById('longitude').value =  latLng.lng();
          }else{
            document.getElementById('latitude').value =   latLng.lat;
            document.getElementById('longitude').value = latLng.lng;
          }
          geocoder.geocode({ location: latLng })
              .then((response) => {
                if (response.results[0]) {
                      var  address =  response.results[0].formatted_address;
                      document.getElementById('client_address').value = address;
                      if (marker) {
                          marker.setPosition(latLng);
                      }else{
                          marker = new google.maps.Marker({
                            position: latLng,
                            map: map,
                            title:address
                          });
                      }
                                      
                   infowindow.setContent(response.results[0].formatted_address);
                  infowindow.open(map, marker);
                } else {
                  window.alert("No results found");
                }
              })
              .catch((e) => window.alert("Geocoder failed due to: " + e));
      }
   
}
 function handleLocationError(browserHasGeolocation, infoWindow, pos) {
                infoWindow.setPosition(pos);
                infoWindow.setContent(
                  browserHasGeolocation
                    ? "Error: The Geolocation service failed."
                    : "Error: Your browser doesn't support geolocation."
                );
                infoWindow.open(map);
              }