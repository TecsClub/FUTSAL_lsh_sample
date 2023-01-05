<?php
	// Menus
	register_nav_menus( array(
		'main_menu' => 'Main Menu',
	));
	
	function QIIP_HOOK() {
		$args = json_decode(json_encode($_REQUEST), FALSE);
		if (isset($args->post_cmd)) {
			if ($args->post_cmd == 'get_post') {
//				echo '<xmp>' . print_r($args, true) . '</xmp>';
				$result = get_post($args->post_id);
				echo apply_filters( 'the_content', $result->post_content );				
			}
			exit();
		}
	}
	add_action( 'init', 'QIIP_HOOK');
?>