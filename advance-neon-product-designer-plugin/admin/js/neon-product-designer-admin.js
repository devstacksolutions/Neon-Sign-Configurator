(function( $ ) {
	'use strict';

	$( document ).ready(
		function () {

			$('#user-manual').parent().attr('target', '_blank');
			// $( ".repeatable-fields-table .anpd-default-radio" ).each(function( index, value ) {
			// console.log($('.repeatable-fields-table .anpd-default-radio:first-child'));
			// $('.repeatable-fields-table tr:first-of-type .anpd-default-radio').trigger("click");

			// });

			// manage defaut radio button in config
			$( document ).on(
				"change",
				".anpd-default-radio",
				function (e) {
					// wordpress 5.6
					$( this ).parents( ".repeatable-fields-table" ).find( "input[type=radio]" ).attr( 'value',0 );
					$( this ).parents( ".repeatable-fields-table" ).find( "input[type=radio]" ).not( $( this ) ).prop( 'checked', false );
					if ($( this ).is( ':checked' )) {
						$( this ).attr( 'value',1 );
					} else {
						$( this ).attr( 'value',0 );
					}

				}
			);

			$( document ).on(
				"change",
				".anpd-colors-group",
				function () {
					get_colors_field_based_on_type();
				}
			);

			if ($( '.anpd-colors-group' ).length) {
				get_colors_field_based_on_type();
			}

			function get_colors_field_based_on_type()
			{
				if ($( "input[name='anpd-metas[use-global-colors]']:checked" ).val() === "no") {

					$( "input[name='anpd-metas[use-global-colors]']" ).parent().parents( ".anpd-colors-group" ).next().show();

				} else {

					$( "input[name='anpd-metas[use-global-colors]']" ).parent().parents( ".anpd-colors-group" ).next().hide();
					$( "#anpd-colors-selector" ).attr( "required", false );
				}

			}

			// we delay the init to avoid conflicts with plugin that hook on the select2 classes and create conflicts
			setTimeout(
				function () {
					$( "#font" ).select2( {allowClear: true} );
				},
				500
			);

			load_select2();

			function load_select2(container)
			{
				if (typeof container == "undefined") {
					container = "";
				}
				$( container + " select.vc-select2" ).each(
					function () {
						$( this ).select2( {allowClear: true} );
					}
				);
			}

			$( document ).on(
				'change',
				'#font',
				function () {
					var name = $( '#font  option:selected' ).text();
					var url = $( '#font   option:selected' ).val();
					$( '.font_auto_name' ).val( name );
					$( '.font_auto_url' ).val( url );
				}
			);

			// Config metabox option js
			$( document ).on(
				"change",
				"#anpd-texts-options, input[name='anpd-metas[texts-options][visible-tab]']",
				function (e) {
					var checked = $( this ).is( ":checked" );
					$( "#anpd-texts-options tr:not(:first-child) input[name^='anpd-metas[texts-options]'][type='checkbox']" ).prop( "checked", checked );
				}
			);

			$( document ).on(
				"change",
				"#anpd-toolbar-options input[name='anpd-toolbar-options[visible-tab]']",
				function(e){
					var checked = $( this ).is( ":checked" );
					$( "#anpd-toolbar-options tr:not(:first-child) input[name^='anpd-toolbar-options'][type='checkbox']" ).prop( "checked", checked );
				}
			);

			$( "#select-fonts" ).select2( {placeholder: "Select fonts", width: '100%'} );

			$( "#anpd-colors-selector" ).select2( {placeholder: "Select colors", width: '100%'} );

			$( "#select-additional-options" ).select2( {placeholder: "Select Custom options", width: '100%'} );
			

			$( "#select-fonts" ).attr( "required", true );

			// font-family-dependance
			if ($( "input[name='anpd-metas[texts-options][ffamily]']" ).attr( 'checked' ) == "checked") {

				$( ".font-active" ).parents( 'tr' ).show();
			} else {
				$( ".font-active" ).parents( 'tr' ).hide();
			}

			// font-dependance
			if ($( "input[name='anpd-metas[texts-options][font-size]']" ).attr( 'checked' ) == "checked") {

				$( ".font-dependance" ).parents( 'tr' ).show();
			} else {
				$( ".font-dependance" ).parents( 'tr' ).hide();
			}

			$( document ).on(
				"change",
				"#anpd-texts-options input[name='anpd-metas[texts-options][font-size]']",
				function (e) {
					var checked = $( this ).is( ":checked" );
					if (checked) {
						$( ".font-dependance" ).parents( 'tr' ).show();
					} else {
						$( ".font-dependance" ).parents( 'tr' ).hide();
					}

				}
			);

			if ($( "input[name='anpd-metas[texts-options][text-color]']" ).attr( 'checked' ) == "checked") {

				$( ".color-dependance" ).parents( 'tr' ).show();
			} else {
				$( ".color-dependance" ).parents( 'tr' ).hide();
			}

			$( document ).on(
				"change",
				"#anpd-texts-options input[name='anpd-metas[texts-options][text-color]']",
				function (e) {
					var checked = $( this ).is( ":checked" );
					console.log( checked );
					if (checked) {
						$( ".color-dependance" ).parents( 'tr' ).show();
					} else {
						$( ".color-dependance" ).parents( 'tr' ).hide();
					}

				}
			);

			function dataToBlob(dataURI) {
				var get_URL = function () {
					return window.URL || window.webkitURL || window;
				};
				var byteString = atob( dataURI.split( ',' )[1] ),
				mimeString = dataURI.split( ',' )[0].split( ':' )[1].split( ';' )[0],
				arrayBuffer = new ArrayBuffer( byteString.length ),
				_ia = new Uint8Array( arrayBuffer );

				for (var i = 0; i < byteString.length; i++) {
					_ia[i] = byteString.charCodeAt( i );
				}

				var dataView = new DataView( arrayBuffer );
				var blob = new Blob( [dataView], { type: mimeString } );
				return { blob: get_URL().createObjectURL( blob ), data: dataURI };
			}

			$( document ).on(
				'click',
				'.anpd_admin_download_image',
				function (e) {
					e.preventDefault();
					var imgageData = $( this ).attr( "href" );
					var preview_img = dataToBlob( imgageData ).blob;
					var downloadLink = document.createElement( "a" );
					downloadLink.href = preview_img;
					downloadLink.download = "custom_neon" + ".png";
					document.body.appendChild( downloadLink );
					downloadLink.click();
					document.body.removeChild( downloadLink );
				}
			)
		}
	);

})( jQuery );
