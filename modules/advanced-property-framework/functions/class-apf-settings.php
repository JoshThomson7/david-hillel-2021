<?php
/**
 * APF Settings
 *
 * Class in charge of APF's default settings
 *
 * @author  Various
 * @package Advanced Property Framework
 *
*/
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class APF_Settings {

    /**
     * Returns whether the system is set to development mode
     * 
     * @return bool
     */
    public function is_dev_mode() {

        return get_field('apf_development_mode', 'option');

    }

    /**
     * Returns the property feed provider
     * 
     * @return array
     */
    public function provider() {

        return get_field('apf_provider', 'option');

    }

    /**
     * Returns the property feed markets
     * 
     * @return array
     */
    public function markets() {

        return get_field('apf_markets', 'option');

    }

    /**
     * Returns the property feed departments
     * 
     * @return array
     */
    public function departments() {

        return get_field('apf_departments', 'option');

    }

    /**
     * Returns the Google Maps API Key
     * depending on dev/live mode
     * 
     * @return string
     */
    public function google_maps_api_key() {

        $field_name = 'apf_google_maps_api_key';

        if($this->is_dev_mode()) {
            $field_name .= '_dev';
        }

       return get_field($field_name, 'option');

    }

    /**
     * Returns an array of the sorting
     * options enabled in settings
     * 
     * @return array
     */
    public function search_sorting_filters() {

        return get_field('apf_search_sorting_filter', 'option');

    }

    /**
     * Returns whether to show the
     * show/hide sold/let properties switch
     * 
     * @return bool
     */
    public function search_hide_gone() {

        return get_field('apf_search_gone_filter', 'option');

    }

    /**
     * Whether to show the "New Homes only" switch
     * 
     * @return bool
     */
    public function search_new_home() {

        return get_field('apf_search_new_homes', 'option');

    }

}