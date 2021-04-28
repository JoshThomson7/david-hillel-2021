<?php
/**
 * Core class
 * 
 * @package APF
 * @version 2.0
 */

class APF_Import {

    private $provider;

    public function __construct($provider, $format = 'xml') {

        $this->defineConstants();
        $this->loadDependencies();
        $this->provider = $provider;

    }

    /**
     * Setup constants.
     *
     * @access private
     * @since 2.0
     * @return void
     */
    private function defineConstants() {

        $this->define('APF_IMPORT_VERSION', '2.0');
        $this->define('APF_IMPORT_SLUG', 'apf_import');
        $this->define('APF_IMPORT_PATH', dirname(__FILE__));
        $this->define('APF_XML_PATH', dirname(__FILE__).'/xml/');

    }

    private function loadDependencies() {

        // Core
        include_once APF_IMPORT_PATH. '/inc/class-apf-import-utils.php';

        // Providers
        include_once APF_IMPORT_PATH. '/providers/rezi/class-apf-import-rezi.php';
        include_once APF_IMPORT_PATH. '/providers/veco/class-apf-import-veco.php';

    }

    public function provider() {

        switch ($this->provider) {
            case 'rezi':
                $provider = new APFI_Rezi();
                break;

            case 'veco':
                $provider = new APFI_Veco();
                break;
        }

        return $provider;

    }

    /**
     * Define constant if not already set.
     *
     * @param string      $name  Constant name.
     * @param string|bool $value Constant value.
     */
    private function define($name, $value) {
        if(!defined($name)) {
            define($name, $value);
        }
    }

}