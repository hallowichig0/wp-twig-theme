<?php
/**
 * All wp_ajax and wp_ajax_nopriv here
 *
 *
 * @package Bootstrap4
 */

class Bootstrap4AjaxHandler extends Timber\Site {
    /** Add timber support. */
	public function __construct() {

        parent::__construct();
    }
}
new Bootstrap4AjaxHandler();