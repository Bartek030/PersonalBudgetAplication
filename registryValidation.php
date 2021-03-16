<?php
    session_start();
    unset($_SESSION['errorName']);
    unset($_SESSION['errorPassword']);
    unset($_SESSION['errorPassword2']);
    unset($_SESSION['errorEmail']);

    if(isset($_POST['name']) && isset($_POST['password']) && isset($_POST['email'])) {
        $credentialValidation = true;
        
        /* Assigning input values to variables */
        $name = filter_input(INPUT_POST, 'name');
        $password = filter_input(INPUT_POST, 'password');
        $repeatedPassword = filter_input(INPUT_POST, 'repeatedPassword');
        $email = filter_input(INPUT_POST, 'email');

        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;

        /* Basic validation */
        if(!ctype_alpha($name)) {
            $credentialValidation = false;
            $_SESSION['errorName'] = "Imię może składać się tylko z liter (bez polskich znaków)";
        }
        if((strlen($name) < 3) || ((strlen($name) > 15))) {
            $credentialValidation = false;
            $_SESSION['errorName'] = "Imie musi posiadać od 3 do 15 znaków!";
        }
        if((strlen($password) < 8) || (strlen($password) > 20)) {
            $credentialValidation = false;
            $_SESSION['errorPassword'] = "Hasło musi posiadać od 8 do 20 znaków";
        }
        if($password != $repeatedPassword) {
            $credentialValidation = false;
            $_SESSION['errorPassword2'] = "Podane hasła nie są identyczne";
        }
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $filteredEmail = filter_var($email, FILTER_SANITIZE_EMAIL);
        if(!(filter_var($filteredEmail, FILTER_VALIDATE_EMAIL)) || ($email != $filteredEmail)) {
            $credentialValidation = false;
            $_SESSION['errorEmail'] = "Podaj poprawny adres e-mail!";
        }
        /* Connecting with database */
        require_once 'database.php';
        
        $emailQuery = $db -> prepare('SELECT id, email FROM users WHERE email = :email');
        $emailQuery -> bindValue(':email', $email, PDO::PARAM_STR);
        $emailQuery -> execute();
        
        /* Fetching requested results from query to variable */
        $user = $emailQuery -> fetch();

        /* checking if e-mail exist in database */
        if($user) {
            $credentialValidation = false;
            $_SESSION['errorEmail'] = "Istnieje już konto przypisane do tego adresu e-mail.";
            /*header('Location: registry.php');
            exit();*/
        }

        if($credentialValidation) {
            /* Adding user to the users table */
            $userQuery = $db -> prepare("INSERT INTO users VALUES (NULL, '$name', '$hashedPassword', '$email')");
            $userQuery -> execute();

            /* Fetching registered user ID */
            $newIdQuery = $db -> prepare("SELECT id FROM users WHERE email = '$email'");
            $newIdQuery -> execute();
            $newID = $newIdQuery -> fetch();
            $registeredUserID = $newID['id'];

            /* Adding user incomes categories to the incomes categories table */
            $incomesQuery = $db -> prepare("INSERT INTO incomes_category_assigned_to_users (user_id, name) 
                                            SELECT u.id, inc.name 
                                            FROM users AS u, incomes_category_default AS inc 
                                            WHERE u.id = $registeredUserID");
            $incomesQuery -> execute();

            /* Adding user expenses categories to the expenses categories table */
            $expensesQuery = $db -> prepare("INSERT INTO expenses_category_assigned_to_users (user_id, name) 
                                            SELECT u.id, exp.name 
                                            FROM users AS u, expenses_category_default AS exp
                                            WHERE u.id = $registeredUserID");
            $expensesQuery -> execute();

            /* Adding user payment methods to the payment methods table */
            $paymentQuery = $db -> prepare("INSERT INTO payment_methods_assigned_to_users (user_id, name) 
                                            SELECT u.id, pay.name 
                                            FROM users AS u, payment_methods_default AS pay 
                                            WHERE u.id = $registeredUserID");
            $paymentQuery -> execute();
            header('Location: registryConfirmation.php');
            exit();
        } else {
            header('Location: registry.php');
            exit();
        }
    } else {
        header('Location: registry.php');
    }
?>