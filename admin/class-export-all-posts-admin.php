<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://wordpress.org/
 * @since      1.0.0
 *
 * @package    Export_All_Posts
 * @subpackage Export_All_Posts/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Export_All_Posts
 * @subpackage Export_All_Posts/admin
 * @author     vishal sharma <vishal@cmsminds.com>
 */
class Export_All_Posts_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Export_All_Posts_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Export_All_Posts_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/export-all-posts-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Export_All_Posts_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Export_All_Posts_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/export-all-posts-admin.js', array( 'jquery' ), $this->version, false );
		$params = array(
			'ajax_url' => admin_url( 'admin-ajax.php' ),
			'button_name'  => array(
				'export_all_posts' => __( 'Export', $this->plugin_name )
			)
		);
		wp_localize_script( $this->plugin_name, 'export_all_posts', $params);

	}

	public function outputCsv( $assocDataArray ) {

        if ( !empty( $assocDataArray ) ):

            $fp = fopen( 'php://output', 'w' );
            fputcsv( $fp, array_keys( reset($assocDataArray) ) );

            foreach ( $assocDataArray AS $values ):
                fputcsv( $fp, $values );
            endforeach;

            fclose( $fp );
        endif;

        exit();
    }

	public function export_all_posts(){
		global $wpdb;
		$res_posts = $wpdb->get_results( "SELECT * FROM `{$wpdb->prefix}posts` where `post_type`='post' and `post_status`='publish'", OBJECT );

        $posts= [];
        foreach ($res_posts as $key => $post) :

            $posts[$post->ID]['ID'] = $post->ID;
            $posts[$post->ID]['Title'] = $post->post_title;
            $posts[$post->ID]['Content'] = $post->post_content;
            $posts[$post->ID]['Status'] = $post->post_status;
            $posts[$post->ID]['Publish Date'] = $post->post_date;
           
        endforeach;

        return $this->outputCsv( $posts );
	}

}
