<?php
global $post,$url_decode;
$url = 'https://www.googleapis.com/webfonts/v1/webfonts?key=AIzaSyBwjhzcfEEHD0cL0S90wDyvoKHLGJdwWvY';
$wp_nonce_url = wp_nonce_url( $url );
$test_url     = request_filesystem_credentials( $wp_nonce_url, '', false, false, null );
if ( $test_url ) {
	$url        = wp_remote_get( $url, array( 'timeout' => 120 ) );
	$url_decode = '';
	if ( is_array( $url ) ) {
		$url_decode = json_decode( $url['body'], true );
	}
} else {
	$url = wp_remote_get( plugin_dir_path( dirname( __FILE__ ) ) . 'admin/js/google-fonts.json', array( 'timeout' => 120 ) );
	$url_decode = '';
	if ( is_array( $url ) ) {
		$url_decode = json_decode( $url['body'], true );
	}
}

function font_options($selected_font){
	global $url_decode;
	echo '<option value="">' . __( 'Pick a google font', 'anpd-neon-product-designer' ) . ' </option>';
	foreach ( $url_decode['items'] as $font ) {
		if ( isset( $font['family'] ) && isset( $font['files'] ) && isset( $font['files']['regular'] ) ) {
			$selected = '';
			if ( $selected_font === rawurlencode( esc_attr($font['family']) ) . '_x_'.rawurlencode( esc_attr($font['files']['regular']) ) ) {
				$selected = 'selected';
			}
			echo '<option value="' . rawurlencode( esc_attr($font['family']) ) . '_x_'.rawurlencode( esc_attr($font['files']['regular']) ).'" ' . esc_attr($selected) . '>' . esc_attr($font['family']) . '</option> ';
		}
	}
}

