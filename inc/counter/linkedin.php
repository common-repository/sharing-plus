<?php


function sharing_plus_linkedin_generate_link( $url ) {
	$request_url = 'https://www.linkedin.com/countserv/count/share?url=' . $url . '&format=json';
	return $request_url;
}


function sharing_plus_format_linkedin_response( $response ) {
	$response = json_decode( $response, true );
	return isset( $response['count'] ) ? intval( $response['count'] ) : 0;
}
