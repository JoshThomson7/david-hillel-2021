<?php if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
/**
 * APF Branches - Opening Times
 *
 * @author  Various
 * @package Advanced Property Framework
 * @see https://wordpress.stackexchange.com/questions/31247/how-can-i-programmatically-create-child-pages-on-theme-activation
 *
*/

/**
 * APF_Opening_Times
 * 
 * Class in charge of handling times
 */
class APF_Opening_Times { 

    /**
     * opening_times()
     * 
     * @param int $post_id
     * @return array
     */
    public function opening_times($post_id = null) {

        // Bail early if no times have been set.
        if(!$this->has_times()) {
            return;
        }

        // Endpoint post object.
        $opening_times = array();
        
        // Loop through times.
        while(have_rows('opening_times', $post_id)) {
            the_row();

            // Set up object.
            $todays_times = new stdClass();

            // Weekday.
            $weekday = get_sub_field('day');

            // Is it today?
            $today = date("l");
            $is_today = '';
            if($today === $weekday) {
                $is_today = 'today ';
            }

            // Set weekday.
            $todays_times->weekday = array(
                'day' => $weekday,
                'is_today' => $is_today
            );
    
            // Get manually input time
            $opening_time = get_sub_field('opening_time');
            $closing_time = get_sub_field('closing_time');
            
            // Convert times to timestamp for comparison.
            $opening_time_stamp = strtotime($opening_time);
            $closing_time_stamp = strtotime($closing_time);
            $about_to_close = strtotime($closing_time.'- 1 hour');
    
            // Handle past midnight.
            if($closing_time_stamp < $opening_time_stamp) {
                $new_closing = date('l H:i', strtotime('tomorrow '.$today.' '.$closing_time));
                $closing_time_stamp = strtotime($new_closing);
                $about_to_close = strtotime($new_closing.'- 1 hour');
            }

            // Set up opens array.
            $todays_times->opens = array(
                'display_time' => $opening_time,
                'timestamp' => $opening_time_stamp
            );

            // Set up closes array.
            $todays_times->closes = array(
                'display_time' => $closing_time,
                'timestamp' => $closing_time_stamp
            );
            
            // Get current time
            $time = time();

            // check it up
            if($opening_time === '' && $closing_time === '') {
                $is_open = false;
    
                $todays_times_today = $weekday;
    
                $todays_times->status = array(
                    'text' => 'Closed',
                    'class' => 'closed'
                );
    
            } else {
    
                if( ($time <= $closing_time_stamp) && ($time >= $opening_time_stamp) ) {
    
                    $is_open = true;
    
                    if( ($time >= $about_to_close) && ($time < $closing_time_stamp) ) {
    
                        $todays_times->status = array(
                            'text' => 'About to close',
                            'class' => 'about-to-close'
                        );
    
                    } else {
                        $todays_times->status = array(
                            'text' => 'Open',
                            'class' => 'open'
                        );
                    }
    
                } else {
                    $todays_times->status = array(
                        'text' => 'Closed',
                        'class' => 'closed'
                    );
                }

            }

            // Set up display array.
            $todays_times->display = '<span class="weekday">'.$weekday.'</span><span class="times">'.$opening_time.' - '.$closing_time.'</span>';

            // Push the post to the main $post array
            array_push($opening_times, $todays_times);

        }

        return $opening_times;
    
    }


    /**
     * todays_times()
     * 
     * @param int $post_id
     * @param bool True for string / false for array
     * @return array
     */
    public function todays_times($post_id = null) {

        if(!$post_id) { 
            $post_id = $post->ID;
        }

        // Bail early if no times have been set.
        if(!$this->has_times($post_id)) {
            return;
        }
        
        $todays_weekday = date('l');

        // Get opening times
        $opening_times = $this->opening_times($post_id);

        $todays_times = null;

        // Loop through opening times
        foreach($opening_times as $times) { 

            // Skip if weekdays don't match
            if($todays_weekday != $times->weekday['day']) { continue; }

            // Grab data for our current day
            $todays_times = $times;

        }

        // if(empty($todays_times)) {
        //     $todays_times = new stdClass();

        //     $todays_times->weekday = date('l');
        //     $todays_times->display = date('l');
        //     $todays_times->status = array(
        //         'text' => 'Closed',
        //         'class' => 'closed'
        //     );
        // }

        return $todays_times;

    }

    /**
     * has_times()
     * 
     * @param int $post_id
     * @return array
     */
    public function has_times($post_id = null) {
        global $post;

        if(!$post_id) { 
            $post_id = $post->ID;
        }

        // Bail early if no times have been set.
        if(have_rows('opening_times', $post_id)) {
            return true;
        }

    }

}