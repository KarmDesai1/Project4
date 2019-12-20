<?php
require('template/header.php');
?>
    <h1>Registration Page</h1>
    <form action="../index.php" method="post">
        <div id="data">
            <label> First Name </label>
            <input type="text" name="first"><br>

            <label> Last Name </label>
            <input type="text" name="last"><br>

            <label> Birthday </label>
            <input type="date" name="birthday" value="yyyy-mm-dd"><br>

            <label> Email </label>
            <input type="email" name="email_address"><br>

            <label> Password </label>
            <input type="password" name="password"><br>
            <div id="lower">
                <div id = "buttons">
                    <label> &nbsp;</label>
                    <input type="submit" value="submit"><br>
                </div>
                <button type="button"><a href="login.php">Back</a></button>
            </div>
        </div>
    </form>
<?php require('template/footer.php'); ?>