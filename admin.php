<? session_start(); ?>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<header>
		<h1>El Usuario Actual es <?=$_SESSION['nombre_usuario']?></h1>
	</header>
</body>
</html>