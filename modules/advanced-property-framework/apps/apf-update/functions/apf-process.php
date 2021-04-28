<?php
    $import_key = 'vYr4-U';
    $import_id = '2';

    $process = file_get_contents(esc_url(home_url()).'/wp-cron.php?import_key='.$import_key.'&import_id='.$import_id.'&action=processing');
    //echo $process;
