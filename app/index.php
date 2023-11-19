<head>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div id='header'>
		<span style="margin-left: 10px;">Enlightmentsoftware</span>
	</div>
	<div id='left-menu'>
		<?php
			$www = "index.php";
			require_once('menu.php');
		?>
	</div>
	<div id='content'>
		<?php
			require_once('request.php');
			$title = "";
			$content = "";

			if(isset($_GET['title'])){
				$title = $_GET['title'];
				$record = getPostByTitle($title);
				$title = $record['title'];
				$content = $record['content'];
			}
		?>
		<form action='./panel.php' method="GET">
			<div>
				<h1>
					<?php echo $title;?>
				</h1>
			</div>
			<div>
				<?php echo $content; ?>
			</div>
		</form>
	</div>

	<img class='logo' src='logo.jpeg' width="100" height="100"/>
</body>