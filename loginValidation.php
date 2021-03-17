<?php
    session_start();

    if(isset($_POST['login']) && isset($_POST['password'])) {

        /* Assigning input values to variables */
        $login = filter_input(INPUT_POST, 'login');
        $password = filter_input(INPUT_POST, 'password');

        $_SESSION['login'] = $login;

        /* Connecting with database */
        require_once 'database.php';

        /* preparing query to database */
        $userLoginQuery = $db -> prepare('SELECT id, username, password, email FROM users WHERE email = :login');
        $userLoginQuery -> bindValue(':login', $login, PDO::PARAM_STR);
        $userLoginQuery -> execute();

        /* Fetching requested results from query to variable */
        $user = $userLoginQuery -> fetch();

        /* Veryfying password */
        if($user && password_verify($password, $user['password'])) {
            $_SESSION['logged_id'] = $user['id'];
            unset($_SESSION['error']);
            header('Location: mainMenu.php');
            exit();
        } else {
            $_SESSION['error'] = "Podano niepoprawny email lub hasło!";
            header('Location: login.php');
            exit();
        }
    } else {
        header('Location: login.php');
        exit();
    }
?>