<?php

$gdbtable = "posts";

function conn(){
	$servername = "localhost";
	$username = "root";
	$password = "";
	$dbname = "multitool";
	$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
	$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);	
	return $conn;
}

function getPostByTitle($title) { 
	try {
	    $conn = conn();
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	    $stmt = $conn->prepare("SELECT * FROM posts WHERE title = :title");
	    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
	    $stmt->execute();
	    $post = $stmt->fetch(PDO::FETCH_ASSOC);

	    if ($post) {
			$conn = null;
			return $post;
	    } else {
	    	$conn = null;
			return 0;
		}
		
	} catch(PDOException $e) {
		echo "Wystąpił błąd: " . $e->getMessage();
	}

	$conn = null;
}

if(isset($_GET['up'])){
	try {
	  $conn = conn();

	  $sql = "CREATE TABLE IF NOT EXISTS posts (
	    id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	    title VARCHAR(255) NOT NULL,
	    content TEXT,
	    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
	  )";
	  $conn->exec($sql);

	  echo "Tabela została utworzona pomyślnie";

	} catch(PDOException $e) {
	  echo $sql . "<br>" . $e->getMessage();
	}

	$conn = null;
	die();
}

if(isset($_GET['title']) && $_GET['content']){

	$title = $_GET['title'];
	$content = $_GET['content'];

	try {
		$conn = conn();

	    $stmt = $conn->prepare("SELECT COUNT(*) AS count FROM posts WHERE title = :title");
	    $stmt->bindParam(':title', $title, PDO::PARAM_STR);
	    $stmt->execute();
	    $result = $stmt->fetch(PDO::FETCH_ASSOC);

	    if ($result['count'] > 0) {
	      $stmt = $conn->prepare("UPDATE " . $GLOBALS['gdbtable'] . " SET content = :content WHERE title = :title");
	      $stmt->bindParam(':title', $title, PDO::PARAM_STR);
	      $stmt->bindParam(':content', $content, PDO::PARAM_STR);
	      $stmt->execute();

	      //echo "Post został zaktualizowany pomyślnie";
	    } else {
	      $stmt = $conn->prepare("INSERT INTO " . $GLOBALS['gdbtable'] . " (title, content) VALUES (:title, :content)");
	      $stmt->bindParam(':title', $title, PDO::PARAM_STR);
	      $stmt->bindParam(':content', $content, PDO::PARAM_STR);
	      $stmt->execute();

	      //echo "Nowy post został dodany pomyślnie";
	    }

	} catch(PDOException $e) {
	    echo "Wystąpił błąd: " . $e->getMessage();
	}
	$conn = null;
}
?>