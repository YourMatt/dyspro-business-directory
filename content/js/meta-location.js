if (! $) var $ = jQuery;

$(document).ready (function () {

   if (! $("div.dbd-meta-location").length) return;

   dbd_location_meta.set_map_size ();
   google.maps.event.addDomListener (window, 'load', dbd_location_meta.initialize_map);

   $("input[name=loc_address1]").change (dbd_location_meta.update_map_position);
   $("input[name=loc_city]").change (dbd_location_meta.update_map_position);
   $("input[name=loc_state]").change (dbd_location_meta.update_map_position);
   $("input[name=loc_postalcode]").change (dbd_location_meta.update_map_position);

});

$(window).resize (function () {

   if (! $("div.dbd-meta-location").length) return;

   dbd_location_meta.set_map_size (true);

});

var dbd_location_meta = {

   map: null,
   map_marker: null,

   set_map_size: function (reset_first) {

      // if reset option, then clear current height - prevents cell height growth when resizing to thinner page
      if (reset_first) {
         $("#dbd-meta-location-map").height (1);
      }

      // set the map height to equal the height of the table cell it's in
      var mapHeight = $("#dbd-meta-location-map").parent().height();
      $("#dbd-meta-location-map").height (mapHeight);

   },

   initialize_map: function () {

      // pull current coordinate values
      var currentLat = $("input[name=loc_lat]").val ();
      var currentLng = $("input[name=loc_lng]").val ();

      // if current coordinates, than build the map to the current location
      if (currentLat && currentLng) {

         // set up the map
         var centerCoords = new google.maps.LatLng (currentLat, currentLng);
         var zoom = parseInt ($("input[name=loc_map_addressed_zoom]").val ());
         dbd_location_meta.build_map (centerCoords, zoom);

      }

      // if no current coordinates show the map for the default location
      else {

         var geocoder = new google.maps.Geocoder();
         geocoder.geocode({address: $("input[name=loc_map_default_center_location]").val()}, function (results, status) {
            if (status != google.maps.GeocoderStatus.OK) return;

            // set up the map
            var centerCoords = results[0].geometry.location;
            var zoom = parseInt($("input[name=loc_map_default_zoom]").val());
            dbd_location_meta.build_map(centerCoords, zoom);

            // set the coordinates in the display and input fields
            dbd_location_meta.set_lat_lng_fields(centerCoords.lat(), centerCoords.lng());

         });

      }

   },

   build_map: function (coords, zoom) {

      var mapOptions = {
         center: coords,
         zoom: zoom,
         zoomControl: false,
         streetViewControl: false,
         scrollWheel: false,
         scaleControl: false,
         panControl: false,
         mapTypeControl: false,
         mapTypeId: eval ("google.maps.MapTypeId." + $("input[name=loc_map_type]").val ())
      };

      dbd_location_meta.map = new google.maps.Map (
         $("#dbd-meta-location-map").get(0),
         mapOptions
      );

      // add a marker at the default location - this will move as the user enters the address
      dbd_location_meta.map_marker = new google.maps.Marker ({
         position: coords,
         map: dbd_location_meta.map,
         draggable: true
      });

      // set the marker to update the coordinates when dragged
      google.maps.event.addListener (dbd_location_meta.map_marker, "dragend", function () {
         var newCoords = dbd_location_meta.map_marker.getPosition ();
         dbd_location_meta.set_lat_lng_fields (newCoords.lat (), newCoords.lng ());
      });

   },

   update_map_position: function () {

      // build the address string
      var address1 = $("input[name=loc_address1]").val ();
      var city = $("input[name=loc_city]").val ();
      var state = $("input[name=loc_state]").val ();
      var postalCode = $("input[name=loc_postalcode]").val ();
      var address = address1 + ", " + city + ", " + state + " " + postalCode;

      // geocode the address
      var geocoder = new google.maps.Geocoder ();
      geocoder.geocode ( { address: address }, function (results, status) {
         if (status != google.maps.GeocoderStatus.OK) return;

         // recenter the map and marker
         var centerCoords = results[0].geometry.location;
         dbd_location_meta.map.setCenter (centerCoords);
         dbd_location_meta.map.setZoom (parseInt ($("input[name=loc_map_addressed_zoom]").val ()));
         dbd_location_meta.map_marker.setPosition (centerCoords);

         // set the coordinates in the display and input fields
         dbd_location_meta.set_lat_lng_fields (centerCoords.lat (), centerCoords.lng ());

      });

   },

   set_lat_lng_fields: function (lat, lng) {

      $("#dbd-meta-location-lat").html (lat);
      $("#dbd-meta-location-lng").html (lng);
      $("input[name=loc_lat]").val (lat);
      $("input[name=loc_lng]").val (lng);

   }

};
