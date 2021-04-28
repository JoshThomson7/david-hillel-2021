<?php
/*
*   Default page template
*/

get_header();

global $post;

require_once('modules/advanced-video-banners/templates/avb-inner.php');

flexible_content();

get_footer();
?>
