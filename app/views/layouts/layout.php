<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>JRESTPad <?php if (isset($page_title)) echo "| " . $page_title ?></title>

<!-- Core CSS - Include with every page -->
<link href="public/assets/css/bootstrap.min.css" rel="stylesheet">
<link href="public/assets/font-awesome/css/font-awesome.css"
	rel="stylesheet">

<!-- Page-Level Plugin CSS - Blank -->

<!-- SB Admin CSS - Include with every page -->
<!--<link href="public/assets/css/sb-admin.css" rel="stylesheet">-->

<!-- Other CSS File -->
<link href="public/assets/css/main.css" rel="stylesheet">
</head>
<body>
	<!-- Begin page content -->
	<div class="container">
		<?php if(isset($view_filename)) require $view_filename?>
	</div>
	<!-- container -->

	<div class="footer">
		<div class="container">
			<p class="text-muted text-right">
				Desenvolvido por <a href="http://www.facebook.com/ljhonne"
					target="_blank">Luis Jhonne.</a>
			</p>
		</div>
	</div>

	<!-- Core Scripts - Include with every page -->
	<script src="public/assets/js/jquery-1.11.1.js"></script>
	<script src="public/assets/js/bootstrap.min.js"></script>
	<script src="public/assets/js/ajax.js"></script>
	<script src="public/assets/js/new_main.js"></script>
    </body>
</html>