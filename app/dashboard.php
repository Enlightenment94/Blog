<head>
	<link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
	<div id='header'>
		<span style="margin-left: 10px;">Enlightmentsoftware</span>
	</div>
	<div id='left-menu'>
		<?php
			$www = "dashboard.php";
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
				<input id='title' type="text" name="title" value='<?php echo $title;?>'>
			</div>

			<div>
				<textarea id='area' name='content'><?php echo $content; ?></textarea>
			</div>

			<input id='write' type='submit' name='send' value='write'>
		</form>
		<a href='index.php'>index</a>
		<a href='logout.php'>logout</a>
	</div>

	<img class='logo' src='logo.jpeg' width="100" height="100"/>
</body>