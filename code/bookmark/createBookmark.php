<?php

/**
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'Bookmark/Bookmark.class.php';
$bookmarkObj = new bookmark();
$url = $_POST['url'];
$description = $_POST['description'];
$keywords = $_POST['keywords'];

$bookmarkDataArray = array('url' => $url,
	'description' => $description,
	'keywords' => $keywords);
$bookmarkObj->createBookmark($bookmarkDataArray);

echo "bookmark created";

echo "$url";
echo "$description";
echo "$keywords";
$tags = get_meta_tags($url);
echo $tags['description'];
?>
