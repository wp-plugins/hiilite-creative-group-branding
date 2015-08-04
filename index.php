<?php
/*
* Plugin Name: Hiilite Admin
* Plugin URI: http://hiilite.com
* Description: This plugin customizes the WordPress login screen to Hiilite branding.
* Version: 1.0.4
* Author: Hiilite Creative Group
* Author URI: http://hiilite.com/team/
* License: GPLv2
*
* @package Hiilite_admin
*
*/

// If this file is called directly, then abort execution.
if ( ! defined( 'WPINC' ) ) {
	die( "Aren't you supposed to come here via WP-Admin?" );
}

/**
 * Holds the filesystem directory path.
 */
define( 'HIILITE_DIR', dirname( __FILE__ ) );

// Set the global variables for Better Search path and URL
$hiilite_path = plugin_dir_path( __FILE__ );
$hiilite_url = plugins_url() . '/' . plugin_basename( dirname( __FILE__ ) );
////////////////////////////////////
//
// Add a new logo to the login page
//
////////////////////////////////////
function hiilite_login_logo() { ?>
    <style type="text/css">
        .login #login h1 a {
            background-image: url( <?php echo plugins_url( 'images/hiilite-logo-combomark.png' , __FILE__ ); ?> );
			background-size: contain;
			  width: auto;
			  background-repeat: no-repeat;
        }
		.login #nav a, .login #backtoblog a {
            color: #f05023 !important;
        }
        .login #nav a:hover, .login #backtoblog a:hover {
            color: #f05023 !important;
			border-bottom:1px dotted #f05023;
		}
		
		.login .button-primary {
            background: transparent; /* Old browsers */
			border:1px solid #f05023;
			color:#f05023 !important;
			border-radius:0;
			box-shadow:none;
			
        }
        .login .button-primary:hover, .login .button-primary:active, .login .button-primary:focus {
            background: #f05023; /* Old browsers */
			color:white !important;
			border:1px solid #f05023;
			box-shadow:none;
        }
    </style>
    <script>
	/*window.onload = function(){
		var hilogo = document.querySelector('#login');
		var hilink = document.querySelector('#login h1 a');
		var node = document.createElement("a");  
		var textnode = document.createTextNode("Water"); 
		node.appendChild(textnode);
		document.querySelector('#login h1 a').setAttribute('href', 'http://hiilite.com');
		hilogo.insertBefore(node, hilogo.firstChild);
	};*/
		
	</script>
<?php }
add_action( 'login_enqueue_scripts', 'hiilite_login_logo' );

///////////////////////////////
//
// add new dashboard widgets
//
//////////////////////////////
function hiilite_add_dashboard_widgets() {
    wp_add_dashboard_widget( 'hiilite_dashboard_welcome', 'Welcome', 'hiilite_add_welcome_widget' );
}
function hiilite_add_welcome_widget(){ ?>
 
	<h3>This Site is Managed by Hiilite Creative Group</h3>
<p>Hiilite works with a mix of local, regional, provincial and international clients. We are equally happy working face-to-face and working remotely. We serve BC, Western Canada and beyond from a little corner of paradise - Kelowna, BC.<br><br>

115-1690 Water Street<br>
Kelowna, BC, V1Y 8T8, Canada<br>
<a href="tel:+18883033444">1.888.303.3444</a><br>
</p><div id="social-icons">
<a href="https://www.facebook.com/hiilite" target="_blank"><img src="https://hiilite.com/wp-content/uploads/2014/11/Facebook-32.png" width="32" height="32" alt="Facebook" scale="0"></a><a href="https://twitter.com/hiilite" target="_blank"><img src="https://hiilite.com/wp-content/uploads/2014/11/Twitter-Bird-32.png" width="32" height="32" alt="Twitter" scale="0"></a><a href="https://plus.google.com/u/0/b/107657092449987968512/107657092449987968512" target="_blank"><img src="https://hiilite.com/wp-content/uploads/2014/11/Google-Plus-32.png" width="32" height="32" alt="Google" scale="0"></a>
</div>
 
 
<?php }
add_action( 'wp_dashboard_setup', 'hiilite_add_dashboard_widgets' );

