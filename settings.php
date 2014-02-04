<?php


add_action( 'admin_init', 'aps_admin_init' );

function aps_admin_init() {

	add_settings_field( 
		'aps_interval', 
		__( 'Post Scheduling Interval', 'automatic-post-scheduler' ), 
		'aps_render_settings_interval', 
		'writing' 
	);

	register_setting( 
		'writing', 
		'aps_interval', 
		'aps_render_settings_interval_sanitize' 
	);

}


add_filter( 'plugin_action_links_' . plugin_basename( dirname( __FILE__ ) . '/plugin.php' ), 'aps_plugin_settings_link' );

function aps_plugin_settings_link( $links ) {
	
	$links[] = sprintf( 
		'<a href="%s">%s</a>', 
		admin_url( 'options-writing.php#aps-settings' ), 
		__( 'Settings', 'automatic-post-scheduler' ) 
	);
	
	return $links;

}


function aps_get_interval_boundaries() {

	$default = array( 
		'min' => 900, 
		'max' => 1800 
	);

	$interval = get_option( 'aps_interval', $default );

	if ( ! is_array( $interval ) )
		$interval = $default;

	if( ! isset( $interval['min'] ) || ! is_numeric( $interval['min'] ) )
		$interval['min'] = $default['min'];

	if( ! isset( $interval['max'] ) || ! is_numeric( $interval['max'] ) )
		$interval['max'] = $interval['min'];

	if( $interval['min'] > $interval['max'] )
		$interval['max'] = $interval['min'];
	
	return $interval;

}


function aps_render_settings_interval() {

	$int = aps_get_interval_boundaries();

	$min = intval( $int['min'] / 60 );
	$max = intval( $int['max'] / 60 );
	
	$min_unit = $max_unit = 'min';
	
	if( intval( $min / 60 ) ) {
		$min_unit = 'hour';
		$min = intval( $min / 60 );
		if( intval( $min / 24 ) ) {
				$min_unit = 'day';
				$min = intval( $min / 24 );
		}
	}
	
	if( intval( $max / 60 ) ) {
		$max_unit = 'hour';
		$max = intval( $max / 60 );
		if( intval( $max / 24 ) ) {
			$max_unit = 'day';
			$max = intval( $max / 24 );
		}
	}
	
	function aps_select_unit( $id = '', $value = null, $name = '' ) {

		$options = array(
			'min' => _x( 'minutes', 'Schedule post in X minutes', 'automatic-post-scheduler' ),
			'hour' => _x( 'hours', 'Schedule post in X hours', 'automatic-post-scheduler' ),
			'day' => _x( 'days', 'Schedule post in X days', 'automatic-post-scheduler' )
		);

		if( empty( $name ) )
			$name = $id;

		?>
			<select id="<?php echo esc_attr( $id ); ?>" name="<?php echo esc_attr( $name ); ?>">
			<?php foreach( $options as $key => $v ) : ?>
				<option value="<?php echo esc_attr( $key ); ?>" <?php selected( $value, $key ); ?>>
					<?php echo esc_html( $v ); ?>
				</option>
			<?php endforeach; ?>
			</select>
		<?php

	}

	?>
	<div id="aps-settings">
		<label>
			<?php _e( 'Between', 'automatic-post-scheduler' ); ?>
			<input type="text" id="aps_interval_min" class="small-text" name="aps_interval[min]" value="<?php echo esc_attr( $min ); ?>" />
		</label>
		<?php aps_select_unit( 'aps_interval_min_unit', $min_unit, 'aps_interval[min_unit]' ); ?>

		<label for="aps_interval_max">
			<?php _e( 'to', 'automatic-post-scheduler' ); ?>
			<input type="text" id="aps_interval_max" class="small-text" name="aps_interval[max]" value="<?php echo esc_attr( $max ); ?>" />
		</label>
		<?php aps_select_unit( 'aps_interval_max_unit', $max_unit, 'aps_interval[max_unit]' ); ?>
		
		<p class="description">
			<?php esc_html_e( 'New posts will be scheduled to be published at this time interval.', 'automatic-post-scheduler' ); ?>
		</p>
	</div>
	<?php

}


function aps_render_settings_interval_sanitize( $data ) {

	$factors = array(
		'min' => 60,
		'hour' => 60 * 60,
		'day' => 60 * 60 * 24,
	);
	
	$data['min'] *= isset( $factors[$data['min_unit']] ) ? $factors[$data['min_unit']] : 1;
	$data['max'] *= isset( $factors[$data['max_unit']] ) ? $factors[$data['max_unit']] : 1;
	
	unset( $data['min_unit'], $data['max_unit'] );
	
	return $data;

}


function aps_current_user_disable_default( $uid = false ) {

	global $current_user;
	
	if( $uid === false )
		$uid = $current_user->ID;
	
	return (bool) get_user_meta( $uid, 'aps_disable_default', true );

}


add_filter( 'personal_options', 'aps_user_options' );

function aps_user_options( $user ) {

	if( ! user_can( $user->ID, 'publish_posts' ) )
		return;

	$disable_default = aps_current_user_disable_default();
	
	?>
	<tr>
		<th scope="row">
			<?php _e( 'Automatic Post Scheduler', 'automatic-post-scheduler' ); ?>
		</th>
		<td>
			<label>
				<input type="checkbox" value="1" <?php checked( $disable_default ); ?> name="aps_disable_default" id="aps_disable_default" /> <?php esc_html_e( 'Disable scheduling of my own posts by default (can be over-ridden for individual posts)', 'automatic-post-scheduler' ); ?>
			</label>
		</td>
	</tr>
	<?php
}


add_action( 'personal_options_update', 'aps_user_options_update' );
add_action( 'edit_user_profile_update', 'aps_user_options_update' );

function aps_user_options_update( $uid ) {

	$aps_disable_default = 0;

	if ( isset( $_POST['aps_disable_default'] ) )
		$aps_disable_default = 1;

	update_user_meta( 
		$uid, 
		'aps_disable_default', 
		$aps_disable_default
	);

}

