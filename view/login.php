<?php
require('view/template/header.php');
?>
    <h1>Login Form</h1>
    <form action = "../index.php" method="post">
        <input type="hidden" name="action" value="validate_login">

        <div class="form-group">
<!--            //user input for email-->
            <label> Email Address </label>
            <input type="email" class="form-control" name="email" id="'email_address"><br>
        </div>
        <div class="form-group">
<!--            //input for Password-->
            <label> Password (8 characters Min)</label>
            <input type="password" id="password" class="form-control" name="password"><br>
        </div>

        <div id = "buttons">
            <button type="submit" class="button is-primary"> Login</button>
            <br>
            <button type="button"><a href=".?action=display_registration">New User? Register Here</a> </button>
            <form action="../index.php" method="post">
        </div>
    </form>

<?php include ('view/template/footer.php'); ?>
