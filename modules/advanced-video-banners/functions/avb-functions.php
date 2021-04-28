<?php
/**
 * Video Banners
 *
 * A function that outputs a javascript array of videos
 * added through ACF fields
 *
 * @package modules/
 * @version 1.0
 * @see js/inc/_video-banners.js
*/

/**
 * avb_path()
 *
 * @param bool $avb_url
*/
function avb_path($avb_url = false) {

    if($avb_url) {
        $avb_path = esc_url(plugins_url()) . '/modules/advanced-video-banners/';
    } else {
        $avb_path = get_stylesheet_directory() . '/modules/advanced-video-banners/';
    }
    return $avb_path;
}

/**
 * avb_banners()
 *
 * @param bool $type
*/
function avb_banners($type = 'home') {

    if($type === 'inner') {
        require_once(avb_path().'templates/avb-inner.php');
    } else {
        require_once(avb_path().'templates/avb-home.php');
    }

}

/*
 * Set up AVB JS for header
*/
function avb_video_banners() {

	if(get_field('home_banners') || get_field('page_banner_type') == 'video') {

		$videos = '';
	    $videos .= 'var playerVideos = [';

	    if(get_field('home_banners')) {

            $banner_counter = 0;
            while(have_rows('home_banners'))  { the_row();

                if(get_row_layout() == 'video') {
                    $videos .= "{";
                    $videos .= "id: 'player".$banner_counter."',";
                    $videos .= "videoId: '".get_sub_field('home_banner_video_id')."'";
                    $videos .= '},';
                }

	            $banner_counter++;
	        }

	        echo rtrim($videos, ",") . '];';

	    } elseif(get_field('page_banner_type') == 'video') { // Inner Banner

            $videos .= "{";
            $videos .= "id: 'player0',";
            $videos .= "videoId: '".get_field('page_banner_video_id')."'";
            $videos .= '}';

            echo $videos . '];';

	    }

	} else {
	    echo "var playerVideos = '';";

	}
}

/*
 * Enqueue AVB on header
*/
function avb_wp_head() {
	echo "<script>";
	avb_video_banners();
	echo "</script>";
}
add_action( 'wp_head', 'avb_wp_head', 0);
?>