global $sizes_raw,$sizes_data;
$size_groups = array('GroupA' => 'Group A','GroupB' => 'Group B','GroupC' => 'Group C','GroupD' => 'Group D');
$sizes = array('small' => 'Small','medium' => 'Medium','large' => 'Large','x_large' => 'X Large','xx_large' => 'XX Large','supersized' => 'Supersized' );
$sizes_prams = array('z' => '','y' => '','m' => '','r' => '','x' => '','w' => '','h' => '','k' => '','p' => '');
foreach ($sizes as $key => $size) {
	$sizes_raw[$key] = array(
		'Lable' => $size, 
		'prams' => $sizes_prams,
	);
}
foreach ($size_groups as $key =>  $size_group) {
	$sizes_data[$key] = array(
		'G_Lable' => $size_group, 
		'G_data' => $sizes_raw,
	);
}
$anpd_font_group = get_post_meta($post->ID, 'anpd_font_group', true);
wp_nonce_field( 'repeterBox-fonts', 'anpd-fonts' );
if ( $anpd_font_group ){ 
	foreach ( $anpd_font_group as $sizes_group_key => $field ) {
		?>
<div class="anpd_fornt_wrapper">
	<h4><?php echo $sizes_group_key; ?></h4>
	<div class="inside_anpd">
		<table class="anpd-table" id="repeatable-fieldset-one" width="100%">
			<thead>
				<tr>
					<th>font</th>
					<th>Remove</th>
				</tr>
			</thead>
			<tbody>

				<?php 
					$field['font'] = array_filter($field['font']);
					if (!empty($field['font'])) {
				?>
				<?php foreach ($field['font'] as $key => $value) { ?>
				<tr>
					<td>
						
						<select style="width:98%;" class="form-control anpd-font-select" name="<?php echo 'groupdata['.$sizes_group_key.']'.'[font][]'; ?>">

						  	<?php
								font_options($value);
							?>
						</select>
					</td>
					<td style="text-align: center;"><a class="button remove-row" href="#1">Remove</a></td>
				</tr>
				<?php }
			}else{ ?>
				<tr>
					<td>
						<select style="width:98%;" class="form-control anpd-font-select" name="<?php echo 'groupdata['.$sizes_group_key.']'.'[font][]'; ?>">
							<?php
							  	$font_not_selected = '';
								font_options($font_not_selected);
							?>
						</select>
					</td>
					<td style="text-align: center;"><a class="button  cmb-remove-row-button button-disabled" href="#">Remove</a></td>
				</tr>
			<?php } ?>
			<tr class="empty-row custom-repeter-text" style="display: none">
					<td>
						<select style="width:98%;" class="form-control font-options" data-name="<?php echo 'groupdata['.$sizes_group_key.']'.'[font][]'; ?>">
							<?php
							$font_not_selected = '';
								font_options($font_not_selected);
							?>
						</select>
					</td>
					<td style="text-align: center;"><a class="button remove-row" href="#">Remove</a></td>
				</tr>
			</tbody>
		</table>
		<hr>
		<p><a id="add-row" class="button add-row" href="#">Add another</a></p>
		<hr>
	</div>
	<div>
		<table class="anpd-table-size" width="100%">
			<thead>
				<tr>
					<th>Label</th>
					<?php 
					$i = 0;
					foreach ($field['prams'] as $key_size_label => $sizes_pram) {
							if ($i == 0) { 
								foreach ($sizes_pram as $key => $value) { 
									if ($key == 'm') {$per = '%';}else{$per = '';}?>
									<th><?php echo $key.' '.$per; ?></th>
							<?php 
								}
							}
						$i++;
					} ?>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($field['prams'] as $key_size_label => $sizes_pram) { 
					$replace = str_replace('_', ' ', $key_size_label); ?>
						<tr>
							<td class="dark_font_size_label">
								<?php echo $replace; ?>
							</td>
							<?php foreach ($sizes_pram as $key => $value) { 
								?>
								<td>
									<input type="number" name="groupdata<?php echo '['.$sizes_group_key.'][prams]'.'['.$key_size_label.']['.$key.']'; ?>" min="0" step="0.00001" placeholder="<?php //echo $key; ?>" value="<?php echo $value; ?>">
								</td>
							<?php } ?>
						</tr>
				<?php } ?>
			</tbody>
		</table>	
	</div>
</div>
<?php 
}
}else{
	foreach ($sizes_data as $sizes_group_key => $size_data) {
?>
<div class="anpd_fornt_wrapper">
	<h4><?php echo $size_data['G_Lable']; ?></h4>
	<div class="inside_anpd">
	<table class="anpd-table" id="repeatable-fieldset-one" width="100%">
		<thead>
			<tr>
				<th>font</th>
				<th>Remove</th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td>
					<select style="width:98%;" class="form-control anpd-font-select" name="<?php echo 'groupdata['.$sizes_group_key.']'.'[font][]'; ?>">
						<?php
						  	$font_not_selected = '';
							font_options($font_not_selected);
						?>
					</select>
				</td>
				<td style="text-align: center;"><a class="button  cmb-remove-row-button button-disabled" href="#">Remove</a></td>
			</tr>
			<tr class="empty-row custom-repeter-text" style="display: none">
				<td>
					<select style="width:98%;" class="form-control font-options" data-name="<?php echo 'groupdata['.$sizes_group_key.']'.'[font][]'; ?>">
						<?php
						$font_not_selected = '';
							font_options($font_not_selected);
						?>
					</select>
				</td>
				<td style="text-align: center;"><a class="button remove-row" href="#">Remove</a></td>
			</tr>
		</tbody>
	</table>
	<hr>
	<p><a id="add-row" class="button add-row" href="#">Add another</a></p>
	<hr>
	</div>
	<div>
		<table class="anpd-table-size" width="100%">
			<thead>
				<tr>
					<th>Label</th>
					<?php foreach ($sizes_prams as $key => $sizes_pram) { 
						if ($key == 'm') {$per = '%';}else{$per = '';}?>
						<th><?php echo $key.' '.$per; ?></th>
					<?php } ?>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($size_data['G_data'] as $key_size_label => $value) { ?>
						<tr>
							<td class="dark_font_size_label">
								<?php echo $value['Lable']; ?>
							</td>
							<?php foreach ($value['prams'] as $key => $pram) { 
								?>
								<td>
									<input type="number" name="groupdata<?php echo '['.$sizes_group_key.'][prams]'.'['.$key_size_label.']['.$key.']'; ?>" min="0" step="0.00001" placeholder="<?php echo $key; ?>">
								</td>
							<?php } ?>
						</tr>
				<?php } ?>
			</tbody>
		</table>	
	</div>
</div>
<?php } 
} ?>
