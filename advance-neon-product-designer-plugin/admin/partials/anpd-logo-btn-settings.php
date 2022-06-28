<?php
global $post;
$anpd_logo_button_group = get_post_meta($post->ID, 'anpd_logo_button_group', true);
wp_nonce_field( 'repeterBox-logo_buttons', 'anpd-logo_buttons' );
?>
<div class="inside_anpd">
	<table class="anpd-table anpd-locations-table" id="repeatable-fieldset-one" width="100%">
		<thead>
			<tr>
				<th>Label</th>
				<th>Value</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if ( $anpd_logo_button_group ) :
				foreach ( $anpd_logo_button_group as $field ) {
					?>
					<tr>
						<td>
							<strong>Button Text</strong>
						</td>
						<td><input type="text"  style="width:98%;" name="logo_button_title[]" value="<?php if($field['logo_button_title'] != '') echo esc_attr( $field['logo_button_title'] ); ?>" placeholder="Button Title" /></td>
						
					</tr>
					<tr>
						<td>
							<strong>Button URL</strong>
						</td>
						<td><input type="text"  style="width:98%;" name="logo_button_URL[]" value="<?php if($field['logo_button_URL'] != '') echo esc_attr( $field['logo_button_URL'] ); ?>" placeholder="Button URL" /></td>
					</tr>
					<?php
				}
			else :
				?>
				<tr>
					<td>
						<strong>Button Text</strong>
					</td>
					<td><input type="text"  style="width:98%;" name="logo_button_title[]" placeholder="Button Title" /></td>
					
				</tr>
				<tr>
					<td>
						<strong>Button URL</strong>
					</td>
					<td><input type="text"  style="width:98%;" name="logo_button_URL[]" placeholder="Button URL" /></td>
				</tr>
			<?php endif; ?>
			
		</tbody>
	</table>
	<hr>
</div>