<!DOCTYPE html>
<html>
  <head>
    <style>
      #map_canvas {
        width: 500px;
        height: 400px;
        border-radius: 2px;
      }
    </style>
    <script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
    <script>
      function initialize() {
        var map_canvas = document.getElementById('map_canvas');
        var myLatlng = new google.maps.LatLng(41.374593, 14.662379);
        var map_options = {
          center: myLatlng,
          zoom: 17,
          mapTypeId: google.maps.MapTypeId.SATELLITE 
        };
        var map = new google.maps.Map(map_canvas, map_options);
        var marker = new google.maps.Marker({
            position: myLatlng,
            map: map,
            title: 'Siamo Qui!'
        });
      }
      google.maps.event.addDomListener(window, 'load', initialize);
    </script>
  </head>
  <body>
    <div id="map_canvas"></div>
  </body>
</html>