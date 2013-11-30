<!DOCTYPE html>
<html>
	<head>
		<title>Tackster | My Profile</title>
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
		<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
		<!-- Include all compiled plugins (below), or include individual files as needed -->
		<script src="/framework/bootstrap/js/bootstrap.min.js"></script>

		<link href="/shared/css/tabBody.css" rel="stylesheet" type="text/css">
		<script type="text/javascript">
			function getMyTrack(id) {
				$.ajax({
					type: "GET",
					url: '/track/myTracks.php',
					//data: "id=" + id, // appears as $_GET['id'] @ ur backend side
					success: function(data) {
						// data is ur summary
						$('.tabContent').html(data);
					}

				});
			}
			function getFollowingTrack(id) {
				$.ajax({
					type: "GET",
					url: '/track/following.php',
					//data: "id=" + id, // appears as $_GET['id'] @ ur backend side
					success: function(data) {
						// data is ur summary
						$('.tabContent').html(data);
					}

				});
			}
		</script>
	</head>


	<body>


		<div>
			<div id="quickMenu" class="quickMenuTab">
				<div id="icons">
					<a class='bookmark_popUp' href="/bookmark/createBookmark.php" title="Add Bookmark"><i class="fa fa-bookmark fa-lg"></i></a>
					<a class='track_popUp' href="/track/createTrack.php" title="Add Track"><i class="fa fa-folder-open fa-lg"></i></a>
				</div>
			</div>
			<div id='cssmenu'>
				<ul>
					<li class='active'><a href="javascript:void(0)" onclick="getMyTrack('main')"><span>My Tracks</span></a></li>
					<li class='last'><a href="javascript:void(0)"  onclick="getFollowingTrack()"><span>Following Tracks</span></a></li>
				</ul>

			</div>
			<div class="main tabContent" id="tabContent"></div>
		</div>

		<div id="quickMenu" class="quickMenuTab quickMenuTabFooter">
			<div id="icons">
				<a href="#">(top)</a>
				<a id="simple-menu" href="#sidr">(tracks)</a>
				<a class='bookmark_popUp' href="/bookmark/createBookmark.php" title="Add Bookmark"><i class="fa fa-bookmark fa-lg"></i></a>
				<a class='track_popUp' href="/track/createTrack.php" title="Add Track"><i class="fa fa-folder-open fa-lg"></i></a>
			</div>
		</div>
	</body>
</html>

