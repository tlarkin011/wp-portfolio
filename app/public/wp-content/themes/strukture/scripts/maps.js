/*
 |----------------------------------------------------------------
 |  Google Maps
 |----------------------------------------------------------------
 */





/*
*  emptyCurrentMap
*
*  This function will empty the existing map element
*
*  @type    function
*  @date    8/11/2018
*  @since   4.3.0
*
*  @param   n/a
*  @return  n/a
*/
function emptyCurrentMap() {
    $('.acf-map').empty();
}


/*
*  createNewMapMarker
*
*  This function use data provided to create a new map marker and add the html to the map DOM element
*
*  @type    function
*  @date    8/11/2018
*  @since   4.3.0
*
*  @param   object {mapAddress: string, mapLat: string, mapLng: string}
*  @return  n/a
*/
function createNewMapMarker(mapData) {
    var htmlOutput = '<div class="marker" ';
    htmlOutput += 'data-url="' + mapData.mapAddress + '" ';
    htmlOutput += 'data-lat="' + mapData.mapLat + '" ';
    htmlOutput += 'data-lng="' + mapData.mapLng + '" ';
    htmlOutput += 'data-article-id="' + mapData.articleId + '" ';
    htmlOutput += '><h6>' + mapData.title + '</h6>'
    htmlOutput += '<p>' + mapData.mapAddress + '</p><a class="smooth-scroll" href="#';
    htmlOutput += mapData.articleId + '">View</a></div>';

    $('.acf-map').append(htmlOutput);
}

/*
*  acfMapInit()
*
*  Initializes the map on the DOM element with a class name .acf-map
*
*  @type    function
*  @date    8/11/2018
*
*  @return  n/a
*/


function acfMapInit() {
    $('.acf-map').each(function(){
        //if map loop container exists we want to clear the default map marker and use the markers generated in the loop
        if ($('.map-loop-container').length) {
            // Map Data element that will hold marker info
            $el = $(".map-data");
            //clear the maps default marker
            emptyCurrentMap();
            $el.each(function() {
                var mapData = this.dataset;
                createNewMapMarker(mapData);
            });
        }

        // create map
        map = new_map( $(this) );

    });
}

function zoomOnMarker(mapData){
    var latlng = new google.maps.LatLng( mapData.mapLat, mapData.mapLng );
    map.setZoom(16);
    map.setCenter(latlng);
}



/*
*  new_map
*
*  This function will render a Google Map onto the selected jQuery element
*
*  @type    function
*  @date    8/11/2013
*  @since   4.3.0
*
*  @param   $el (jQuery element)
*  @return  n/a
*/

function new_map( $el ) {

    // var
    var $markers = $el.find('.marker');

    // vars
    var args = {
        zoom        : 16,
        center      : new google.maps.LatLng(0, 0),
        styles      : $el.data('style'),
    };


    // create map
    var map = new google.maps.Map( $el[0], args);


    // add a markers reference
    map.markers = [];


    // add markers
    $markers.each(function(){

        add_marker( $(this), map );

    });


    // center map
    center_map( map );


    // return
    return map;

}

/*
*  add_marker
*
*  This function will add a marker to the selected Google Map
*
*  @type    function
*  @date    8/11/2013
*  @since   4.3.0
*
*  @param   $marker (jQuery element)
*  @param   map (Google Map object)
*  @return  n/a
*/

function add_marker( $marker, map ) {

    // var
    var latlng = new google.maps.LatLng( $marker.attr('data-lat'), $marker.attr('data-lng') );
    var id = $marker.attr('data-article-id');
    // create marker
    var marker = new google.maps.Marker({
        position    : latlng,
        map         : map,
        articleId   : id,
    });

    // add to array
    map.markers.push( marker );

    // if marker contains HTML, add it to an infoWindow
    if( $marker.html() )
    {
        // create info window
        var infowindow = new google.maps.InfoWindow({
            content     : $marker.html()
        });

        // show info window when marker is clicked
        google.maps.event.addListener(marker, 'click', function() {

            infowindow.open( map, marker );

        });
    }

}

/*
*  center_map
*
*  This function will center the map, showing all markers attached to this map
*
*  @type    function
*  @date    8/11/2013
*  @since   4.3.0
*
*  @param   map (Google Map object)
*  @return  n/a
*/

function center_map( map ) {

    // vars
    var bounds = new google.maps.LatLngBounds();

    // loop through all markers and create bounds
    $.each( map.markers, function( i, marker ){

        var latlng = new google.maps.LatLng( marker.position.lat(), marker.position.lng() );

        bounds.extend( latlng );

    });

    // only 1 marker?
    if( map.markers.length == 1 )
    {
        // set center of map
        map.setCenter( bounds.getCenter() );
        map.setZoom( 16 );
    }
    else
    {
        // fit to bounds
        map.fitBounds( bounds );
    }

}

/*
*  document ready
*
*  This function will render each map when the document is ready (page has loaded)
*
*  @type    function
*  @date    8/11/2013
*  @since   5.0.0
*
*  @param   n/a
*  @return  n/a
*/
// global var
var map = null;

jQuery(function($){
    // This seems to be the most reliable loading method, it waits until all assets are loaded and
    // seems to ensure that google maps is loaded
    // before initializing
    window.onload = acfMapInit;


});

/*
    |----------------------------------------------------------------
    | Map Scripts
    | Create a marker element for each map data element in the map loop container
    |----------------------------------------------------------------
    */

// $(".map-loop-container").each(function() {
//     var $el = $(".map-data");
//     $el.click(function(e) {
//         e.preventDefault();
//         var mapData = this.dataset;
//         zoomOnMarker(mapData);
//         smoothScroll(e);
//     });
//     $el.each(function() {
//         var mapData = this.dataset;
//         createNewMapMarker(mapData);
//     });
// });
//
// $('.acf-map').on('click', 'a', smoothScroll);
