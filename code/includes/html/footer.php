<?php
/*
 * Footer HTML file
 */

//variables
$curYear = date('Y');
?>

<div class="footer">
	<div id="footerShortcut" class="footerShortcut">
		<div id="icons">
			<a href="#">(top)</a>
			<a id="footer-menu" href="#sidr">(tracks)</a>
			<a class='bookmark_popUp' href="/bookmark/createBookmark.php" title="Add Bookmark"><i class="fa fa-bookmark fa-lg"></i></a>
			<a class='track_popUp' href="/track/createTrack.php" title="Add Track"><i class="fa fa-folder-open fa-lg"></i></a>
			<script>
				$(document).ready(function() {
					$('#footer-menu').sidr();
				});
			</script>

		</div>
	</div>
	<div class="footerCopy">
		<hr/>
		<p style ="margin-left: 50px;">&copy; Tackster.com <?php echo $curYear ?></p>
	</div>
</div>