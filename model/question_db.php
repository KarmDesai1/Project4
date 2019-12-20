<?php
function get_questions($ownerId)
{
    global $db;
    $query =('SELECT * FROM questions WHERE ownerId = :ownerId');
    $statement=$db->prepare($query);
    $statement->bindValue(':ownerId', $ownerId);
    $statement->execute();
    $questions = $statement->fetchAll();
    $statement->execute();
    return $questions;
}
function deleteQuestion($ownerId) {
    global $db;
    $query =$db->prepare("DELETE * FROM questions WHERE id= $ownerId");
    $query->bindValue(':ownerId',$ownerId);
    try{
        $query->excute();
        header("Location ./");
        exit();
    }
    catch (PDOException $err){
        echo "Failure to create account";
        return false;
    }
}
function editQuestion(&$title, &$body,&$skills)
{
    global $db;
    $ownerId = filter_input(INPUT_POST, 'ownerId');
    $title = filter_input(INPUT_POST, 'title');
    $body = filter_input(INPUT_POST, 'body');
    $skills = explode(",", filter_input(INPUT_POST, 'skills'));
    $title = strlen($title) > 2;
    $body = strlen($body) > 0;
    $skills = count($skills) > 1;
    if ($title && $body && skills) {
        $query = $db->prepare('UPDATE questions SET title = :title, body= :body, skills =skills WHERE id= :id');
        $query->bindValue(':title', $title);
        $query->bindValue(':body', $body);
        $query->bindValue(':ownerId', $ownerId);
        $query->bindValue(':skills', implode(',', $skills));
        try {
            $query->excute();
            header("Location: ./");
            exit();
        } catch (PDOException $err) {
            echo "Failure to create account";
            return false;
        }
    }
    function new_Question(&$title, &$body, &$skills)
    {
        global $db;
        $title = filter_input(INPUT_POST, 'title');
        $body = filter_input(INPUT_POST, 'body');
        $skills = explode(",", filter_input(INPUT_POST, 'skills'));
        $account = unserialize($_SESSION["account"]);
        if ($title && $body && $skills) {
            // TODO: Create the question
            $query = $db->prepare("INSERT INTO questions (account_email, title, body, skills)
                VALUES(:email, :title, :body, :skills)");
            $query->bindValue(':email', $account->getEmail());
            $query->bindValue(':title', $title);
            $query->bindValue(':body', $body);
            $query->bindValue(':skills', implode(',', $skills));
            try {
                $query->execute();
                header("Location: ./");
                exit();
            } catch (PDOException $error) {
                echo "We can't find the new Question:" . $error->getMessage();
                return false;
            }
            $query->closeCursor();
        }
        return null;
    }
    function getAll_questions()
    {
        global $db;
        $answer = [];
        $account = unserialize($_SESSION["account"]);
        $query = $db->prepare("SELECT * FROM questions WHERE email_address = :email_address");
        $query->bindValue(':email_address', $account->getEmail());
        try {
            $query->execute();
            $rows = $query->fetchAll();
            exit();
        } catch (PDOException $err) {
            echo "We can't get the Question:" . $err->getMessage();
            return false;
        }
        foreach ($rows as $row) {
            array_push($answer, new Question($row["id"], $row["title"], $row["account_email"], $row["body"], date_create($row["created_at"]), explode(',', $row["skills"])));
        }
        $query->closeCursor();
        return $answer;
    }
    function validate_question($email_address, $password,$first,$last,$birthday)
    {
        global $db;
        $query = 'SELECT * FROM accounts WHERE email = :email AND password = :password';
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email_address);
        $statement->bindValue(':password', $password);
        $statement->bindValue(':first', $first);
        $statement->bindValue(':last', $last);
        $statement->bindValue(':birthday', $birthday);
        $statement->execute();
        $user = $statement->fetch();
        $isValidQuestion = count($user) > 0;
        if (!$isValidQuestion) {
            return false;
        } else {
            $userId = $user['id'];
            $statement->closeCursor();
            return $userId;
        }
    }
}