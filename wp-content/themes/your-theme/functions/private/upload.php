<?php

function my_upload_dir($uploads)
{

	//error_log(print_r($uploads, true));

	if (!isset($_POST['action']) || $_POST['action'] != 'upload-attachment')
		return $uploads;

	$id = intval($_POST['post_id']);
	if (get_post_type($id) != 'subscriber-blog')
		return $uploads;

	$directory = WP_CONTENT_DIR . '/uploads/private';
	if (!file_exists($directory))
		mkdir($directory, 0705, true);

	$uploads['subdir'] = '/subscriber-blog' . $uploads['subdir'];
	$uploads['path'] = str_replace('/uploads/', '/uploads/private/', $uploads['path']);
	$uploads['url'] = str_replace('/uploads/', '/uploads/private/', $uploads['url']);

	return $uploads;

}
add_filter('upload_dir', 'my_upload_dir');


function my_attached_action($action = '', $attachment_id = null, $parent_id = null)
{

	if (get_post_type($parent_id) != 'subscriber-blog')
		return;

	$meta = get_post_meta($attachment_id);
	$file = $meta['_wp_attached_file'][0];

	$path_parts = pathinfo(WP_CONTENT_DIR . '/uploads/' . $file);
	$glob = glob($path_parts['dirname'] . '/' . $path_parts['filename'] . '-' . $path_parts['extension'] . '*');
	$glob[] = $path_parts['dirname'] . '/' . $path_parts['basename'];

	if ($action == 'attach') {
		update_post_meta($attachment_id, '_wp_attached_file', 'private/' . $file);
		$from = '/uploads/';
		$dest = '/uploads/private/';
	}

	if ($action == 'detach') {
		update_post_meta($attachment_id, '_wp_attached_file', str_replace('private/', '', $file));
		$from = '/uploads/private/';
		$dest = '/uploads/';
	}

	$directory = WP_CONTENT_DIR . $dest . $file;
	if (!file_exists(dirname($directory)))
		mkdir(dirname($directory), 0705, true);

	foreach ($glob as $file) {
		$newFile = str_replace($from, $dest, $file);
		rename($file, $newFile);
	}

}
add_action('wp_media_attach_action', 'my_attached_action', 10, 3);
