<html>
	<head>
		<title>Meu site</title>
		<link rel="stylesheet" type="text/css" href="<?php echo BASE_URL; ?>assets/css/style.css" />
		<script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/script.js"></script>
		<script type="text/javascript" src="<?php echo BASE_URL; ?>/assets/js/S3uploader.js"></script>
	</head>
	<body>
		<section>
			<?php $this->loadViewInTemplate($viewName, $viewData); ?>
		</section>
	</body>
</html>