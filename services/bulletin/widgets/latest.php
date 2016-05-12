<?php

class SpringDvsBulletinsLatest extends WP_Widget {
	function __construct() {

		parent::__construct(
			'springdvs_bulletins_latest',
			'Latest Bulletins',
			array('description' => 'Display lastest bulletins on SpringDVS network')
			);
		
			if (is_active_widget( false, false, $this->id_base )) {
				wp_enqueue_script('sdvs_bulletin_lastest', plugins_url('latest_client.js', __FILE__));
			}
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
		echo $before_title . 'Latest Bulletins on <em>' . $instance['uri'] ."</em>". $after_title;	
		$node = get_option('springdvs_node_hostname');
		$uri = $instance['uri'];
		?>
		<div id="sdvs-bulletins-latest-hostname"><?php echo $node; ?></div>
		<span id="sdvs-bulletins-latest-uri"></span>
		<script type="text/javascript">SdvsBulletinsLatestCli.request(<?php echo "'$uri','$node'" ?>);</script>
		<?php
	}
}