// remove unwanted dashboard widgets for relevant users
function hiilite_remove_dashboard_widgets() {
    $user = wp_get_current_user();
    remove_meta_box( 'dashboard_recent_comments', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_incoming_links', 'dashboard', 'normal' );
    remove_meta_box( 'dashboard_quick_press', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_primary', 'dashboard', 'side' );
    remove_meta_box( 'dashboard_secondary', 'dashboard', 'side' );
}
add_action( 'wp_dashboard_setup', 'hiilite_remove_dashboard_widgets' );

// Move the 'Right Now' dashboard widget to the right hand side
function hiilite_move_dashboard_widget() {
    $user = wp_get_current_user();
        global $wp_meta_boxes;
        $widget = $wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now'];
        unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now'] );
        $wp_meta_boxes['dashboard']['side']['core']['dashboard_right_now'] = $widget;
	
		$widget2 = $wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity'];
        unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity'] );
        $wp_meta_boxes['dashboard']['side']['core']['dashboard_activity'] = $widget2;

}
add_action( 'wp_dashboard_setup', 'hiilite_move_dashboard_widget' );

/////////////////////////////////////////////////////
//
// let's start by enqueuing our styles correctly
//
////////////////////////////////////////////////////
function hiilite_admin_styles() {
    wp_register_style( 'hiilite_admin_stylesheet', plugins_url( '/css/style.css', __FILE__ ) );
    wp_enqueue_style( 'hiilite_admin_stylesheet' );
}
add_action( 'admin_enqueue_scripts', 'hiilite_admin_styles' );

function hiilite_front_scripts() {
	wp_register_style( 'hiilite_stylesheet', plugins_url( '/css/stylefixes.css', __FILE__ ) );
	wp_enqueue_style( 'hiilite_stylesheet');

} 

add_action( 'wp_enqueue_scripts', 'hiilite_front_scripts' );

//////////////////////////////////
//
//	Change the Admin footer text
//
//////////////////////////////////
function hiilite_admin_footer_text () {
    echo '<a href="https://hiilite.com/marketing-strategy/"><img src="' . plugins_url( 'images/hiilite-logo-lettermark.png' , __FILE__ ) . '"> Marketing</a>, <a href="https://hiilite.com/seo-social-media/">SEO</a>, <a href="https://hiilite.com/website-design/">Web Design </a> by <a href="https://hiilite.com/">Hiilite Marketing + Web Design in Kelowna</a>';
	?>
	<!-- Start of hiilite Zendesk Widget script -->
<script>/*<![CDATA[*/window.zEmbed||function(e,t){var n,o,d,i,s,a=[],r=document.createElement("iframe");window.zEmbed=function(){a.push(arguments)},window.zE=window.zE||window.zEmbed,r.src="javascript:false",r.title="",r.role="presentation",(r.frameElement||r).style.cssText="display: none",d=document.getElementsByTagName("script"),d=d[d.length-1],d.parentNode.insertBefore(r,d),i=r.contentWindow,s=i.document;try{o=s}catch(c){n=document.domain,r.src='javascript:var d=document.open();d.domain="'+n+'";void(0);',o=s}o.open()._l=function(){var o=this.createElement("script");n&&(this.domain=n),o.id="js-iframe-async",o.src=e,this.t=+new Date,this.zendeskHost=t,this.zEQueue=a,this.body.appendChild(o)},o.write('<body onload="document._l();">'),o.close()}("//assets.zendesk.com/embeddable_framework/main.js","hiilite.zendesk.com");/*]]>*/</script>
<!-- End of hiilite Zendesk Widget script -->
	<?php
}
add_filter( 'admin_footer_text', 'hiilite_admin_footer_text' );



//////////////////////////////////
//
//	Change the Theme footer text
//
//////////////////////////////////
/**
 * Adds scripts to the footer. Filters `wp_footer`.
 */
function hiilite_addfooter() {

	$hiilite_settings = hiilite_read_options();

	$hiilite_other = stripslashes( $hiilite_settings['hiilite_other'] );

	if ( '' != $hiilite_other ) {
		echo $hiilite_other;
	}

}
add_action( 'wp_footer', 'hiilite_addfooter' );

/**
 * Default options.
 *
 * @return array Array of default options
 */
function hiilite_default_options() {
	$hiilite_settings = array (
		'enable_plugin' => false,	// Enable plugin switch
		'disable_notice' => false,	// // Disable notice that is displayed when enable_plugin is false
		'hiilite_other' => '<div id="hiilite_admin_footer" style="width:100%;clear:both;background:#23282d;line-height:2em;color:white; text-align:center;">Copyright &copy; '.date('Y').' '.bloginfo('name').'. All rights reserved. <a style="color:white;" href="https://hiilite.com/">Kelowna Website Design</a>, <a style="color:white;" href="https://hiilite.com/marketing-strategy/">Strategic Marketing</a>, and <a style="color:white;" href="https://hiilite.com/seo-social-media/">SEO</a> by <a style="color:white;" href="https://hiilite.com/">Marketing and Web Agency Hiilite</a></div>'
	);
	return apply_filters( 'hiilite_default_options', $hiilite_settings );
}

/**
 * Function to read options from the database and add any new ones.
 *
 * @return array Options from the database
 */
function hiilite_read_options() {
	$hiilite_settings_changed = false;

	$defaults = hiilite_default_options();

	$hiilite_settings = array_map( 'stripslashes', (array) get_option( 'hiilite_settings' ) );
	unset( $hiilite_settings[0] ); // produced by the (array) casting when there's nothing in the DB

	// If there are any new options added to the Default Options array, let's add them
	foreach ( $defaults as $k=>$v ) {
		if ( ! isset( $hiilite_settings[ $k ] ) ) {
			$hiilite_settings[ $k ] = $v;
		}
		$hiilite_settings_changed = true;
	}

	if ( true == $hiilite_settings_changed ) {
		update_option( 'hiilite_settings', $hiilite_settings );
	}

	return apply_filters( 'hiilite_read_options', $hiilite_settings );
}



/**
 *  Admin option
 *
 */
if ( is_admin() || strstr( $_SERVER['PHP_SELF'], 'wp-admin/' ) ) {

	/**
	 *  Load the admin pages if we're in the Admin.
	 *
	 */
	require_once( HIILITE_DIR . "/admin.inc.php" );

	/**
	 * Adding WordPress plugin action links.
	 *
	 * @param array $links
	 * @return array
	 */
	function hiilite_plugin_actions_links( $links ) {

		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'options-general.php?page=hiilite_options' ) . '">' . __( 'Settings', 'add-to-footer' ) . '</a>'
			),
			$links
		);

	}
	add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'hiilite_plugin_actions_links' );

	/**
	 * Add meta links on Plugins page.
	 *
	 * @param array $links
	 * @param string $file
	 * @return array
	 */
	function hiilite_plugin_actions( $links, $file ) {
		static $plugin;
		if ( ! $plugin ) {
			$plugin = plugin_basename( __FILE__ );
		}

		// create link
		if ( $file == $plugin ) {
			$links[] = '<a href="http://wordpress.org/support/plugin/better-search">' . __( 'Support', 'add-to-footer' ) . '</a>';
			$links[] = '<a href="http://ajaydsouza.com/donate/">' . __( 'Donate', 'add-to-footer' ) . '</a>';
		}
		return $links;
	}
	add_filter( 'plugin_row_meta', 'hiilite_plugin_actions', 10, 2 ); // only 2.8 and higher

} // End admin.inc








