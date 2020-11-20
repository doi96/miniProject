<?php
    include_once 'config/core.php';
    $page_title = 'Forgot Password!';

    //insert login checker
    include_once 'login_checker.php';
    //include data and class
    include_once 'config/Database.php';
    $database = new Database();
    $db = $database->getConnection();

    include_once 'Controller/User.php';
    include_once 'libs/php/utils.php';

    $user = new User($db);
    $utils = new Utils();
    // Include header layouts
    include_once 'layouts/layout_header.php';

// if the login form was submitted
if ($_POST) {

    echo "<div class='col-sm-12'>";

    // check if username and password are in the database
    $user->email = $_POST['email'];

    if ($user->emailExists()) {

        // update access code for user
        $access_code = $utils->getToken();

        $user->access_code = $access_code;
        if ($user->updateAccessCode()) {

            // send reset link
            $body = "Hi there.<br /><br />";
            $body .= "Please click the following link to reset your password: <a href='{$home_url}reset_password.php?access_code={$access_code}'>Click here to update your password!</a>";
            $subject = "Reset Password";
            $send_to_email = $_POST['email'];

            if ($utils->sendEmailViaPhpMail($send_to_email, $subject, $body)) {
                echo "<div class='alert alert-info'>
                            Password reset link was sent to your email.
                            Click that link to reset your password.
                        </div>";
            }

            // message if unable to send email for password reset link
            else {
                echo "<div class='alert alert-danger'>ERROR: Unable to send reset link.</div>";
            }
        }

        // message if unable to update access code
        else {
            echo "<div class='alert alert-danger'>ERROR: Unable to update access code.</div>";
        }
    }

    // message if email does not exist
    else {
        echo "<div class='alert alert-danger'>Your email cannot be found.</div>";
    }

    echo "</div>";
}

// show reset password HTML form
echo "<div class='col-md-4'></div>";
echo "<div class='col-md-4'>";

echo "<div class='account-wall'>
        <div id='my-tab-content' class='tab-content'>
            <div class='tab-pane active' id='login'>
                <img class='profile-img' src='uploads/login-icon.png'>
                <form class='form-signin' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='post'>
                    <input type='email' name='email' class='form-control' placeholder='Your email' required autofocus>
                    <input type='submit' class='btn btn-lg btn-primary btn-block' value='Send Reset Link' style='margin-top:1em;' />
                </form>
            </div>
        </div>
    </div>";

echo "</div>";
echo "<div class='col-md-4'></div>";

    //include footer layouts
    include_once 'layouts/layout_footer.php';

?>