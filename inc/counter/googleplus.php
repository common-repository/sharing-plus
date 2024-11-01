<?php

function sharing_plus_format_googleplus_response( $response ) {
	$response = json_decode( $response, true );
	return isset( $response[0]['result']['metadata']['globalCounts']['count'] ) ? intval( $response[0]['result']['metadata']['globalCounts']['count'] ) : 0;
}


function sharing_plus_googleplus_generate_link( $link ) {
	return $link;
}

