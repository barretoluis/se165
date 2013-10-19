<?php

//require_once 'DataBase.php';
/**
 * This class provides information pertaining to bookmarks.
 * It contains a URL, a description and keywords. The UI takes these variables
 * to display the 
 */
class Bookmark {

	private $url;
	private $description;
	private $keywords;
        /**
         * This function creates a bookmark from the passed data.
         * @param type $bookmarkDataArray This is the data about a bookmark passed in as an array.
         */
	public function createBookmark($bookmarkDataArray) {
		$this->url = $bookmarkDataArray['url'];
		$this->description = $bookmarkDataArray['description'];
		$this->keywords = $bookmarkDataArray['keywords'];
		// $this->checkDescription($bookmarkUrl);
	}
        /** This function is desgined to take meta tags automatically from a URL.
         * This is done by looking at meta tags from the passed URL
         * Currently this function is not fully implemented, it only shows an example website and meta tags.
         * @param type $bookmarkUrl The passed URL that meta tags will be taken from.
         */
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

?>
