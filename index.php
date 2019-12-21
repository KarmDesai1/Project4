<?php
session_start();
//$_SESSION['authenticated']=true;
//$_SESSION['name']=htmlentities($_POST['name']);
require('model/database.php');
require('model/accounts_db.php');
require('model/question_db.php');

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'display_login';
    }
}
switch ($action) {
    case 'display_login':
    {
        include('view/login.php');
        break;
    }
    case 'login':
    {
        $email_address = filter_input(INPUT_POST, 'email');
        $password = filter_input(INPUT_POST, 'password');
        $i = strpos($email_address, '@');
        if (empty($email_address)) {
            echo("Please type in a email address");
        } else if ($i === false) {
            echo('Please type in Valid Email');
        } else {
            echo $email_address;
        }
//        Validate the password
        if (empty($password)) {
            echo("Please type a password in");
        } else if (strlen($password) <= 8) {
            echo("The password needs to be longer than 8 characters");
        } //        validate login
        else {
            $userId = validate_login($email_address, $password);
            echo "The ID for this user is: $userId";
            if ($userId == false) {
                header("Location: .?action=display_registration");
            } else {
                $_SESSION['userId'] = $userId;
                echo "The ID for this user is: $userId";
                header("Location: .?action=display_question&userId=$userId");
            }
        }
        break;
    }
    case 'display_users':
    {
        $userId = filter_input(INPUT_GET, 'userId');
        if (!$_SESSION['userId']) {
            header("Location: .");
            exit();
        } else if ($userId == NULL) {
            echo 'owner id not available';
        } else {
            $questions = get_questions($userId);
            include('view/questions.php');
            echo $userId;
        }
        break;
    }
    case 'display_registration':{
        include('view/registration.php');
        break;
    }
    case 'register':{
        //get information from registration.php (Registration form)
        $email_address = filter_input(INPUT_POST, 'email_address');
        $password = filter_input(INPUT_POST, "password");
        $fName = filter_input(INPUT_POST, "fName");
        $lName = filter_input(INPUT_POST, "lName");
        $dob = filter_input(INPUT_POST, "dob");
        //Set Validate a boolean  to TRUE
        $valid = true;
        //Validate data in the form
        if (empty($email_address)) {
            echo("Please type a email in");
            $valid = false;
        } else if (strpos($email_address, '@') === false) {
            echo('There is no @ in the email');
            $valid = false;
        }
        if (empty($password)) {
            echo("Please type a password in");
            $valid = false;
        } elseif (strlen($password) <= 7) {
            echo("The Password needs to greater than 8 characters");
            $valid = false;
        }
        if (empty($fname)) {
            echo("Please Type a Name in");
            $valid = false;
        }
        if (empty($lname)) {
            echo("Please Type Last Name in");
            $valid = false;
        }
        if (empty($birthday)) {
            echo("Please Type Birthday");
            $valid = false;
        }
        if ($valid = true) {
//SQL Query
            $query = 'INSERT INTO accounts
    (email, password, fname, lname, birthday)
    VALUES
    (:email_address, :password, :fName, :lName, :dob)';
// Create PDO Statement
            $statement = $db->prepare($query);
//statement-> bind
            $statement->bindValue(':email', $email_address);
            $statement->bindValue(':password', $password);
            $statement->bindValue(':fname', $fName);
            $statement->bindValue(':lname', $lName);
            $statement->bindValue(':birthday', $dob);
//execute
            $statement->execute();
//Close the database
            $statement->closeCursor();
        }
        header("Location: .?action=display_login");
        break;
    }
    case 'display_question':{
        include('view/questions.php');
        break;
    }
    case 'display_new_question':{
        include('view/new_question.php');
        break;
    }
    case 'create_new_question':{
        $userId = validate_login($email_address, $password);
        echo "The ID for this user is: $userId";
        $account = unserialize($_SESSION['userId']);


        $Name = filter_input(INPUT_POST, "Name");
        $Body = filter_input(INPUT_POST, "Body");
        $Skills = filter_input(INPUT_POST, "Skills");
        $ownerId = filter_input(INPUT_POST, 'ownerId');

        $valid = true;

//Check validation of Name
        if (empty($Name)) {
            echo "Please type a name for user in";
            $valid = false;
        } else {
            echo $Name;
            echo "<br>";
        }
        if ($Name != strlen($Name) <= 3) {
            $message = "Need Longer name";
            $valid = false;
        }
//Check validation of Body
        if (empty($Body)) {
            echo "Please type body in";
            $valid = false;
        } else {
            //if validation is false then echo the body and the skills
            echo $Body;
            echo "<br>";
            echo $Skills;
        }
        if ($Body != strlen($Body) >= 500) {
            echo  "The Question needs to be less than 500 characters";
            $valid = false;
        }
        if (empty($Skills)) {
            echo "Please type a skills in";
            $valid = false;
        } elseif (strpos($Skills, ',') === true) {
            $Array = explode(',', $Skills);
            echo '<pre>';
            print_r($Array);
            echo '</pre>';
            echo array_keys($Array);
            print_r($Array);
        }
        if ($valid = true) {
            //SQL Query
            $query = 'INSERT INTO questions
    (body, skills, title, ownerId)
    VALUES
    (:body, :skills, :title, :ownerId)';
    // Create PDO Statement
            $statement = $db->prepare($query);
    //statement-> bind
            $statement->bindValue(':body', $Body);
            $statement->bindValue(':skills', $Skills);
            $statement->bindValue(':title', $Name);
            $statement->bindValue(':ownerId', $ownerId);
            //$statement->bindValue()
            echo "$Body, $Skills, $Name, $ownerId";
    //execute
            $statement->execute();
    //Close the database
            $statement->closeCursor();
        } else {
            echo('You must re do form');
        }
        header("Location: .?action=display_question&userId=$userId");
        break;
    }
    case 'display_edit_question':{
        include('view/edit_question.php');
        break;
    }
    case 'edit_question':{
        global $db;
        $ownerId = filter_input(INPUT_POST, 'ownerId');
        $title = filter_input(INPUT_POST, 'title');
        $body = filter_input(INPUT_POST, 'body');
        $skills = explode(",", filter_input(INPUT_POST, 'skills'));
        $title = strlen($title) > 2;
        $body = strlen($body) > 0;
        $skills = count($skills) > 1;
        if ($title && $body && $skills) {
            $query = $db->prepare('UPDATE questions SET title = :title, body= :body, skills =skills WHERE id= :id');
            $query->bindValue(':title', $title);
            $query->bindValue(':body', $body);
            $query->bindValue(':ownerId', $ownerId);
            $query->bindValue(':skills', implode(',', $skills));
        }
        break;
    }
    case 'delete_question':{

        global $db;
        $id = filter_input(INPUT_POST, 'id');
        $query = 'DELETE from questions WHERE id =: id';
        $statement = $db->prepare($query);
        $statement->bindValue(':id', $id);
        $statement->execute();
        $statement->closeCursor();
        break;
    }
    case 'vote':
    {
        global $db;

        if (isset($_POST['upvote'])) {
            $query ='UPDATE question SET score=upvote + 1,WHERE ownerid=$userId AND :id=$id ';
        } else if (isset($_POST['downvote'])) {
            $query ='UPDATE question SET score=downvote + 1,WHERE ownerid=$userId AND :id=$id ';
        }
        $statement->execute();
        $statement->closeCursor();
        break;
    }

//    case 'update_question_list':{
//
//    }
////    case 'question_view':{
//
//
//    }
}