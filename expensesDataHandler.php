<?php
    session_start();

    if(isset($_POST['amount']) && isset($_POST['operationDate']) && isset($_POST['category']) && isset($_POST['paymentMethod'])) {

        /* Assigning input values to variables */
        $amount = filter_input(INPUT_POST, 'amount');
        $operationDate = filter_input(INPUT_POST, 'operationDate');
        $category = filter_input(INPUT_POST, 'category');
        $paymentMethod = filter_input(INPUT_POST, 'paymentMethod');
        $comment = filter_input(INPUT_POST, 'comment');
        $userID = $_SESSION['logged_id'];

        /* Connecting with database */
        require_once 'database.php';

        /* Requesting expense category assigned to user id */
        $expenseIdQuery = $db -> prepare("  SELECT id
                                            FROM expenses_category_assigned_to_users
                                            WHERE user_id = '$userID'
                                            AND name = '$category'");
        $expenseIdQuery -> execute();
        $requestedExpenseId = $expenseIdQuery -> fetch();
        $expenseId = $requestedExpenseId['id'];

        /* Requesting payment method assigned to user id */
        $paymentIdQuery = $db -> prepare("  SELECT id
                                            FROM payment_methods_assigned_to_users
                                            WHERE user_id = '$userID'
                                            AND name = '$paymentMethod'");
        $paymentIdQuery -> execute();
        $requestedPaymentId = $paymentIdQuery -> fetch();
        $paymentId = $requestedPaymentId['id'];

        /* Inserting income data to the income table */
        $expenseQuery = $db -> prepare("INSERT INTO expenses
                                        VALUES(NULL, '$userID', '$expenseId', '$paymentId', :amount, '$operationDate', :comment)");
        $expenseQuery -> bindValue(':amount', $amount, PDO::PARAM_STR);
        $expenseQuery -> bindValue(':comment', $comment, PDO::PARAM_STR);
        $expenseQuery -> execute();
    }
?>