//////////////////////////////////
//
//	Change Admin Menu Bar
//
//////////////////////////////////
add_action( 'admin_bar_menu', 'modify_admin_bar', 999 );

function modify_admin_bar( $wp_admin_bar ){
  // do something with $wp_admin_bar;
	$wp_admin_bar->remove_node( 'wporg' );
	$wp_admin_bar->remove_node( 'about' );
	$wp_admin_bar->remove_node( 'documentation' );
	$wp_admin_bar->remove_node( 'support-forums' );
	$wp_admin_bar->remove_node( 'feedback' );
	
	$wplogo = $wp_admin_bar->get_node( 'wp-logo' );
	$args = array(
		'id'    => 'hiilite_com',
		'title' => 'Hiilite.com',
		'href'  => 'http://hiilite.com',
		'meta'  => array( 'class' => 'hiilite_com' ),
		'parent' => $wplogo->id
	);
	$wp_admin_bar->add_node( $args );
	
	$args = array(
		'id'    => 'hiilite_marketing',
		'title' => 'Marketing',
		'href'  => 'http://www.hiilite.com/marketing-strategy/',
		'meta'  => array( 'class' => 'hiilite_marketing' ),
		'parent' => $wplogo->id
	);
	$wp_admin_bar->add_node( $args );
	
	$args = array(
		'id'    => 'hiilite_webdesign',
		'title' => 'Web Design',
		'href'  => 'http://www.hiilite.com/website-design/',
		'meta'  => array( 'class' => 'hiilite_webdesign' ),
		'parent' => $wplogo->id
	);
	$wp_admin_bar->add_node( $args );
	
	$args = array(
		'id'    => 'hiilite_seo',
		'title' => 'SEO',
		'href'  => 'http://www.hiilite.com/seo-social-media/',
		'meta'  => array( 'class' => 'hiilite_seo' ),
		'parent' => $wplogo->id
	);
	$wp_admin_bar->add_node( $args );
}

require_once dirname( __FILE__ ) . '/Plugin-Activation/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'hiilite_register_required_plugins' );


