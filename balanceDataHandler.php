<?php
    session_start();

    if(!isset($_SESSION['logged_id'])) {
		header('Location: index.php');
		exit();
	}

    /* Preparing object with current date */
    $date = new DateTime();
    $userID = $_SESSION['logged_id'];
    $_SESSION['balanceOption'] = true;

    /* Connecting with database */
    require_once 'database.php';

    if($_POST['balanceTime'] == "other_period") {
        $startDate = date('Y-m-d', strtotime($_POST['startDate']));
        $endDate = date('Y-m-d', strtotime($_POST['endDate']));

        /* Requesting for incomes from period of time */
        $incomesQuery = $db -> prepare("SELECT inc.name, incomes.amount, incomes.date_of_income
                                        FROM incomes_category_assigned_to_users AS inc, incomes
                                        WHERE incomes.income_category_assigned_to_user_id = inc.id
                                        AND incomes.user_id = '$userID'
                                        AND incomes.date_of_income >= '$startDate'
                                        AND incomes.date_of_income <= '$endDate'");
        $incomesQuery -> execute();
        $incomes = $incomesQuery -> fetchAll();

        /* Requesting for expenses from period of time */
        $expensesQuery = $db -> prepare("SELECT exp.name, expenses.amount, expenses.date_of_expense
                                        FROM expenses_category_assigned_to_users AS exp, expenses
                                        WHERE expenses.expense_category_assigned_to_user_id = exp.id
                                        AND expenses.user_id = '$userID'
                                        AND expenses.date_of_expense >= '$startDate'
                                        AND expenses.date_of_expense <= '$endDate'");
        $expensesQuery -> execute();
        $expenses = $expensesQuery -> fetchAll();
        unset($_SESSION['errorTime']);

    } else if ($_POST['balanceTime'] == "none") {
        $_SESSION['errorTime'] = "Wybierz okres!";
        header('Location: balance.php');
        exit();
    } else {
        if($_POST['balanceTime'] == "current_month") {
            $time = $date -> format('Y-m');
        }
    
        if($_POST['balanceTime'] == "previous_month") {
            $year = $date -> format('Y');
            $month = $date -> format('m') - 1;
            if($month < 1) {
                $month = 12;
                $year = $year - 1;
            }
            if($month < 10) {
                $time = $year . "-0" . $month;
            } else {
                $time = $year . "-" . $month;
            }
        }
    
        if($_POST['balanceTime'] == "current_year") {
            $time = $date -> format('Y'); 
        }
    
        /* Requesting for incomes */
        $incomesQuery = $db -> prepare("SELECT inc.name, incomes.amount, incomes.date_of_income
                                        FROM incomes_category_assigned_to_users AS inc, incomes
                                        WHERE incomes.income_category_assigned_to_user_id = inc.id
                                        AND incomes.user_id = '$userID'
                                        AND incomes.date_of_income LIKE '$time%'");
        $incomesQuery -> execute();
        $incomes = $incomesQuery -> fetchAll();
    
        /* Requesting for expenses */
        $expensesQuery = $db -> prepare("SELECT exp.name, expenses.amount, expenses.date_of_expense
                                        FROM expenses_category_assigned_to_users AS exp, expenses
                                        WHERE expenses.expense_category_assigned_to_user_id = exp.id
                                        AND expenses.user_id = '$userID'
                                        AND expenses.date_of_expense LIKE '$time%'");
        $expensesQuery -> execute();
        $expenses = $expensesQuery -> fetchAll();
        unset($_SESSION['errorTime']);
    }

    $_SESSION['incomesTable'] = $incomes;
    $_SESSION['expensesTable'] = $expenses;
    header('Location: balance.php');
?>