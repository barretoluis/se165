<?php
/*
 * Add additional include files to array if needed for this page.
 */
$includeFilesAdditional = array(
);




// DO NOT EDIT THIS BLOCK - START
/*
 * Require mandatory libraries to be loaded.
 * Else, redirect to server outage page.
 *
 */
try {
	// require the primary include file
	if (!include_once('main.php')) {
		throw new Exception("Unable to include the main library.\n");
	}
} catch (Exception $e) {
	throw new Exception('Was not able to include the main.php file.', 0, $e);
	header('HTTP/1.1 500 Internal Server Error', true, 500);
	exit(0);
}
// DO NOT EDIT THIS BLOCK - END




/*
 * Page specific PHP code here
 */
$ignorePageLogin = TRUE;
?><!DOCTYPE html>
<html>
	<head>
		<title>Tackster | Terms & Privacy</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Bootstrap -->
		<link href="/framework/bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
		<link href="/framework/bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

		<!-- Style Sheets -->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans+Condensed:700,300,300italic' rel='stylesheet' type='text/css'>
		<link href="/shared/css/base.css" rel="stylesheet" type="text/css">

		<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!--[if lt IE 9]>
		<script src="/framework/bootstrap/assets/js/html5shiv.js"></script>
		<script src="/framework/bootstrap/assets/js/respond.min.js"></script>
		<![endif]-->

		<!-- JavaScript -->
		<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
		<script src="/framework/jquery/jquery-1.10.2.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="/framework/bootstrap/js/bootstrap.min.js"></script>

	</head>


    <body>
		<!-- Navigation Bar -->
		<?php require_once('html/navbar.php'); ?>
		<!-- /Navigation Bar -->

		<!-- Body Content-->
		<div name="terms" class="main bodyContent" >
            <h3>Terms & Privacy</h3>
			<ul>
				<li><a href="#terms">Terms & Condition of Use</a></li>
				<li><a href="#privacy">Privacy</a></li>
			</ul>
			<hr>

			<a id="terms"></a>
			<h4>Web Site Terms and Conditions of Use</h4>

			<h5>1. Terms</h5>

			<p>By accessing this web site, you are agreeing to be bound by these web site Terms and Conditions of Use, all applicable laws and regulations, and agree that you are responsible for compliance with any applicable local laws. If you do not agree with any of these terms, you are prohibited from using or accessing this site. The materials contained in this web site are protected by applicable copyright and trade mark law.</p>

			<h5>2. Use License</h5>

			<ol type="a">
				<li>
					Permission is granted to temporarily download one copy of the materials (information or software) on Tackster's web site for personal, non-commercial transitory viewing only. This is the grant of a license, not a transfer of title, and under this license you may not:

					<ol type="i">
						<li>modify or copy the materials;</li>
						<li>use the materials for any commercial purpose, or for any public display (commercial or non-commercial);</li>
						<li>attempt to decompile or reverse engineer any software contained on Tackster's web site;</li>
						<li>remove any copyright or other proprietary notations from the materials; or</li>
						<li>transfer the materials to another person or "mirror" the materials on any other server.</li>
					</ol>
				</li>
				<li>This license shall automatically terminate if you violate any of these restrictions and may be terminated by Tackster at any time. Upon terminating your viewing of these materials or upon the termination of this license, you must destroy any downloaded materials in your possession whether in electronic or printed format.</li>
			</ol>

			<h5>3. Disclaimer</h5>

			<ol type="a">
				<li>The materials on Tackster's web site are provided "as is". Tackster makes no warranties, expressed or implied, and hereby disclaims and negates all other warranties, including without limitation, implied warranties or conditions of merchantability, fitness for a particular purpose, or non-infringement of intellectual property or other violation of rights. Further, Tackster does not warrant or make any representations concerning the accuracy, likely results, or reliability of the use of the materials on its Internet web site or otherwise relating to such materials or on any sites linked to this site.</li>
			</ol>

			<h5>4. Limitations</h5>

			<p>In no event shall Tackster or its suppliers be liable for any damages (including, without limitation, damages for loss of data or profit, or due to business interruption,) arising out of the use or inability to use the materials on Tackster's Internet site, even if Tackster or a Tackster authorized representative has been notified orally or in writing of the possibility of such damage. Because some jurisdictions do not allow limitations on implied warranties, or limitations of liability for consequential or incidental damages, these limitations may not apply to you.</p>

			<h5>5. Revisions and Errata</h5>

			<p>The materials appearing on Tackster's web site could include technical, typographical, or photographic errors. Tackster does not warrant that any of the materials on its web site are accurate, complete, or current. Tackster may make changes to the materials contained on its web site at any time without notice. Tackster does not, however, make any commitment to update the materials.</p>

			<h5>6. Links</h5>

			<p>Tackster has not reviewed all of the sites linked to its Internet web site and is not responsible for the contents of any such linked site. The inclusion of any link does not imply endorsement by Tackster of the site. Use of any such linked web site is at the user's own risk.</p>

			<h5>7. Site Terms of Use Modifications</h5>

			<p>Tackster may revise these terms of use for its web site at any time without notice. By using this web site you are agreeing to be bound by the then current version of these Terms and Conditions of Use.</p>

			<h5>8. Governing Law</h5>

			<p>Any claim relating to Tackster's web site shall be governed by the laws of the State of California without regard to its conflict of law provisions.</p>

			<p>General Terms and Conditions applicable to Use of a Web Site.</p>

			<p><br></p>
			<a id="privacy"></a>
			<h4>Privacy Policy</h4>

			<p>Your privacy is very important to us. Accordingly, we have developed this Policy in order for you to understand how we collect, use, communicate and disclose and make use of personal information. The following outlines our privacy policy.</p>

			<ul>
				<li>Before or at the time of collecting personal information, we will identify the purposes for which information is being collected.</li>
				<li>We will collect and use of personal information solely with the objective of fulfilling those purposes specified by us and for other compatible purposes, unless we obtain the consent of the individual concerned or as required by law.</li>
				<li>We will only retain personal information as long as necessary for the fulfillment of those purposes.</li>
				<li>We will collect personal information by lawful and fair means and, where appropriate, with the knowledge or consent of the individual concerned.</li>
				<li>Personal data should be relevant to the purposes for which it is to be used, and, to the extent necessary for those purposes, should be accurate, complete, and up-to-date.</li>
				<li>We will protect personal information by reasonable security safeguards against loss or theft, as well as unauthorized access, disclosure, copying, use or modification.</li>
				<li>We will make readily available to customers information about our policies and practices relating to the management of personal information.</li>
			</ul>

			<p>We are committed to conducting our business in accordance with these principles in order to ensure that the confidentiality of personal information is protected and maintained.</p>

		</div>
		<!-- /Body Content-->

		<!-- Footer Content -->
		<?php require_once('html/footer.php'); ?>
		<!-- /Footer Content -->
    </body>
</html>