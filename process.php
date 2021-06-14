<?php
session_start();
require_once('new_connection.php');
date_default_timezone_set('Asia/Manila');
$first_name_letters = array();
$lastn_name_letters = array();
$first_name = "";
$last_name = "";
$email = "";
$password = "";
$user_id = "";
$post_message = "";

if($_POST['process'] == "register")
{
    $_SESSION['process'] = "register";
    $_SESSION['error_login'] = array(
        "email" => array("border_color" => "black", "text_color" => "rgb(245, 124, 36)", "text_message" => "no error"),
        "password" => array("border_color" => "black", "text_color" => "rgb(245, 124, 36)", "text_message" => "no error")
    );
    $_SESSION['data_login'] = "";

    // checking first name
    if(isset($_POST['first_name']) && !empty($_POST['first_name']))
    {
        if(strlen($_POST['first_name']) <= 1)
        {
            $_SESSION['error_register']['first_name'] = array("border_color" => "red", "text_color" => "darkred",
            "text_message" => "Name should be at least 2 characters.");
        }
        else
        {
            $_SESSION['data_register']['first_name'] = $_POST['first_name'];
            $first_name_letters = str_split($_POST['first_name']);

            foreach($first_name_letters as $letter)
            {
                if(is_numeric($letter))
                {
                    $_SESSION['error_register']['first_name'] = array("border_color" => "red", "text_color" => "darkred",
                    "text_message" => "Name should not contain numbers.");
                    break;
                }
                else
                {
                    $_SESSION['error_register']['first_name'] = array("border_color" => "black", 
                    "text_color" => "rgb(38, 164, 163)", "text_message" => "no error");
                }
            }
        }
    }
    else
    {
        $_SESSION['error_register']['first_name'] = array("border_color" => "red", "text_color" => "darkred",
        "text_message" => "Please enter your first name.");
    }
    // checking last name
    if(isset($_POST['last_name']) && !empty($_POST['last_name']))
    {
        if(strlen($_POST['last_name']) <= 1)
        {
            $_SESSION['error_register']['last_name'] = array("border_color" => "red", "text_color" => "darkred",
            "text_message" => "Name should be at least 2 characters.");
        }
        else
        {
            $_SESSION['data_register']['last_name'] = $_POST['last_name'];
            $last_name_letters = str_split($_POST['last_name']);

            foreach($last_name_letters as $letter)
            {
                if(is_numeric($letter))
                {
                    $_SESSION['error_register']['last_name'] = array("border_color" => "red", "text_color" => "darkred",
                    "text_message" => "Name should not contain numbers.");
                    break;
                }
                else
                {
                    $_SESSION['error_register']['last_name'] = array("border_color" => "black", 
                    "text_color" => "rgb(38, 164, 163)", "text_message" => "no error");
                }
            }
        }
    }
    else
    {
        $_SESSION['error_register']['last_name'] = array("border_color" => "red", "text_color" => "darkred",
        "text_message" => "Please enter your last name.");
    }
    // checking email
    if(isset($_POST['email']) && !empty($_POST['email']))
    {
        $_SESSION['data_register']['email'] = $_POST['email'];
        if(!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
        {
            $_SESSION['error_register']['email'] = array("border_color" => "red", "text_color" => "darkred",
            "text_message" => "This is not a valid E-mail address.");
        }
        else
        {
            // checking for duplicate entry
            $query = "SELECT * FROM accounts;";
            $account_data = run_mysql_query($query);

            foreach($account_data as $data)
            {
                if($data['email'] == $_POST['email'])
                {
                    $_SESSION['error_register']['email'] = array("border_color" => "red", "text_color" => "darkred",
                    "text_message" => "Duplicate entry, E-mail already in-use.");
                    break;
                }
                else
                {
                    $_SESSION['error_register']['email'] = array("border_color" => "black", 
                    "text_color" => "rgb(38, 164, 163)", "text_message" => "no error");
                }
            }
        }
    }
    else
    {
        $_SESSION['error_register']['email'] = array("border_color" => "red", "text_color" => "darkred",
        "text_message" => "Please enter your E-mail");
    }
    // checking password
    if(isset($_POST['password']) && !empty($_POST['password']))
    {
        if(strlen($_POST['password']) <= 7)
        {
            $_SESSION['error_register']['password'] = array("border_color" => "red", "text_color" => "darkred",
            "text_message" => "Password should be at least 8 characters");
        }
        else
        {
            $_SESSION['error_register']['password'] = array("border_color" => "black", 
            "text_color" => "rgb(38, 164, 163)", "text_message" => "no error");
        }
    }
    else
    {
        $_SESSION['error_register']['password'] = array("border_color" => "red", "text_color" => "darkred",
        "text_message" => "Please enter your password");
    }
    // checking confirm password
    if(isset($_POST['confirm_password']) && !empty($_POST['confirm_password']))
    {
        // checks password and confirm password matching
        if($_POST['password'] == $_POST['confirm_password'])
        {
            $_SESSION['error_register']['confirm_password'] = array("border_color" => "black", 
            "text_color" => "rgb(38, 164, 163)", "text_message" => "no error");
        }
        else
        {
            $_SESSION['error_register']['confirm_password'] = array("border_color" => "red", "text_color" => "darkred",
            "text_message" => "Password did not match");
        }
    }
    else
    {
        $_SESSION['error_register']['confirm_password'] = array("border_color" => "red", "text_color" => "darkred",
        "text_message" => "Please enter confirm password");
    }

    foreach($_SESSION['error_register'] as $key => $error)
    {
        if($error['text_message'] != "no error")
        {
            $error_count += 1;
        }
    }

    if($error_count == 0)
    {
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];
        $password = md5($_POST['password']);

        $query = "INSERT INTO users(first_name, last_name, email, password, date_created, date_updated) 
                VALUES ('{$first_name}', '{$last_name}', '{$email}', '{$password}', NOW(), NOW());";
        run_mysql_query($query);

        $query = "SELECT * FROM users WHERE users.email = '{$email}';";
        $account_data = run_mysql_query($query);
        $_SESSION['user_id'] = $account_data[0]['id'];
        unset($_SESSION['error_register']);
        unset($_SESSION['data_register']);
        header('Location: main.php');
    }
    else
    {
        header('Location: index.php');
    }
}
elseif($_POST['process'] == "login")
{
    $_SESSION['process'] = "login";
    $_SESSION['error_register'] = array(                
        "first_name" => array("border_color" => "black", "text_color" => "rgb(38, 164, 163)", "text_message" => "no error"), 
        "last_name" => array("border_color" => "black", "text_color" => "rgb(38, 164, 163)", "text_message" => "no error"), 
        "email" => array("border_color" => "black", "text_color" => "rgb(38, 164, 163)", "text_message" => "no error"), 
        "password" => array("border_color" => "black", "text_color" => "rgb(38, 164, 163)", "text_message" => "no error"), 
        "confirm_password" => array("border_color" => "black", "text_color" => "rgb(38, 164, 163)", "text_message" => "no error")
    );
    $_SESSION['data_register'] = array(
        "first_name" => "", 
        "last_name" => "", 
        "email" => ""
    );

    // CHECK EMAIL
    if(isset($_POST['email']) && !empty($_POST['email']))
    {   
        $email = $_POST['email'];
        $query = "SELECT * FROM users WHERE users.email = '{$email}';";
        $account_email = run_mysql_query($query);
        $_SESSION['data_login'] = $_POST['email'];
        if(isset($account_email) && !empty($account_email))
        {
            $_SESSION['error_login']['email'] = array("border_color" => "black", "text_color" => "rgb(245, 124, 36)", "text_message" => "no error");
        }
        else
        {
            $_SESSION['error_login']['email'] = array("border_color" => "red", "text_color" => "darkred", "text_message" => "E-mail address not yet registered");
        }
    }
    else
    {
        $_SESSION['error_login']['email'] = array("border_color" => "red", "text_color" => "darkred", "text_message" => "Please enter your email address.");
    }
    // CHECK PASSWORD
    if(isset($_POST['password']) && !empty($_POST['password']))
    {
        $_SESSION['error_login']['password'] = array("border_color" => "black", "text_color" => "rgb(245, 124, 36)", "text_message" => "no error");
    }
    else
    {
        $_SESSION['error_login']['password'] = array("border_color" => "red", "text_color" => "darkred", "text_message" => "Please enter your password.");
    }

    foreach($_SESSION['error_login'] as $key => $error)
    {
        if($error['text_message'] != "no error")
        {
            $error_count +=1;
        }
    }

    if($error_count == 0)
    {
        $email = $_POST['email'];
        $password = md5($_POST['password']);
        $query = "SELECT * FROM users WHERE users.email = '{$email}' AND users.password = '{$password}'";
        $account_data = run_mysql_query($query);

        if(isset($account_data) && !empty($account_data))
        {
            $_SESSION['user_id'] = $account_data[0]['id'];
            $_SESSION['process'] = "login";
            unset($_SESSION['error_login']);
            unset($_SESSION['data_login']);
            header('Location: main.php');
        }
        else
        {
            $_SESSION['error_login']['password'] = array("border_color" => "red", "text_color" => "darkred", "text_message" => "Incorrect password");
            header('Location: index.php');
        }
    }
    else
    {
        header('Location: index.php');
    }
}
elseif($_POST['process'] == "post")
{
    $user_id = $_SESSION['user_id'];
    $post_message = $_POST['message'];
    $query = "INSERT INTO messages(user_id, message, date_created, date_updated) 
              VALUES ('{$user_id}', '{$post_message}', NOW(), NOW());";
    run_mysql_query($query);
    header('Location: main.php');
}
elseif($_POST['process'] == "comment")
{
    $user_id = $_SESSION['user_id'];
    $message_id = $_POST['message_id'];
    $post_comment = $_POST['comment'];
    $query = "INSERT INTO comments(message_id, user_id, comment, date_created, date_updated) 
              VALUES ('$message_id', '{$user_id}', '{$post_comment}', NOW(), NOW());";
    run_mysql_query($query);
    header('Location: main.php');
}
elseif($_POST['process'] == "delete")
{    
    $user_id = $_SESSION['user_id'];
    $message_id = $_POST['message_id'];
    $_SESSION['message_id'] = $_POST['message_id'];

    $datetime_query = "SELECT MONTH(date_created) AS month, DAY(date_created) AS day, YEAR(date_created) AS year, 
                       HOUR(date_created) AS hour, MINUTE(date_created) AS minute FROM the_wall_database.messages 
                       WHERE id = '$message_id';";
    $date_time = run_mysql_query($datetime_query);

    $month = date("n");
    $day = date("j");
    $year = date("Y");
    $hour = date("G");
    $minute = date("i");
    $minute -= 30;

    if(intval($date_time[0]['year']) >= $year)
    {
        if(intval($date_time[0]['month']) >= $month)
        {
            if(intval($date_time[0]['day']) >= $day)
            {
                if(intval($date_time[0]['hour']) >= $hour)
                {
                    if(intval($date_time[0]['minute']) >= $minute)
                    {
                        $_SESSION['delete_error'] = array("text_color" => "white", 
                        "text_message" => "no error");
                        $query = "DELETE FROM messages WHERE user_id='$user_id' AND id='$message_id'";
                        run_mysql_query($query);
                    }
                    else
                    {
                        $_SESSION['delete_error'] = array("text_color" => "red", 
                        "text_message" => "Could not delete message from more than 30 minutes");
                    }
                }
                else
                {
                    $_SESSION['delete_error'] = array("text_color" => "red", 
                    "text_message" => "Could not delete message from more than an hour");
                }
            }
            else
            {
                $_SESSION['delete_error'] = array("text_color" => "red", 
                "text_message" => "Could not delete message from more than a day");
            }
        }
        else
        {
            $_SESSION['delete_error'] = array("text_color" => "red", 
            "text_message" => "Could not delete message from more than a month");
        }
    }
    else
    {
        $_SESSION['delete_error'] = array("text_color" => "red", 
        "text_message" => "Could not delete message from more than a year");
    }

    header('Location: main.php');
}
elseif($_POST['process'] == "return")
{
    session_destroy();
    header('Location: index.php');
}
?>