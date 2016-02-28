<?php
use yii\helpers\Html;
use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\services\DirectionsWayPoint;
use dosamigos\google\maps\services\TravelMode;
use dosamigos\google\maps\overlays\PolylineOptions;
use dosamigos\google\maps\services\DirectionsRenderer;
use dosamigos\google\maps\services\DirectionsService;
use dosamigos\google\maps\overlays\InfoWindow;
use dosamigos\google\maps\overlays\Marker;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\services\DirectionsRequest;
use dosamigos\google\maps\overlays\Polygon;
use dosamigos\google\maps\layers\BicyclingLayer;

?>
<?php 
$coord = new LatLng(['lat' => $coordinat->lat, 'lng' => $coordinat->lng]);
$map = new Map([
		'center' => $coord,
		'zoom' => 12,
		'width' => '100%',
		'height' => '500',
]);
//print_r($coordinat);
?>
<div class="site-index">
    <div class="body-content">
        <div class="row">
            <div class="col-lg-12">
            <?php foreach ($responces as $responce):?>
            <?php 
            if ($model->coordinates != null) {
            	list ( $lat, $lng ) = explode ( '+', $model->coordinates );
            }
            $coord = new LatLng ( [
            		'lat' => $responce['coordinates']['coordinates'][1],
            		'lng' => $responce['coordinates']['coordinates'][0]
            ] );
            	
            $marker = new Marker ( [
            		'position' => $coord,
            		'title' => $responce['user']['name'],
            		'icon' => $responce['user']['profile_image_url_https'],
            		//'shape' => 'circle'
            ] );
            $text = '';
            
            if(!empty($responce['entities']['urls'])){
            	foreach ($responce['entities']['urls'] as $url){
            		$text = str_replace($url['url'], Html::a($url['url'],$url['url'],['target' => '_blank']), $responce['text']);
            	}
            }else{
            	$text = $responce['text'];
            }
            
            $html = '';
            $html .= '<div class="counter-tab">';
            $html .= '<p><i class="fa fa-map-marker"></i>  '.$text.' At :'. $responce['created_at'].'</p>';
            $html .= '</div>';
            	
            $marker->attachInfoWindow(
            		new InfoWindow([
            				'content' => $html
            		])
            );
            // Add marker to the map
            $map->addOverlay($marker);
            ?>
            <?php endforeach;?>
            <?php echo $map->display();?>
            </div>
        </div>
	</div>
</div>
