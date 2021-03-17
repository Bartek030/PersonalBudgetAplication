<?php
    session_start();

    if(!isset($_SESSION['logged_id'])) {
		header('Location: index.php');
		exit();
	}

    if(isset($_POST['amount']) && isset($_POST['operationDate']) && isset($_POST['category'])) {

        /* Assigning input values to variables */
        $amount = filter_input(INPUT_POST, 'amount');
        $operationDate = filter_input(INPUT_POST, 'operationDate');
        $category = filter_input(INPUT_POST, 'category');
        $comment = filter_input(INPUT_POST, 'comment');
        $userID = $_SESSION['logged_id'];

        /* Connecting with database */
        require_once 'database.php';

        /* Requesting income category assigned to user id */
        $incomeIdQuery = $db -> prepare("   SELECT id
                                            FROM incomes_category_assigned_to_users
                                            WHERE user_id = '$userID'
                                            AND name = '$category'");
        $incomeIdQuery -> execute();
        $requestedIncomeId = $incomeIdQuery -> fetch();
        $incomeId = $requestedIncomeId['id'];

        /* Inserting income data to the income table */
        $incomeQuery = $db -> prepare(" INSERT INTO incomes
                                        VALUES(NULL, '$userID', '$incomeId', :amount, '$operationDate', :comment)");
        $incomeQuery -> bindValue(':amount', $amount, PDO::PARAM_STR);
        $incomeQuery -> bindValue(':comment', $comment, PDO::PARAM_STR);
        $incomeQuery -> execute();

        header('Location: incomeConfirmation.php');
    }
?>