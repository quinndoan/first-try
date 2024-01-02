<?php
session_start();
?>

<?php

// initializing variables
$name = "";
$username = "";
$usn = "";
$email    = "";
$errors = array();
$reg_date = date("Y/m/d");

// connect to the database
$serverName = "LAPTOP-86MF1K51";
$connectionOptions = array(
    "Database" => "PetManaDemo",
    "Uid" => "",
    "PWD" => ""
);

$db = sqlsrv_connect($serverName, $connectionOptions);

// Check the connection
if (!$db) {
    die(print_r(sqlsrv_errors(), true));
}

// REGISTER USER
if (isset($_POST['reg_user'])) {
    // receive all input values from the form
    $username = sqlsrv_real_escape_string($db, $_POST['admin_name']);
    $email = sqlsrv_real_escape_string($db, $_POST['admin_email']);
    $password_1 = sqlsrv_real_escape_string($db, $_POST['password_1']);
    $password_2 = sqlsrv_real_escape_string($db, $_POST['password_2']);

    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    if (empty($email)) {
        array_push($errors, "Email is required");
    }
    if (empty($password_1)) {
        array_push($errors, "Password is required");
    }
    if ($password_1 != $password_2) {
        array_push($errors, "The passwords do not match");
    }

    // first check the database to make sure
    // a user does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM admin_info WHERE admin_name='$username' OR admin_email='$email' LIMIT 1";
    $result = sqlsrv_query($db, $user_check_query);
    $user = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);

    if ($user) { // if user exists
        if ($user['admin_name'] === $username) {
            array_push($errors, "Username already exists");
        }

        if ($user['admin_email'] === $email) {
            array_push($errors, "Email already exists");
        }
    }

    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = md5($password_1); // encrypt the password before saving in the database

        $query = "INSERT INTO admin_info (admin_name, admin_email, admin_password)
                  VALUES('$username', '$email', '$password')";
        sqlsrv_query($db, $query);

        $_SESSION['admin_name'] = $username;
        $_SESSION['admin_email'] = $email;

        $_SESSION['success'] = "You are now logged in";
        header('location: ./admin/');
    }
}

// LOGIN ADMIN
if (isset($_POST['login_admin'])) {
    $admin_username = sqlsrv_real_escape_string($db, $_POST['admin_username']);
    $password = sqlsrv_real_escape_string($db, $_POST['password']);

    if (empty($admin_username)) {
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
        array_push($errors, "Password is required");
    }

    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM admin_info WHERE admin_email='$admin_username' AND admin_password='$password'";
        $results = sqlsrv_query($db, $query);

        if (sqlsrv_has_rows($results)) {
            $user = sqlsrv_fetch_array($results, SQLSRV_FETCH_ASSOC);
            $_SESSION['admin_email'] = $user['admin_email'];
            $_SESSION['admin_name'] = $admin_username;
            $_SESSION['success'] = "You are now logged in";
            header('location: ./admin/');
        } else {
            array_push($errors, "Wrong username/password combination");
        }
    }
}

?>
