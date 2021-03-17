<?php
	session_start();

	if(!isset($_SESSION['logged_id'])) {
		header('Location: index.php');
		exit();
	}
	if(isset($_SESSION['balanceOption'])) {
		$incomes = $_SESSION['incomesTable'];
		$expenses = $_SESSION['expensesTable'];
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
									<a class="nav-link" aria-current="page" href="logout.php">Wyloguj się</a>
								</li>
							</ul>
						</div>
					</div>
				</nav>
				<div class="col-12 text-center">
					<section>
						<h2 class="h3 my-3">PRZEGLĄDAJ BILANS</h2>
						<form action="balanceDataHandler.php" method="POST" class="needs-validation">
							<div>
								<label class="my-2 h4" for="expenseCategory">Wybierz okres:</label>
								<select id="balanceTime" name="balanceTime" class="form-select w-50 mx-auto mb-4 userInput" aria-label="Default select example">
									<option value="none" selected>Wybierz okres</option>
									<option value="current_month">Bieżący miesiąc</option>
									<option value="previous_month">Poprzedni miesiąc</option>
									<option value="current_year">Bieżący rok</option>
									<option value="other_period">Inny okres</option>
								</select>
								<span class="text-danger">
									<?= isset($_SESSION['errorTime']) ? $_SESSION['errorTime'] : ''?>
								</span>
							</div>
							<h3 class="h4">Wybierz przedział czasu:</h3>
							<div class="d-flex justify-content-center flex-wrap mb-3">
								<div class="form-group my-3">
									<label class="me-1" for="startDate">Od:</label>
									<input id="startDate" name="startDate" value="<?php echo date('Y-m-d'); ?>" class="userInput" type="date" min="2000-01-01" required/>
								</div>
								<div class="form-group mx-3 my-3">
									<label class="me-1" for="endDate">Do:</label>
									<input id="endDate" name="endDate" value="<?php echo date('Y-m-d'); ?>" class="userInput" type="date" min="2000-01-01" required/>
								</div>
							</div>
							<div class="mb-4">
								<button type="submit" class="btn fw-bold mx-1 mt-4 smallGreenButton">Przeglądaj</button>
								<button type="reset" class="btn fw-bold mx-1 mt-4 smallOrangeButton">Wyczyść</button>
								<a href="mainMenu.php"><button type="button" class="btn fw-bold mx-1 mt-4 smallRedButton">Powrót</button></a>
							</div>
						</form>
					</section>
					<section>
						<div id="incomes" class="row border-top border-2">
							<div class="col-md-8 p-3 table-responsive-md">
								<h4 class="mb-3">PRZYCHODY</h4>
								<table class="table table-hover">
									<thead>
										<tr>
											<th scope="col">#</th>
											<th scope="col">Kategoria</th>
											<th scope="col">Kwota</th>
											<th scope="col">Data operacji</th>
										</tr>
									</thead>
									<tbody>
										<?php									
											if(isset($_SESSION['balanceOption'])) {
												$i = 1;
												foreach($incomes as $singleIncome){
													echo '<tr>';
													echo '<th scope="row">' . $i . '</th>';
													echo '<td>' . $singleIncome[0] . '</td>';
													echo '<td>' . $singleIncome[1] . '</td>';
													echo '<td>' . $singleIncome[2] . '</td>';
													echo '</tr>';
													$i = $i + 1;
												}
											}
										?>
									</tbody>
								</table>
							</div>
							<div class="col-md-4">
								MIEJSCE NA WYKRES KOŁOWY
							</div>
						</div>
					</section>
					<section>
						<div id="expenses" class="row border-top border-2">
							<div class="col-md-8 p-3 table-responsive-md">
								<h4 class="mb-3">WYDATKI</h4>
								<table class="table table-hover">								
									<thead>
										<tr>
											<th scope="col">#</th>
											<th scope="col">Kategoria</th>
											<th scope="col">Kwota</th>
											<th scope="col">Udział procentowy</th>
										</tr>
									</thead>
									<tbody>
										<?php
											if(isset($_SESSION['balanceOption'])) {
												$i = 1;
												foreach($expenses as $singleExpense) {
													echo '<tr>';
													echo '<th scope="row">' . $i . '</th>';
													echo '<td>' . $singleExpense[0] . '</td>';
													echo '<td>' . $singleExpense[1] . '</td>';
													echo '<td>' . $singleExpense[2] . '</td>';
													echo '</tr>';
													$i = $i + 1;
												}
											}
										?>
									</tbody>
								</table>
							</div>
							<div class="col-md-4">
								MIEJSCE NA WYKRES KOŁOWY
							</div>
						</div>
					</section>
					<section>
						<div id="balance" class="row border-top border-2">
							<div class="col-md-8 p-3 table-responsive-md">
								<h4 class="mb-3">BILANS</h4>
								<table class="table table-hover">
									<thead>
										<tr>
											<th scope="col">Przychody</th>
											<th scope="col">Wydatki</th>
											<th scope="col">Różnica</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<?php
												if(isset($_SESSION['balanceOption'])) {
													$incomeSummary = 0;
													$expenseSummary = 0;
													foreach($incomes as $singleIncome) {
														$incomeSummary = $incomeSummary + $singleIncome[1];
													}
													foreach($expenses as $singleExpense) {
														$expenseSummary = $expenseSummary + $singleExpense[1];
													}
													$balance = $incomeSummary - $expenseSummary;

													echo '<th scope="row">' . $incomeSummary . '</th>';
													echo '<td>' . $expenseSummary . '</td>';
													echo '<td>' . $balance . '</td>';		
												}										
											?>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="col-md-4">
								GRATULACJE
							</div>
						</div>
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