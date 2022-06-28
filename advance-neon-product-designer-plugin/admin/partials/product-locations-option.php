<?php
global $post;
$anpd_location_group = get_post_meta($post->ID, 'anpd_location_group', true);
wp_nonce_field( 'repeterBox-locations', 'anpd-locations' );
?>
<div class="inside_anpd">
	<table class="anpd-table anpd-locations-table" id="repeatable-fieldset-one" width="100%">
		<thead>
			<tr>
				<th>location</th>
				<th>location Price</th>
				<th>Remove</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if ( $anpd_location_group ) :
				foreach ( $anpd_location_group as $field ) {
					?>
					<tr>
						
						<td>
							<input type="text"  style="width:98%;" name="location_title[]" value="<?php if($field['location_title'] != '') echo esc_attr( $field['location_title'] ); ?>" placeholder="Title" />
						</td>
						<td>
							<input type="number" style="width:98%;" name="location_price[]" value="<?php if ($field['location_price'] != '') echo esc_attr( $field['location_price'] ); ?>" placeholder="Location Price" min="0" step="0.01"/>
						</td>
						<td style="text-align: center;">
							<a class="button remove-row" href="#1">Remove</a>
						</td>
					</tr>
					<?php
				}
			else :
				?>
				<tr>
					
					<td><input type="text" style="width:98%;" name="location_title[]" placeholder="Location Title"/></td>
					<td><input type="number" style="width:98%;" name="location_price[]" placeholder="Location Price" min="0" step="0.01"/></td>
					<td style="text-align: center;"><a class="button  cmb-remove-row-button button-disabled" href="#">Remove</a></td>
				</tr>
			<?php endif; ?>
			<tr class="empty-row custom-repeter-text" style="display: none">
				
				<td><input type="text" style="width:98%;" name="location_title[]" placeholder="Location Title"/></td>
				<td><input type="number" style="width:98%;" name="location_price[]" placeholder="Price" min="0" step="0.01"/></td>
				<td style="text-align: center;"><a class="button remove-row" href="#">Remove</a></td>
			</tr>
			
		</tbody>
	</table>
	<hr>
	<p><a id="add-row" class="button add-row" href="#">Add another</a></p>
</div>