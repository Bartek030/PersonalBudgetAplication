<?php
    session_start();

    if(isset($_POST['login']) && isset($_POST['password'])) {

        /* Assigning input values to variables */
        $login = filter_input(INPUT_POST, 'login');
        $password = filter_input(INPUT_POST, 'password');

        /* Connecting with database */
        require_once 'database.php';

        /* preparing query to database */
        $userLoginQuery = $db -> prepare('SELECT id, username, password FROM users WHERE username = :login');
        $userLoginQuery -> bindValue(':login', $login, PDO::PARAM_STR);
        $userLoginQuery -> execute();

        /* Fetching requested results from query to variable */
        $user = $userLoginQuery -> fetch();

        /* Veryfying password */
        if($user && password_verify($password, $user['password'])) {
            $_SESSION['logged_id'] = $user['id'];
            unset($_SESSION['bad_attempt']);
            header('Location: mainMenu.html');
            exit();
        } else {
            $_SESSION['bad_attempt'] = true;
            header('Location: login.php');
            exit();
        }
    } else {
        header('Location: login.php');
        exit();
    }
?>