(function( $ ) {
	'use strict';

	var $ = jQuery;
	jQuery(document).ready(function( $ ){
		$( '.add-row' ).on('click', function() {
			var row = $(this).parents('.inside_anpd').find( '.empty-row.custom-repeter-text' ).clone(true);
			row.removeClass( 'empty-row custom-repeter-text' ).css('display','table-row');
			row.insertBefore( $(this).parents('.inside_anpd').find('.anpd-table tbody>tr:last') );
			row.find(".font-options").addClass('anpd-font-select').select2({});
			row.find(".font-options.anpd-font-select").attr('name', row.find(".font-options.anpd-font-select").attr('data-name'));
			row.find(".anpd-font-select").removeClass('font-options');
			return false;
		});

		$( '.remove-row' ).on('click', function() {
			$(this).parents('tr').remove();
			return false;
		});

		// update input value from colors input
		jQuery(".getColor").on("change", function(){
			//Get Color
			var color = jQuery(this).val();
			console.log('color: '+color)
			//Show color code
			jQuery(this).siblings(".outputcolor").val(color);
		})
		
		// update input color value from input
		jQuery(".outputcolor").on("focusout", function(){
			//Get Color
			var color = jQuery(this).val();
			console.log('color: '+color)
			//Show color code
			jQuery(this).siblings(".getColor").val(color);
		})

		$(":not(.empty-row) .anpd-font-select").select2({});



		$('body').on('click', '.wc_multi_upload_image_button', function(e) {
			e.preventDefault();
			var button = $(this),
			custom_uploader = wp.media({
				title: 'Insert image',
				button: { text: 'Use this image' },
				multiple: false 
			}).on('select', function() {
				var attech_ids = '';
				attachments
				var attachments = custom_uploader.state().get('selection'),
				i = 0;
				attachments.each(function(attachment) {
					attech_ids = attachment['id'];
					if (attachment.attributes.type == 'image') {
						$(button).siblings('.anpd-img').find('img').attr('src', attachment.attributes.url);
						$(button).siblings('.anpd-img').find('a').attr('href', attachment.attributes.url);
					} else {
						$(button).siblings('.anpd-img').find('img').attr('src', attachment.attributes.url);
						$(button).siblings('.anpd-img').find('a').attr('href', attachment.attributes.url);
					}
					i++;
				});
				$(button).siblings('.attechments-ids').attr('value', attech_ids);
				$(button).siblings('.wc_multi_remove_image_button').show();
				$(button).siblings('.anpd-img').show();
			})
			.open();
		});

		$('body').on('click', '.wc_multi_remove_image_button', function() {
			$(this).hide();
			$(this).parent().find('.anpd-img').hide();
			$(this).siblings('.attechments-ids').attr('value', '');
			return false;
		});

	});
})( jQuery );
