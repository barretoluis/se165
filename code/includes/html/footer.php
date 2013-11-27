<?php
/*
 * Footer HTML file
 */

//variables
$curYear = date('Y');
?>

<div class="footer">
	<?PHP if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == TRUE) { ?>
	<!--div id="footerShortcut" class="footerShortcut">
		<div id="icons">
			<a id="footer-menu" href="#sidr">(tracks)</a>
			<script>
				$(document).ready(function() {
					$('#footer-menu').sidr();
				});
			</script>
		</div>
	</div-->
	<?PHP } ?>
	<div class="footerCopy">
		<hr/>
		<p style ="margin-left: 50px;">&copy; Tackster.com <?php echo $curYear ?></p>
	</div>
</div>