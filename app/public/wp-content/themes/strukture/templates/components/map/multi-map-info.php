<?php
$map_one = get_field('map_component_one');
$map_two = get_field('map_component_two');
$lat2 = $map_two['lat'];
$lng2 = $map_two['lng'];
$lat = $map_one['lat'];
$lng = $map_one['lng'];
$address = $map_one['address'];
$address_two = $map_two['address'];


$location_one_title = get_field('location_one_title', 'option');
$location_one_phone = get_field('location_one_phone', 'option');
$location_one_email = get_field('location_one_email', 'option');
$location_one_address = get_field('location_one_address', 'option');
$location_one_hours = get_field('location_one_hours', 'option');


$location_two_title = get_field('location_two_title', 'option');
$location_two_phone = get_field('location_two_phone', 'option');
$location_two_email = get_field('location_two_email', 'option');
$location_two_address = get_field('location_two_address', 'option');
$location_two_hours = get_field('location_two_hours', 'option');


$image = get_field('map_marker', 'option');
$styles = get_field('map_style', 'options');

?>

<script>
  var geocoder;
  var geocoderTwo;
  var map;
  var mapTwo;
  var address = "<?php echo $address; ?>";
  var addressTwo = "<?php echo $address_two; ?>";
  var image = "<?php echo $image; ?>";


  function initMap() {
    var map = new google.maps.Map(document.getElementById('map'), {
      zoom: 8,
      styles: <?php echo $styles; ?>,
      center: {lat: <?php echo $lat; ?>, lng: <?php echo $lng; ?>}
    });
    geocoder = new google.maps.Geocoder();
    codeAddress(geocoder, map);

    var mapTwo = new google.maps.Map(document.getElementById('map-two'), {
      zoom: 8,
      styles: <?php echo $styles; ?>,
      center: {lat: <?php echo $lat; ?>, lng: <?php echo $lng; ?>}
    });
    geocoderTwo = new google.maps.Geocoder();
    codeAddressTwo(geocoderTwo, mapTwo);
  }

  function codeAddress(geocoder, map) {
    geocoder.geocode({'address': address}, function(results, status) {
      if (status === 'OK') {
        map.setCenter(results[0].geometry.location);

        if(image) {
          mapIcon = {
            url: image,
          }
        } else {
          mapIcon = ''
        }


        var marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location,
          mapTypeId: google.maps.MapTypeId.ROADMAP,
          icon: mapIcon
        });


      } else {
        console.log('Geocode was not successful for the following reason: ' + status);
      }
    });
  }

  function codeAddressTwo(geocoder, map) {
    geocoder.geocode({'address': addressTwo}, function(results, status) {
      if (status === 'OK') {
        map.setCenter(results[0].geometry.location);

        if(image) {
          mapIcon = {
            url: image,
          }
        } else {
          mapIcon = ''
        }


        var marker = new google.maps.Marker({
          map: map,
          position: results[0].geometry.location,
          mapTypeId: google.maps.MapTypeId.ROADMAP,
          icon: mapIcon
        });


      } else {
        console.log('Geocode was not successful for the following reason: ' + status);
      }
    });
  }
</script>

<?php
$key = get_field('google_maps_key', 'option');
$api_key = 'https://maps.googleapis.com/maps/api/js?key=' . $key . '&callback=initMap';
?>

<script async defer
src="<?php echo $api_key ?>">
</script>

<div class="double-map-wrapper">

  <div class="row row-center">



    <div class="map-wrap">

      <div class="map-one columns-6">
        <div id="map" style="height:400px;"  data-style='<?php echo get_field('map_style', 'options'); ?>'></div>

        <div class="map-content">
          <h4 class="location-title"><?php echo $location_one_title ?></h4>
          <p><?php echo $location_one_address ?></p>
          <a href="mailto:<?php echo $location_one_email ?>"><?php echo $location_one_email ?></a>
          <div><?php echo $location_one_hours ?></div>
          <a href="tel:<?php echo $location_one_phone ?>"><?php echo $location_one_phone ?></a>
        </div>

      </div> <!-- map one -->


      <div class="map-two columns-6">
       <div id="map-two" style="height:400px"   data-style='<?php echo get_field('map_style', 'options'); ?>'></div>
       <div class="map-content">
        <h4 class="location-title"><?php echo $location_two_title ?></h4>
        <p><?php echo $location_two_address ?></p>
        <a href="mailto:<?php echo $location_two_email ?>"><?php echo $location_two_email ?></a>
        <div> <?php echo $location_two_hours ?></div>
        <a href="tel:<?php echo $location_two_phone ?>"><?php echo $location_two_phone ?></a>
      </div>
    </div> <!-- map 2 -->

  </div> <!-- map wrap-->




</div> <!-- row-->

</div> <!-- close main div -->
