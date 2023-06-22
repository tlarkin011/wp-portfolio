<?php
/**
 * This component is meant to work with the functions in map.js
 * It can take multiple posts that have an acf map field and place markers on the map
 *
 * if you have a loop of posts that have a map give them a element that holds the map data
 *      data attributes for map data element:
 *          address: address taken from acf map field, this will display on marker modal
 *          lat: latitude taken from acf map field
 *          lng: longitude taken from acf map field
 *          article-id: the html element id if you want to link from the map marker to the article
 *          title: the post title to display on marker modal
 *
 *      example:
 *      $map = get_field('your_acf_map_field_name');
 *      <a href="#" class="map-data" data-map-address="<?php echo $map['address']; ?>" data-map-lat="<?php echo $map['lat']; ?>" data-map-lng="<?php echo $map['lng']; ?>" data-article-id="<?php echo $article_id; ?>" data-title="<?php the_title(); ?>" >Learn More</a>
 *
 *      for full example see templates/loop/map-item.php
 *
 * then use this script to create a marker for each post with map data
 *      $('.map-data').each(function() {
 *          var mapData = this.dataset;
 *          createNewMapMarker(mapData);
 *      });
 **/
$acf_id = forge_var('acf_id') ? forge_var('acf_id') : get_queried_object_id(); ?>
<?php $location = get_field('location', $acf_id);
$columns = forge_var('columns') ? forge_var('columns') : '6';
$highlight_two = get_field('highlight_color_two', 'option');
?>

<div class="columns-12 map-columns">

<!-- Reduce to one element / function -->


    <div id="locations-map" class="acf-map" data-style='[
    {
        "featureType": "administrative",
        "elementType": "labels.text.fill",
        "stylers": [
            {
                "color": "#444444"
            }
        ]
    },
    {
        "featureType": "landscape",
        "elementType": "all",
        "stylers": [
            {
                "color": "#f2f2f2"
            }
        ]
    },
    {
        "featureType": "poi",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "road",
        "elementType": "all",
        "stylers": [
            {
                "saturation": -100
            },
            {
                "lightness": 45
            }
        ]
    },
    {
        "featureType": "road.highway",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "simplified"
            }
        ]
    },
    {
        "featureType": "road.arterial",
        "elementType": "labels.icon",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "transit",
        "elementType": "all",
        "stylers": [
            {
                "visibility": "off"
            }
        ]
    },
    {
        "featureType": "water",
        "elementType": "all",
        "stylers": [
            {
                "color": "<?php echo $highlight_two;?>"
            },
            {
                "visibility": "on"
            }
        ]
    }
]' >



        <div class="marker"
             data-marker="<?php echo get_field('map_marker'); ?>"
             data-url="<?php echo $location['address']; ?>"
             data-lng="<?php echo $location['lng']; ?>"
             data-lat="<?php echo $location['lat']; ?>"
        ></div>
    </div>
</div>
<script async defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo get_field('google_maps_key', 'option') ?>"></script>
