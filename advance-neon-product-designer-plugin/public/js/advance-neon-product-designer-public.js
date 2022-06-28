(function( $ ) {
	'use strict';

	/**
	 * All of the code for your public-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

 	jQuery('input[name=anpd-bg]').change(function(){
	    var imageUrl = jQuery( 'input[name=anpd-bg]:checked' ).val();
	    jQuery('.anpd-editor').css('background-image', 'linear-gradient(0deg, rgb(57, 57, 57) 0%, rgb(0 0 0 / 23%) 35%),url(' + imageUrl + ')');
	});

	

	jQuery('input[name=tube]').change(function() {
	    jQuery('.tube-option').removeClass('anpd-highlight');
	    jQuery(this).parent('.tube-option').addClass('anpd-highlight');
  	});

  	jQuery('input[name=alignment]').change(function() {
	    jQuery('.anpd-alignment-label').removeClass('anpd-alignment-highlight');
	    jQuery(this).parent('.anpd-alignment-label').addClass('anpd-alignment-highlight');
	    var align = jQuery(this).val().toLowerCase();
    	jQuery('#anpd_text_editor').css('text-align', align);
  	});

  	jQuery('input[name=backing]').change(function() {
	    jQuery('.anpd-backing-label').removeClass('anpd-backing-highlight');
	    jQuery(this).parent('.anpd-backing-label').addClass('anpd-backing-highlight');
  	});

  	jQuery('input[name=size]').change(function() {
	    jQuery('.anpd-size-label').removeClass('anpd-size-highlight');
	    jQuery(this).parent('.anpd-size-label').addClass('anpd-size-highlight');
  	});

  	jQuery('input[name=font]').change(function() {
	    jQuery('.anpd-font-label').removeClass('anpd-font-highlight');
	    jQuery(this).parent('.anpd-font-label').addClass('anpd-font-highlight');
	    var font_name = jQuery(this).val();
	    jQuery('.andp-font-button .anpd-font-name').text(font_name);
	    jQuery('.andp-font-button .anpd-font-name,#anpd_text_editor').css('font-family',font_name);
  	});

  	jQuery('input[name=location]').change(function() {
	    jQuery('.anpd-loc-label').removeClass('anpd-loc-highlight');
	    jQuery(this).parent('.anpd-loc-label').addClass('anpd-loc-highlight');
  	});


  	jQuery('.andp-font-button').on('click', function(e) {
	  jQuery(this).toggleClass('anpd-active');
	  jQuery(".font-options").slideToggle();
	  e.preventDefault()
	});


  	jQuery('input[name=color]').change(function() {
	    var color = jQuery(this).val();
	    jQuery('.option-two').css('background-color', color);
	    jQuery('#anpd_text_editor').css('color', color);
	    jQuery('#anpd_text_editor').css('--anpd9987',color);
	    
  	});

  	// var shadow = jQuery('#anpd_text_editor').css('text-shadow');
  	jQuery('#shadow_on_off').change(function(){
  		jQuery('input[name=color]')
	    if (jQuery(this).is(':checked')) {
	    	jQuery('#anpd_text_editor').css('text-shadow','0 0 10px var(--anpd9987),0 0 21px var(--anpd9987),0 0 42px var(--anpd9987),0 0 62px var(--anpd9987),0 0 4px #fff');
	    }else{
	    	jQuery('#anpd_text_editor').css('text-shadow','none');
	    }
	});

  	jQuery('#anpd_text').keyup(function() {
  		var message = jQuery('#anpd_text').val().replace(/\r\n|\r|\n/g,"<br />");
  		var length = jQuery(this).val().length
  		jQuery('#anpd_text_editor').html(message);
  		var parent_width = jQuery('.anpd-editor').width();
  		var parent_lower_limit = parent_width*0.8;
  		var child_width = jQuery('#anpd_text_editor').width();
  		var font_size = jQuery('#anpd_text_editor').css('font-size');
		var replace_px = font_size.replace('px','');
		var new_font_size = replace_px*0.9;
  		if (child_width > parent_lower_limit) {
  			if (new_font_size > 10) {
  				jQuery('#anpd_text_editor').css('font-size',new_font_size+'px');
  			}
  		}
  		if (new_font_size < 80 && length < 10) {
			jQuery('#anpd_text_editor').css('font-size','80px');
  		}
	});

  	jQuery(document).ready(function(){
		var message = jQuery('#anpd_text').val().replace(/\r\n|\r|\n/g,"<br />");
		jQuery('#anpd_text_editor').html(message);
  	});
  	jQuery( "#anpd_text_editor" ).draggable();
})( jQuery );
