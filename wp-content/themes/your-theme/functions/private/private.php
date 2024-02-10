<?php

require_once(__DIR__. '/../../../../../wp-load.php');

if (!is_user_logged_in()) {
	wp_redirect(get_site_url() . "/login");
	exit;
}

$path = WP_CONTENT_DIR . '/uploads/private/' . $_GET['f'];

$data = file_get_contents($path);
if ($data === false) {
	echo ('Something went wrong.');
	exit;
}

header('Content-type: ' . mime_content_type($path));
echo $data;