/**
 * Register the required plugins for this theme.
 *
 * In this example, we register two plugins - one included with the TGMPA library
 * and one from the .org repo.
 *
 * The variable passed to tgmpa_register_plugins() should be an array of plugin
 * arrays.
 *
 * This function is hooked into tgmpa_init, which is fired within the
 * TGM_Plugin_Activation class constructor.
 */
function hiilite_register_required_plugins() {

    /**
     * Array of plugin arrays. Required keys are name and slug.
     * If the source is NOT from the .org repo, then source is also required.
     */
    $plugins = array(

        // This is an example of how to include a plugin pre-packaged with a theme.
        array(
            'name'               => 'Backup Buddy', // The plugin name.
            'slug'               => 'backupbuddy-5.1.0.9', // The plugin slug (typically the folder name).
            'source'             => plugin_dir_path( __FILE__ ) . '/Plugin-Activation/plugins/backupbuddy-5.1.0.9.zip', // The plugin source.
            'required'           => false, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
        ),
		array(
            'name'               => 'WPBakery Visual Composer', // The plugin name.
            'slug'               => 'js_composer', // The plugin slug (typically the folder name).
            'source'             => plugin_dir_path( __FILE__ ) . '/Plugin-Activation/plugins/js_composer.zip', // The plugin source.
            'required'           => false, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
        ),
		array(
            'name'               => 'Gravity Forms', // The plugin name.
            'slug'               => 'gravityforms', // The plugin slug (typically the folder name).
            'source'             => plugin_dir_path( __FILE__ ) . '/Plugin-Activation/plugins/gravityforms.zip', // The plugin source.
            'required'           => false, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
        ),
		array(
            'name'               => 'Revolution Slider', // The plugin name.
            'slug'               => 'revslider', // The plugin slug (typically the folder name).
            'source'             => plugin_dir_path( __FILE__ ) . '/Plugin-Activation/plugins/revslider.zip', // The plugin source.
            'required'           => false, // If false, the plugin is only 'recommended' instead of required.
            'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
            'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
            'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
            'external_url'       => '', // If set, overrides default API URL and points to an external URL.
        ),

        // This is an example of how to include a plugin from the WordPress Plugin Repository.
        array(
            'name'      => 'InfiniteWP Client',
            'slug'      => 'iwp-client',
            'required'  => false,
        ), 
		array(
            'name'      => 'WP SEO Redirect 301',
            'slug'      => 'wp-seo-redirect-301',
            'required'  => false,
        ),
		array(
            'name'      => 'WordPress SEO by Yoast',
            'slug'      => 'wordpress-seo',
            'required'  => false,
        ),
		array(
            'name'      => 'Math Captcha',
            'slug'      => 'wp-math-captcha',
            'required'  => false,
        ),
		array(
            'name'      => 'Sucuri Security - Auditing, Malware Scanner and Security Hardening',
            'slug'      => 'sucuri-scanner',
            'required'  => false,
        ),
		array(
            'name'      => 'underConstruction',
            'slug'      => 'underconstruction',
            'required'  => false,
        ),
		array(
            'name'      => 'Limit Login Attempts',
            'slug'      => 'limit-login-attempts',
            'required'  => false,
        ),

    );

    /**
     * Array of configuration settings. Amend each line as needed.
     * If you want the default strings to be available under your own theme domain,
     * leave the strings uncommented.
     * Some of the strings are added into a sprintf, so see the comments at the
     * end of each line for what each argument will be.
     */
    $config = array(
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => false,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
            'page_title'                      => __( 'Install Hiilite Recommended Plugins', 'tgmpa' ),
            'menu_title'                      => __( 'Install Hiilite Plugins', 'tgmpa' ),
            'installing'                      => __( 'Installing Hiilite Plugin: %s', 'tgmpa' ), // %s = plugin name.
            'oops'                            => __( 'Something went wrong with the plugin API.', 'tgmpa' ),
            'notice_can_install_required'     => _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s).
            'notice_can_install_recommended'  => _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_install'           => _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s).
            'notice_can_activate_required'    => _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
            'notice_can_activate_recommended' => _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_activate'          => _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s).
            'notice_ask_to_update'            => _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s).
            'notice_cannot_update'            => _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s).
            'install_link'                    => _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
            'activate_link'                   => _n_noop( 'Begin activating plugin', 'Begin activating plugins' ),
            'return'                          => __( 'Return to Required Plugins Installer', 'tgmpa' ),
            'plugin_activated'                => __( 'Plugin activated successfully.', 'tgmpa' ),
            'complete'                        => __( 'All plugins installed and activated successfully. %s', 'tgmpa' ), // %s = dashboard link.
            'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );

    tgmpa( $plugins, $config );

}
?>