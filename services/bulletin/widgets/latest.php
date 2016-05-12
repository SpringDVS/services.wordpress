<?php

class SpringDvsBulletinsLatest extends WP_Widget {
	function __construct() {

		parent::__construct(
			'springdvs_bulletins_latest',
			'Latest Bulletins',
			array('description' => 'Display lastest bulletins on SpringDVS network')
			);
	}
	
	function form( $instance ) {
		$defaults = array(
			'uri' => 'esusx.uk',
		);
		
		$uri = $instance['uri'];
		?>
		<label for="<?php echo $this->get_field_id( 'uri' ); ?>">Network:</label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'uri' ); ?>" name="<?php echo $this->get_field_name( 'uri' ); ?>" value="<?php echo esc_attr( $uri ); ?>">
		<?php
	} 
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['uri'] = strip_tags($new_instance['uri']);
		return $instance;
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		echo $before_widget;		
		echo $before_title . 'Latest Bulsletins on <em>' . $instance['uri'] ."</em>". $after_title;	
		echo "spring://{$instance['uri']}";
	}
	
	public static function conditionalScriptEnqueue($path) {
		if( is_active_widget( '', '', 'SpringDvsBulletinsLatest' ) ) {
			wp_enqueue_script("$path/latest_client.js");
		}
	}
}


