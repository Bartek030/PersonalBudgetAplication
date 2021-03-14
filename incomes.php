<php
	session_start();
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
			<div id="mainContainer" class="row">
				<nav class="navbar navbar-dark navbar-expand-lg sticky-top mainNav">
					<div class="col-12">
						<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav_navbar" aria-controls="mainNav_navbar" aria-expanded="false" aria-label="Przełącznik nawigacji">
							<span class="navbar-toggler-icon"></span>
						</button>
						<div class="collapse navbar-collapse" id="mainNav_navbar">
							<ul class="navbar-nav mx-auto">
								<li class="nav-item">
									<a class="nav-link" aria-current="page" href="incomes.php">Dodaj przychód</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" aria-current="page" href="expenses.php">Dodaj wydatek</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" aria-current="page" href="balance.php">Przeglądaj bilans</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" aria-current="page" href="#">Ustawienia</a>
								</li>
								<li class="nav-item">
									<a class="nav-link" aria-current="page" href="#">Wyloguj się</a>
								</li>
							</ul>
						</div>
					</div>
				</nav>
				<div class="col-12 text-center">
					<section>
						<h2 class="h3 my-3">DODAJ PRZYCHÓD</h2>
						<form action="incomesDataHandler.php" method="POST" class="needs-validation">
							<div class="d-flex flex-wrap justify-content-center mb-3">
								<div class="form-group mx-3 my-3">
									<label class="me-1" for="amount">Kwota:</label>
									<input id="amount" name="amount" class="userInput" type="number" step="0.01" required/>
								</div>
								<div class="form-group mx-3 my-3">
									<label class="ms-3 me-1" for="operationDate">Data:</label>
									<input id="operationDate" name="operationDate" class="userInput" type="date" min="2000-01-01" required/>
								</div>
							</div>
							<div class="d-flex justify-content-center mb-3">
								<fieldset>
									<legend class="my-2">Kategoria:</legend>
									<div class="form-check form-check-inline mx-2">
										<input class="form-check-input" type="radio" name="category" value="Wynagrodzenie" checked>
										<label class="form-check-label">Wynagrodzenie</label>
									</div>
									<div class="form-check form-check-inline mx-2">
										<input class="form-check-input" type="radio" name="category" value="Odsetki bankowe">
										<label class="form-check-label">Odsetki bankowe</label>
									</div>
									<div class="form-check form-check-inline mx-2">
										<input class="form-check-input" type="radio" name="category" value="Sprzedaż">
										<label class="form-check-label">Sprzedaż</label>
									</div>
									<div class="form-check form-check-inline mx-2">
										<input class="form-check-input" type="radio" name="category" value="Inne">
										<label class="form-check-label">Inne</label>
									</div>
								</fieldset>
							</div>
							<div class="mb-3">
								<label for="comment" class="form-label">Komentarz:</label>
								<textarea class="form-control w-50 mx-auto" id="comment" name="comment" placeholder="max. 300 znaków" rows="4" cols="80" maxlength="300"></textarea>
							</div>
							<div class="mb-4">
								<button type="submit" class="btn fw-bold mx-1 mt-4 smallGreenButton">Dodaj</button>
								<button type="reset" class="btn fw-bold mx-1 mt-4 smallOrangeButton">Wyczyść</button>
								<button type="button" class="btn fw-bold mx-1 mt-4 smallRedButton">Anuluj</button>
							</div>
						</form>
					</section>
				</div>
			</div>
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
</body>
</html>