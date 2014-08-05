<?php
    
// Create custom plugin settings menu
add_action('admin_menu', 'info_page');

// Menu creation callback
function info_page() {

	//Create new top-level menu
	add_menu_page('Feed Embed Info', 'Feed Embed Info', 'administrator', __FILE__, 'embed_info_page');

}

// Create settings page
function embed_info_page() {
    echo '<a href="../wp-content/plugins/superplug/README/README.html">Click here if you have not been redirected</a>';
    //echo '<meta http-equiv="refresh" content="0; URL=../wp-content/plugins/superplug/README/README.html">';
}

?>