<?php

//require_once 'DataBase.php';

class Bookmark {

	private $url;
	private $description;
	private $keywords;

	public function createBookmark($bookmarkDataArray) {
		$this->url = $bookmarkDataArray['url'];
		$this->description = $bookmarkDataArray['description'];
		$this->keywords = $bookmarkDataArray['keywords'];
		// $this->checkDescription($bookmarkUrl);
	}

	public function checkDescription($bookmarkUrl) {
		/* $tags = get_meta_tags($bookmarkUrl);
		  echo $tags['keywords'];
		  echo $tags['description'];
		  if($tags != null)
		  {
		  echo $tags['keywords'];
		  echo $tags['description'];
		  }
		  return $tags; */

		$sites_html = file_get_contents('http://example.com');

		$html = new DOMDocument();
		@$html->loadHTML($sites_html);
		$meta_description = null;
		//Get all meta tags and loop through them.
		foreach ($html->getElementsByTagName('meta') as $meta) {
			//If the property attribute of the meta tag is og:image
			if ($meta->getAttribute('property') == 'description') {
				//Assign the value from content attribute to $meta_og_img
				echo $meta->getAttribute('content');
				$meta_description = $meta->getAttribute('content');
			}
		}
		echo $meta_description;
	}

}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
