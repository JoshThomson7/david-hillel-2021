/*
--------------------------------------------
    ______           __                
   / ____/__  ____ _/ /___  __________ 
  / /_  / _ \/ __ `/ __/ / / / ___/ _ \
 / __/ /  __/ /_/ / /_/ /_/ / /  /  __/
/_/    \___/\__,_/\__/\__,_/_/   \___/ 
                                       
-------------------------------------------
Feature
*/

jQuery(document).ready(function($){ 

	$('.flexible-content .feature__image').lightGallery({
	  hash: false,
	  selector: '.play',
	  zoom: false,
	  videoMaxWidth: '1200px'
	}); 

});