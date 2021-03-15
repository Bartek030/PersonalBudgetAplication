<?php
    session_start();

    /* Preparing object with current date */
    $date = new DateTime();
    $userID = $_SESSION['logged_id'];

    /* Connecting with database */
    require_once 'database.php';

    if($_POST['balanceTime'] == "current_month") {
        $time = $date -> format('Y-m');

        /* Requesting for incomes from current month */
        $incomesQuery = $db -> prepare("SELECT inc.name, incomes.amount, incomes.date_of_income
                                        FROM incomes_category_assigned_to_users AS inc, incomes
                                        WHERE incomes.income_category_assigned_to_user_id = inc.id
                                        AND incomes.user_id = '$userID'
                                        AND incomes.date_of_income LIKE '$time%'");
        $incomesQuery -> execute();
        $incomes = $incomesQuery -> fetchAll();

        print_r($incomes); exit();
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

        /* Requesting for incomes from previus month */
        $incomesQuery = $db -> prepare("SELECT inc.name, incomes.amount, incomes.date_of_income
                                        FROM incomes_category_assigned_to_users AS inc, incomes
                                        WHERE incomes.income_category_assigned_to_user_id = inc.id
                                        AND incomes.user_id = '$userID'
                                        AND incomes.date_of_income LIKE '$time%'");
        $incomesQuery -> execute();
        $incomes = $incomesQuery -> fetchAll();

        print_r($incomes); exit();
    }

    if($_POST['balanceTime'] == "current_year") {
        $time = $date -> format('Y');

        /* Requesting for incomes from current year */
        $incomesQuery = $db -> prepare("SELECT inc.name, incomes.amount, incomes.date_of_income
                                        FROM incomes_category_assigned_to_users AS inc, incomes
                                        WHERE incomes.income_category_assigned_to_user_id = inc.id
                                        AND incomes.user_id = '$userID'
                                        AND incomes.date_of_income LIKE '$time%'");
        $incomesQuery -> execute();
        $incomes = $incomesQuery -> fetchAll();

        print_r($incomes); exit();
    }

    if($_POST['balanceTime'] == "other_period") {
        $startDate = date('Y-m-d', strtotime($_POST['startDate']));
        $endDate = date('Y-m-d', strtotime($_POST['endDate']));

        /* Requesting for incomes from current year */
        $incomesQuery = $db -> prepare("SELECT inc.name, incomes.amount, incomes.date_of_income
                                        FROM incomes_category_assigned_to_users AS inc, incomes
                                        WHERE incomes.income_category_assigned_to_user_id = inc.id
                                        AND incomes.user_id = '$userID'
                                        AND incomes.date_of_income >= '$startDate'
                                        AND incomes.date_of_income <= '$endDate'");
        $incomesQuery -> execute();
        $incomes = $incomesQuery -> fetchAll();

        print_r($incomes); exit();
    }
?>