<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Registration Form</title>
        <meta charset="utf-8">
        <link rel="stylesheet" type="text/css" href="main_style.css">
    </head>
    <body>
        <?php
        require_once('new_connection.php');
        $user_id = $_SESSION['user_id'];
        $query = "SELECT * FROM users WHERE users.id = '{$user_id}';";
        $account_data = run_mysql_query($query);

        if($_SESSION['process'] == "register")
        {
            ?>
            <div class="registration_container">
                <h1>Registration Successful!</h1>
                <h3>Thank you for submitting your information</h3>
                <h2><?= $account_data[0]['first_name'] . " " . $account_data[0]['last_name'] ?></h2>
                <h4>An email confirmation will be sent to your registered E-mail (<?= $account_data[0]['email'] ?>). 
                For our validation. Thank you...</h4>
                <form action="process.php" method="post">
                    <input type="hidden" name="process" value="return">
                    <input type="submit" id="return" value="Return">
                </form>
            </div>
            <?php
        }
        elseif($_SESSION['process'] == "login")
        {
            $message_data = array();
            ?>
            <div class="login_container">
                <div class="account_page">
                    <h2>CodingDojo Wall</h2>
                    <h3><p>Welcome,</p><?= $account_data[0]['first_name'] ?></h3>
                    <form action="process.php" method="post">
                        <input type="hidden" name="process" value="return">
                        <input type="submit" id="logout" value="Log Out">
                    </form>
                </div>
                <div class="message_page">
                    <form action="process.php" method="post">
                        <p>Post a message</p>
                        <textarea id="message" name="message" rows="4" cols="100"></textarea>
                        <input type="hidden" name="process" value="post">
                        <input type="submit" id="post" value="Post a message">
                    </form>
                    <?php
                    // LOAD MESSAGES
                    $query = "SELECT * FROM messages;";
                    $message_data = run_mysql_query($query);

                    foreach($message_data as $message)
                    {
                        $message_user_id = $message['user_id'];
                        $message_id = $message['id'];
                        $user_query = "SELECT * FROM users WHERE users.id = '{$message_user_id}';";
                        $user_data = run_mysql_query($user_query);
                        $date_query = "SELECT MONTHNAME(date_created) AS month, DAY(date_created) AS day, YEAR(date_created) 
                                       AS year FROM messages WHERE messages.id = '{$message_id}';";
                        $date = run_mysql_query($date_query);
                        $ordinals = "";

                        if($date[0]['day'] == 1 || $date[0]['day'] == 21 || $date[0]['day'] == 31)
                        {
                            $ordinals = "st";
                        }
                        elseif($date[0]['day'] == 2 || $date[0]['day'] == 22)
                        {
                            $ordinals = "nd";
                        }
                        elseif($date[0]['day'] == 3 || $date[0]['day'] == 23)
                        {
                            $ordinals = "rd";
                        }
                        else
                        {
                            $ordinals = "th";
                        }

                        ?>
                        <h5><?= $user_data[0]['first_name'] . " " . $user_data[0]['last_name'] . " - " . 
                        $date[0]['month'] . " " . $date[0]['day'] . "" . $ordinals . ", " . $date[0]['year'] ?></h5>
                        <?php
                        if($message_user_id == $user_id)
                        {
                            if(!isset($_SESSION['delete_error']) && empty($_SESSION['delete_error']))
                            {
                                $_SESSION['delete_error'] = array("text_color" => "white", 
                                "text_message" => "no error");
                            }
                            ?>
                            <form action="process.php" method="post">
                                <input type="hidden" name="process" value="delete">
                                <input type="hidden" name="message_id" value='<?= $message_id ?>'>
                                <input type="submit" id="delete" value="delete">
                                <?php
                                if(!isset($_SESSION['message_id']) && empty($_SESSION['message_id']))
                                {
                                    $_SESSION['message_id'] = "";
                                }
                                if($_SESSION['message_id'] == $message_id)
                                {
                                ?>
                                    <p class="delete_message" style="color: <?= $_SESSION['delete_error']['text_color'] ?>;"><?= $_SESSION['delete_error']['text_message'] ?></p>
                                <?php
                                }
                                ?>
                            </form>
                            <?php
                        }
                        ?>
                        <h6><?= $message['message'] ?></h6>

                        <div class="reply_container">
                            <?php
                            // LOAD COMMENTS
                            $comment_query = "SELECT * FROM comments WHERE message_id = '{$message_id}';";
                            $comment_data = run_mysql_query($comment_query);

                            foreach($comment_data as $comment)
                            {
                                $comment_user_id = $comment['user_id'];
                                $comment_id = $comment['id'];
                                $user_query = "SELECT * FROM users WHERE users.id = '{$comment_user_id}';";
                                $user_data = run_mysql_query($user_query);
                                $date_query = "SELECT MONTHNAME(date_created) AS month, DAY(date_created) AS day, YEAR(date_created) 
                                            AS year FROM comments WHERE comments.id = '{$comment_id}';";
                                $date = run_mysql_query($date_query);
                                $ordinals = "";

                                if($date[0]['day'] == 1 || $date[0]['day'] == 21 || $date[0]['day'] == 31)
                                {
                                    $ordinals = "st";
                                }
                                elseif($date[0]['day'] == 2 || $date[0]['day'] == 22)
                                {
                                    $ordinals = "nd";
                                }
                                elseif($date[0]['day'] == 3 || $date[0]['day'] == 23)
                                {
                                    $ordinals = "rd";
                                }
                                else
                                {
                                    $ordinals = "th";
                                }

                                ?>
                                <h5><?= $user_data[0]['first_name'] . " " . $user_data[0]['last_name'] . " - " . 
                                $date[0]['month'] . " " . $date[0]['day'] . "" . $ordinals . ", " . $date[0]['year'] ?></h5>
                                <h6><?= $comment['comment'] ?></h6>
                                <?php
                            }
                            ?>
                            <form action="process.php" method="post">
                                <p>Post a comment</p>
                                <textarea id="comment" name="comment" rows="2" cols="100"></textarea>
                                <input type="hidden" name="process" value="comment">
                                <input type="hidden" name="message_id" value='<?= $message_id ?>'>
                                <input type="submit" id="post_comment" value="Post a comment">
                            </form>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
            <?php
        }
        ?>
    </body>
</html>