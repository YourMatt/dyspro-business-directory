if (! $) var $ = jQuery;

$(document).ready (function () {

   if (! $("div.dbd-meta-location").length) return;

   dbd_location_meta.set_map_size ();
   google.maps.event.addDomListener (window, 'load', dbd_location_meta.initialize_map);

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

      // set up the map to the current address
      // TODO: Skip the geocode if the lat/lng are already present
      var geocoder = new google.maps.Geocoder ();
      geocoder.geocode ( { address: $("input[name=loc_map_default_center_location]").val () }, function (results, status) {
         if (status != google.maps.GeocoderStatus.OK) return;

         // set up the map
         var centerCoords = results[0].geometry.location;
         var mapOptions = {
            center: centerCoords,
            zoom: parseInt ($("input[name=loc_map_default_zoom]").val ()),
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
            position: centerCoords,
            map: dbd_location_meta.map
         });

      });

   }

};
