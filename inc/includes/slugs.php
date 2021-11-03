<?php
/* 
* -------------------------------------------------------------------------------------
* @author: LFVC
* @copyright: (c) 2019 LFVC. All rights reserved
* -------------------------------------------------------------------------------------
* @since 1.0
*/

class PostSlugs {
	public function __construct() {
		add_action('admin_init', array( $this, 'settingsInit'));
		add_action('admin_init', array( $this, 'settingsSave'));
	}

	/* Fields
	-------------------------------------------------------------------------------
	*/
	public function settingsInit() {
		$this->addField('', array($this, 'slug_title'), '');
		$this->addField('movies_slug', array( $this, 'movies_slug'), __('Movies', 'mega') );
		$this->addField('tvshows_slug', array( $this, 'tvshows_slug'), __('TVShows', 'mega') );
	}

	/* Callbacks
	-------------------------------------------------------------------------------
	*/
	public function slug_title() {
		echo '<h3>'. __('mega: Permalink Settings', 'mega') .'</h3>';
	}

	public function movies_slug() {
		echo $this->input('movies_slug', 'movies', '/titanic/');
	}

	public function tvshows_slug() {
		echo $this->input('tvshows_slug', 'tvshows', '/the-walking-dead/');
	}

	/* Save settings
	-------------------------------------------------------------------------------
	*/
	public function settingsSave() {
		if ( ! is_admin() ) return;
		$this->saveField('movies_slug');
		$this->saveField('tvshows_slug');
	}

	/*Helpers
	-------------------------------------------------------------------------------
	*/
	public function input( $option_name, $placeholder = '', $type ) {
		$slug = get_option( $option_name );
		$value = ( isset( $slug ) ) ? esc_attr( $slug ) : '';
		$utype = ($type) ? '<code>'. $type .'</code>' : null;

		return '<code>'. home_url() .'/</code><input class="dt_permaliks_input" name="'. $option_name .'" type="text" class="regular-text code" value="'. $slug .'" placeholder="'. $placeholder .'" />'. $utype;
	}
	public function addField( $option_name, $callback, $title ){
		add_settings_field(
			$option_name, // id
			$title,       // setting title
			$callback,    // display callback
			'permalink',  // settings page
			'optional'    // settings section
		);
	}
	public function saveField( $option_name ){
		if ( isset( $_POST[$option_name] ) ) {
			$permalink_structure = sanitize_title( $_POST[$option_name] );
			$permalink_structure = untrailingslashit( $permalink_structure );

			update_option( $option_name, $permalink_structure );
		}
	}
}
new PostSlugs;
