<?php
global $post;
$anpd_color_group = get_post_meta($post->ID, 'anpd_color_group', true);
wp_nonce_field( 'repeterBox-colors', 'anpd-colors' );
?>
<div class="inside_anpd">
	<table class="anpd-table anpd-locations-table" id="repeatable-fieldset-one" width="100%">
		<thead>
			<tr>
				<th>Title</th>
				<th>Color</th>
				<th>Example Image</th>
				<th>Remove</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if ( $anpd_color_group ) :
				foreach ( $anpd_color_group as $field ) {
					$image_attributes = wp_get_attachment_image_src($field['color_exp_img'], 'full');
					?>
					<tr>
						<td><input type="text"  style="width:98%;" name="title[]" value="<?php if($field['title'] != '') echo esc_attr( $field['title'] ); ?>" placeholder="Title" /></td>
						<td><input class="getColor" type="color"  style="width:15%;" name="getcolor[]" value="<?php if ($field['getcolor'] != '') echo esc_attr( $field['getcolor'] ); ?>" /><input type="text" name="outputcolor[]" class="outputcolor" style="width:82%;" value="<?php if ($field['outputcolor'] != '') echo esc_attr( $field['outputcolor'] ); ?>"></td>
						<td>
							<div class="anpd-img">
								<a href="<?php echo esc_attr($image_attributes[0]); ?>" target="_blank"><img class="true_pre_image" src="<?php echo esc_attr($image_attributes[0]); ?>" /></a>
								
							</div>
							<a href="#" class="wc_multi_upload_image_button button">Update Media</a>
							<input type="hidden" class="attechments-ids" name="color_exp_img[]" value="<?php echo $field['color_exp_img']; ?>" />
						</td>
						<td style="text-align: center;"><a class="button remove-row" href="#1">Remove</a></td>
					</tr>
					<?php
				}
			else :
				?>
				<tr>
					<td><input type="text" style="width:98%;" name="title[]" placeholder="Title"/></td>
					<td><input class="getColor" type="color"  style="width:15%;" name="getcolor[]" /><input type="text" name="outputcolor[]" class="outputcolor" style="width:82%;"></td>
					<td>
						<div class="anpd-img">
							<a href="" target="_blank"><img class="true_pre_image" src="" /></a>
						</div>
						<a href="#" class="wc_multi_upload_image_button button">Add Media</a>
						<a href="#" class="wc_multi_remove_image_button button" style="display: none;">Remove media</a>
						<input type="hidden" class="attechments-ids" name="color_exp_img[]" />
					</td>
					<td style="text-align: center;"><a class="button  cmb-remove-row-button button-disabled" href="#">Remove</a></td>
				</tr>
			<?php endif; ?>
			<tr class="empty-row custom-repeter-text" style="display: none">
				<td><input type="text" style="width:98%;" name="title[]" placeholder="Title"/></td>
				<td><input class="getColor" type="color" style="width:15%;" name="getcolor[]" /><input type="text" name="outputcolor[]" class="outputcolor" style="width:82%;"></td>
				<td>
					<div class="anpd-img">
							<a href="" target="_blank"><img class="true_pre_image" src="" /></a>
						</div>
						<a href="#" class="wc_multi_upload_image_button button">Add Media</a>
						<a href="#" class="wc_multi_remove_image_button button" style="display: none;">Remove media</a>
						<input type="hidden" class="attechments-ids" name="color_exp_img[]" />
				</td>
				<td style="text-align: center;"><a class="button remove-row" href="#">Remove</a></td>
			</tr>
			
		</tbody>
	</table>
	<hr>
	<p><a id="add-row" class="button add-row" href="#">Add another</a></p>
</div>