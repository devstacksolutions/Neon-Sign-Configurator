<?php
global $post;
$anpd_background_group = get_post_meta($post->ID, 'anpd_background_group', true);
wp_nonce_field( 'repeterBox-backgrounds', 'anpd-backgrounds' );
?>
<div class="inside_anpd">
	<table class="anpd-table anpd-locations-table" id="repeatable-fieldset-one" width="100%">
		<thead>
			<tr>
				<th>Background</th>
				<th>Remove</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if ( $anpd_background_group ) :
				foreach ( $anpd_background_group as $field ) {
					?>
					<tr>
						<td>
							<?php 
								$image_attributes = wp_get_attachment_image_src($field['backgrounds_img'], 'full');
							?>
							<div class="anpd-img">
								<a href="<?php echo esc_attr($image_attributes[0]); ?>" target="_blank"><img class="true_pre_image" src="<?php echo esc_attr($image_attributes[0]); ?>" /></a>
								
							</div>
							<a href="#" class="wc_multi_upload_image_button button">Update Media</a>
							<input type="hidden" class="attechments-ids" name="backgrounds_img[]" value="<?php echo esc_attr($field['backgrounds_img']); ?>" />
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
					<td>
						<div class="anpd-img">
							<a href="" target="_blank"><img class="true_pre_image" src="" /></a>
						</div>
						<a href="#" class="wc_multi_upload_image_button button">Add Media</a>
						<a href="#" class="wc_multi_remove_image_button button" style="display: none;">Remove media</a>
						<input type="hidden" class="attechments-ids" name="backgrounds_img[]" />
					</td>
					<td style="text-align: center;"><a class="button  cmb-remove-row-button button-disabled" href="#">Remove</a></td>
				</tr>
			<?php endif; ?>
			<tr class="empty-row custom-repeter-text" style="display: none">
				<td>
					<div class="anpd-img">
						<a href="" target="_blank"><img class="true_pre_image" src="" /></a>
					</div>
					<a href="#" class="wc_multi_upload_image_button button">Add Media</a>
					<a href="#" class="wc_multi_remove_image_button button" style="display: none;">Remove media</a>
					<input type="hidden" class="attechments-ids" name="backgrounds_img[]" />
				</td>
				<td style="text-align: center;"><a class="button remove-row" href="#">Remove</a></td>
			</tr>
			
		</tbody>
	</table>
	<hr>
	<p><a id="add-row" class="button add-row" href="#">Add another</a></p>
</div>