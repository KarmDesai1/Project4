<?php
session_start();
$_SESSION['authenticated']=true;
$_SESSION['name']=htmlentities($_POST['name']);
require('model/database.php');
require('model/accounts_db.php');
require('model/question_db.php');

$action = filter_input(INPUT_POST, 'action');
if ($action == NULL) {
    $action = filter_input(INPUT_GET, 'action');
    if ($action == NULL) {
        $action = 'show_login';
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
                header("Location: .?action=display_question&userId=$userId");
            }
        }
        break;
    }
    case 'display_users':
    {
        $userId = filter_input(INPUT_GET, 'userId');
        if (!$_SESSION['account']) {
            header("Location: .");
            exit();
        } else if ($userId == NULL) {
            $error = 'User Id unavailable';
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
//    case 'register':{
//
//        break;
//    }
    case 'display_question':{
        include('view/questions.php');
        break;
    }
    case 'display_new_question':{
        include('view/new_question.php');
        break;
    }
//    case 'create_new_question':{
//
//    }
    case 'display_edit_question':{
        include('view/edit_question.php');
        break;
    }
//    case 'edit_question':{
//
//    }
//    case 'delete_question':{
//
//    }
//    case 'up_vote':{
//
//    }
//    case 'down_vote':{
//
//    }
//    case 'update_question_list':{
//
//    }
//    case 'question_view':{
//
//
//    }
}