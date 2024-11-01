(function( $ ) {
	'use strict';

/**
* All of the code for your admin-facing JavaScript source
* should reside in this file.
*
*
* Ideally, it is not considered best practise to attach more than a
* single DOM-ready or window-load handler for a particular page.
* Although scripts in the WordPress core, Plugins and Themes may be
* practising this, we should strive to set a better example in our own work.
*/

$( document ).ready( function() {
	$( '[data-toggle="tooltip"]' ).tooltip();

// Get accepted values on load
if ($( '#accepted-values' ).length > 0 ) {
	database_api( 'build_values_list' , 'getvalues' , WP_JAM_KIT.security );  
}

// Tigger a click event for to save settings
// ajax call for all form data to be stored
// in the options table
$( '#save-settings' ).click( function( event ) {
	event.preventDefault();
	$( '#WC-id' ).attr( 'disabled' , false );
	var data_send = $( '#settings-form' ).serializeArray();
	database_api( 'save_settings' , data_send , WP_JAM_KIT.security );
	form_selction();
});

// This calls the copy to clipboard function when the clipboard button is clicked.
$( '#copy-btn-id' ).click( function () {
	copy_to_clipboard( '#created-url' );
});

// This calls the copy to clipboard function when the link is clicked.
$( '.copy-btn-div' ).click( function () {
	copy_to_clipboard( '#created-url' );
});

$( '#type-form' ).change( function() {
	$( '#type-form' ).val($( this ).val());
	if ($( '#type-form' ).val() == 'Gravity Forms') {
		$( 'form#settings-form input' ).attr( 'readonly' , true );
		$( 'form#settings-form select:not( #type-form )' ).attr( 'disabled' , true );
	} else {
		$( 'form#settings-form input:not( #created-url )' ).attr( 'readonly' , false );
		$( 'form#settings-form select' ).attr( 'disabled' , false );
	}
});

}); // End of $( document ).ready();

// For created url copy to clipboard
function copy_to_clipboard( element ) {
	var $temp = $( "<input>" );
	$( "body" ).append( $temp );
	$temp.val($( element ).val()).select();
	document.execCommand( "copy" );
	$temp.remove();
}

// This is for sending data to update in the database or pull data from the database.
function database_api( action , data , security ) {
	var postMessage = $( '#message' );
	var loading = $( '#save-settings .glyphicon' );
	loading.show();
	var data_to_send = { 
		action: action, 
		data: data,
		security: security
	};

// this is the ajax post.
$.ajax({
	type: "POST",
	dataType: "json",
	url: ajaxurl,
	data: data_to_send,
	success: function( result ) {

// this is for clearing the inputs form.
$( '[name="input-para"]' ).val('');

// This section is run when a value item is removed.
if ( action == 'remove_value_item' ) {
	postMessage.addClass( 'updated' );
	postMessage.html( '<p>The accepted value ' + data + ' has been removed.</p>' );
	build_accepted_values( result.data );
	$( '#message>p' ).delay( 5000 ).slideUp( 500 );
	$( '#message>p' ).queue( function() {
		$( '#message' ).removeClass( 'updated' ).dequeue();
	});
	$( '#created-url' ).val('');
}

// This section is run when the settings are save by clicking the save button.
if ( action == 'save_settings' ) {
	if ( ( true === result.success ) && ( result.data !== '' ) ) {
		postMessage.addClass( 'updated' );
		postMessage.html( '<p>' + WP_JAM_KIT.success + '</p>' );
		$( '#message>p' ).delay( 5000 ).slideUp( 500 );
		$( '#message>p' ).queue( function() {
			$( '#message' ).removeClass( 'updated' ).dequeue();
		});
		$( '#created-url' ).val('');
		build_accepted_values( result.data );
	} else {
		postMessage.addClass( 'error' );
		postMessage.html( '<p>' + WP_JAM_KIT.failure + '</p>' );
		$( '#message>p' ).delay( 5000 ).slideUp( 500 );
		$( '#message>p' ).queue( function() {
			$( '#message' ).removeClass( 'error' ).dequeue();
		});
	}
}

// This section is run when the list is first being built on the settings page.
if ( action == 'build_values_list' ) {
	if ( ( true === result.success ) && ( result.data !== '' ) ) {
		build_accepted_values( result.data );
	} else {
		postMessage.addClass( 'error' );
		postMessage.html( '<p>' + WP_JAM_KIT.failure + '</p>' );
		$( '#message>p' ).delay( 5000 ).slideUp( 500 );
		$( '#message>p' ).queue( function() {
			$( '#message' ).removeClass( 'error' ).dequeue();
		});
	}
}
loading.hide();
},
// this section is run when the ajax post comes back with an error.
error: function( error ) {
	postMessage.addClass( 'error' );
	postMessage.html( '<p>' + WP_JAM_KIT.failure + '</p>' );
	$( '#message>p' ).delay( 5000 ).slideUp( 500 );
	$( '#message>p' ).queue( function() {
		$( '#message' ).removeClass( 'error' ).dequeue();
	});
	loading.hide();
}
});
}

// This is for parsing the accepted values list on the WP-Jam-Session settings page.
function build_accepted_values( values ) {

// for refreshing all accepted values
$( 'div.value-containers' ).remove();

// This builds the list of accepted values
$.each( values , function ( i , val ) {
	$( '#accepted-values' ).append( '<li><div class="input-group value-containers" id="' + val + '"><input class="list-group-item" readonly value="' + val + '" /><span class="input-group-addon glyphicon glyphicon-remove-circle btn-danger removal-btn"></span></div></li>' );
});

$( '.list-group-item' ).hover( function() {
	$( this ).toggleClass( 'active' );
});

$( '.removal-btn' ).click( function () {
	var value_id = $( this ).parent( '.value-containers' ).attr( 'id' );
	database_api( 'remove_value_item' , value_id , WP_JAM_KIT.security );
});

$( '#accepted-values input.list-group-item' ).click( function () {
	var current_id = $( this ).parent( '.value-containers' ).attr( 'id' );
	var url_link = $( '#page-id' ).val();
	var url_para = $( '#url-para' ).val();
	$( '#message' ).addClass( 'updated' );
	$( '#message' ).html( '<p>Your link has been created below with accepted value ' + current_id + '.</p>' );
	$( '#created-url' ).val( url_link + '?' + url_para + '=' + current_id );

	$( '#message>p' ).delay( 5000 ).slideUp( 500 );
	$( '#message>p' ).queue( function() {
		$( '#message' ).removeClass( 'updated' ).dequeue();
	});
});
}
})( jQuery );