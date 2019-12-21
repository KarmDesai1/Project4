<?php
require('template/header.php');
?>
    <h1>Registration Page</h1>
    <form action="index.php" method="post">
        <input type="hidden" name="action" value="register">
        <div id="data">
            <label> First Name </label>
            <input type="text" name="fName"><br>

            <label> Last Name </label>
            <input type="text" name="lName"><br>

            <label> Birthday </label>
            <input type="date" name="dob" value="yyyy-dd-mm"><br>

            <label> Email </label>
            <input type="email" name="email_address"><br>

            <label> Password </label>
            <input type="password" name="password"><br>

            <div id="lower">

                <div id = "buttons">
                    <label>&nbsp;</label>
                    <input type="submit" value="submit"><br>
                </div>

                <div>
                <button type="button"><a href="login.php">Back</a></button>
                </div>

            </div>
        </div>
    </form>
<?php require('template/footer.php'); ?>