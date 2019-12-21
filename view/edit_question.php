<?php
require ('template/')
?>
<h1>New Question Form</h1>
    <form action="index.php" method="post">
        <input type="hidden" name="action" value="create_new_question">
        <div id="container">
            <div class="form-group">
                <label>Owner ID</label>
                <input type="text" name="ownerId" <br>
            </div>
            <div class="form-group">
                <label>The Question Name </label>
                <input type="text" name="Name"><br>
            </div>
            <div class="form-group">
                <label> The Question Body</label>
                <input type="text" name="Body"><br>
            </div>
            <div class="form-group">
                <label> Question Skill </label>
                <input type="text" name="Skills"><br>
            </div>
            <div id = "buttons">
                <button type="submit" class="button is-primary">Submit</button>
            </div>
        </div>
    </form>