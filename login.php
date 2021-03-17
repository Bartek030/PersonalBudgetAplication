<?php
	session_start();

	if(isset($_SESSION['logged_id'])) {
		header('Location: mainMenu.html');
        exit();
	}
?>
<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	
	<title>Budżet Osobisty</title>
	
	<meta name="description" content="Zapanuj nad swoim domowym budżetem. Kontroluj swoje przychody i wydatki.">
	<meta name="keywords" content="budżet, przychody, wydatki, koszty, kontroluj, organizuj, domowy, osobisty">
	
	<!-- STYLESHEETS-->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
	<link rel="stylesheet" href="css/style.css">
	
	<!-- FONTS-->
	<link rel="preconnect" href="https://fonts.gstatic.com">
	<link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Russo+One&display=swap" rel="stylesheet"> 

	<!-- FONT ICONS-->
	<script src="https://kit.fontawesome.com/b13317d28d.js" crossorigin="anonymous"></script>
</head>

<body>
	<div class="container">
		<header>
			<div id="mainHeader" class="d-flex flex-column flex-lg-row justify-content-between">
				<div>
					<h1 class="text-center text-lg-start"><i class="fas fa-piggy-bank"></i>&ensp;Budżet Osobisty</h1>
				</div>
				<div id="currentTime" class="d-flex flex-lg-column align-items-end justify-content-center mb-2 mb-lg-0">
					<div class="currentTime_box d-flex justify-content-between px-3">
						<span>Data:</span>
						<div id="date"></div>
					</div>
					<div class="currentTime_box d-flex justify-content-between px-3">
						<span>Godzina:</span>
						<div id="time"></div>
					</div>
				</div>
			</div>
		</header>
		<main>
			<section>
				<div id="mainContainer" class="row px-5 py-4">
					<div class="col-md-6">
						<h2 class="h3 text-center fw-bold pb-2">Czym jest aplikacja Budżet Osobisty?</h2>
						<p id="appDescription" class="fs-5 py-auto">Aplikacja Budżet Osobisty pomoże Ci zarządzać Twoimi finansami. Analizuj swoje przychody i&nbsp;kontroluj swoje wydatki. Zarządzaj efektywnie swoim budżetem i&nbsp;ciesz się zaoszczędzonymi środkami. </p>	
					</div>
					<div class="col-md-6 text-center">
						<form action="loginValidation.php" method="POST"  class="needs-validation">
							<div class="form-group">
								<label for="login">Podaj email:</label>
								<input id="login" name="login" type="text" class="form-control mx-auto my-3 userInput" placeholder="login"
								<?= isset($_SESSION['login']) ? 'value="' . $_SESSION['login'] . '"' : '' ?>>								
							</div>
							<div class="form-group">
								<label for="password">Podaj hasło:</label>
								<input id="password" name="password" type="password" class="form-control mx-auto my-3 userInput" placeholder="hasło">
								<span class="text-danger">
									<?= isset($_SESSION['error']) ? $_SESSION['error'] : ''?>
								</span>
							</div>
							<button type="submit" class="btn fw-bold mx-1 mt-4 smallGreenButton">Zaloguj się</button>
							<a href="index.php"><button type="button" class="btn fw-bold mx-1 mt-4 smallRedButton">Powrót</button></a>
						</form>
					</div>
				</div>
			</section>
		</main>
		<footer>
			<div id="mainFooter" class="d-flex justify-content-center flex-wrap py-3">
				<div class="mx-3">2021 &copy;</div>
				<div class="mx-3">Autor:&ensp;Bartłomiej Święs</div>
				<div class="mx-3">Kontakt:&ensp;bartlomiejswies@gmail.com</div>
			</div>
		</footer>
	</div>

	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js" integrity="sha384-q2kxQ16AaE6UbzuKqyBE9/u/KzioAlnx2maXQHiDX9d4/zp8Ok3f+M7DPm+Ib6IU" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.min.js" integrity="sha384-pQQkAEnwaBkjpqZ8RU1fF1AKtTcHJwFl3pblpTlHXybJjHpMYo79HY3hIi4NKxyj" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="js/main.js"></script>
	<script>
		setTime();
	</script>
</body>
</html>