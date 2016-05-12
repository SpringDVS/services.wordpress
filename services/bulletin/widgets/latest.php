<?php

class SpringDvsBulletinsLatest extends WP_Widget {
	function __construct() {

		parent::__construct(
			'springdvs_bulletins_latest',
			'Latest Bulletins',
			array('description' => 'Display lastest bulletins on SpringDVS network')
			);
		
			if (is_active_widget( false, false, $this->id_base )) {
				wp_enqueue_script('sdvs_bulletin_lastest_js', plugins_url('latest_client.js', __FILE__));
				wp_enqueue_style('sdvs_bulletin_lastest_css', plugins_url('latest_style.css', __FILE__));
			}
	}
	
	function form( $instance ) {
		$defaults = array(
			'network' => 'esusx.uk',
			'query' => '',
		);
		
		$network = $instance['network'];
		$query = $instance['query'];
		?>
		<label for="<?php echo $this->get_field_id( 'network' ); ?>">Network:</label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'network' ); ?>" name="<?php echo $this->get_field_name( 'network' ); ?>" value="<?php echo esc_attr( $network ); ?>">
		<label for="<?php echo $this->get_field_id( 'query' ); ?>">Query:</label>
		<input class="widefat" type="text" id="<?php echo $this->get_field_id( 'query' ); ?>" name="<?php echo $this->get_field_name( 'query' ); ?>" value="<?php echo esc_attr( $query ); ?>">
		<?php
	} 
	
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;
		$instance['network'] = strip_tags($new_instance['network']);
		$instance['query'] = strip_tags($new_instance['query']);
		return $instance;
	}
	
	function widget( $args, $instance ) {
		extract( $args );
		echo $before_widget;
		$loader = "<img class='sdvs-loader' id='spring-bulletin-loader' src=".plugins_url('../../../res/load.gif', __FILE__).">";
		echo $before_title . 'Latest Bulletins on <em>' . $instance['network'] ."</em>$loader". $after_title;	
		$node = get_option('springdvs_node_hostname');
		$uri = $instance['network'];
		$query = $instance['query'];
		?>
		<div class="spring-bulletin">
			<table class="wp-list-table widefat  striped main">
				<tbody class="the-list" id="sdvs-bulletin-list-body">
				</tbody>
			</table>
		</div>
		<script type="text/javascript">SdvsBulletinsLatestCli.request(<?php echo "'$uri','$node','$query'" ?>);</script>
		<?php
	}
}


