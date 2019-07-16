<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); ?>
<?php
/* Please ensure that you have the Usertracking.php file installed in your application/library folder!*/
$hook['post_controller_constructor'][] = array('class' => 'Usertracking', 
                                               'function' => 'auto_track',
                                               'filename' => 'Usertracking.php',
                                               'filepath' => 'libraries');
/* End of file hooks.php */
/* Location: /system/application/config/hooks.php */
?>