<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/*
  KRIESI PAGINATION

  Usage: <?php pagination (); ?>
  More info: http://www.kriesi.at/archives/how-to-build-a-wordpress-post-pagination-without-plugin

  STYLE - Paste the code below on your stylesheet, if used, and change accordingly
  ------------------------------------------------------------------------------------
  .pagination { clear:both; padding:5px 0; position:relative; font-size:11px; line-height:13px; overflow:hidden; border-bottom:1px #c9c9c9 dotted; margin:0 30px 20px 0;}
  .page-count { float:left; padding:5px 0;}
  .page-numbers { float:right;}
  .pagination span, .pagination a { display:block; float:left; margin: 0; padding:4px 7px 3px; text-decoration:none; width:auto; color:#404040;}
  .pagination a:hover { background: #404040; color:#fff;}
  .pagination .current { padding:4px 7px 3px; background: #62a809; color:#fff;}

*/

function pagination($pages = '', $range = 4) {
     $showitems = ($range * 2)+1;

     global $paged;
     if(empty($paged)) $paged = 1;

     if($pages == '')
     {
         global $wp_query;
         $pages = $wp_query->max_num_pages;
         if(!$pages)
         {
             $pages = 1;
         }
     }

     if(1 != $pages)
     {
         echo "<div class=\"pagination\"><div class=\"page-count\">Page ".$paged." of ".$pages."</div><div class=\"page-numbers\">";
         if($paged > 2 && $paged > $range+1 && $showitems < $pages) echo "<a href='".get_pagenum_link(1)."'>&laquo;</a>";
         if($paged > 1 && $showitems < $pages) echo "<a href='".get_pagenum_link($paged - 1)."'>&lsaquo;</a>";

         for ($i=1; $i <= $pages; $i++)
         {
             if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems ))
             {
                 echo ($paged == $i)? "<span class=\"current\">".$i."</span>":"<a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a>";
             }
         }

         if ($paged < $pages && $showitems < $pages) echo "<a href=\"".get_pagenum_link($paged + 1)."\">&rsaquo;</a>";
         if ($paged < $pages-1 &&  $paged+$range-1 < $pages && $showitems < $pages) echo "<a href='".get_pagenum_link($pages)."'>&raquo;</a>";
         echo "</div></div>\n";
     }
}
