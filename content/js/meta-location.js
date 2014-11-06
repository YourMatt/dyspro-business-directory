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
      // TODO: Load the default address from fields on page
      var geocoder = new google.maps.Geocoder ();
      geocoder.geocode ( { address: "WY, US" }, function (results, status) {
         if (status != google.maps.GeocoderStatus.OK) return;

         var centerCoords = results[0].geometry.location;

         var mapOptions = {
            center: centerCoords,
            zoom: 5, // TODO: pull from configuration
            zoomControl: false,
            streetViewControl: false,
            scrollWheel: false,
            scaleControl: false,
            panControl: false,
            mapTypeControl: false,
            mapTypeId: google.maps.MapTypeId.TERRAIN, // TODO: pull from configuration
            draggable: false
         };

         var map = new google.maps.Map (
            $("#dbd-meta-location-map").get(0),
            mapOptions
         );

         // TODO: Add map marker

      });

   }

};
