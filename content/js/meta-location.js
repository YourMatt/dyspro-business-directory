if (! $) var $ = jQuery;

$(document).ready (function () {

   if (! $("div.dbd-meta-location").length) return;

   dsd_location_meta.set_map_size ();

})

$(window).resize (function () {

   if (! $("div.dbd-meta-location").length) return;

   dsd_location_meta.set_map_size (true);

});

var dsd_location_meta = {

   set_map_size: function (reset_first) {

      // if reset option, then clear current height - prevents cell height growth when resizing to thinner page
      if (reset_first) {
         $("#dsd-meta-location-map").height (1);
      }

      // set the map height to equal the height of the table cell it's in
      var mapHeight = $("#dsd-meta-location-map").parent().height();
      $("#dsd-meta-location-map").height (mapHeight);

   }

};

