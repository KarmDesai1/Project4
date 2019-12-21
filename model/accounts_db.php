<?php
{
    function validate_login($email_address, $password)
    {
        global $db;
        $query = 'SELECT * FROM accounts WHERE email = :email AND password = :password';
        $statement = $db->prepare($query);
        $statement->bindValue(':email', $email_address);
        $statement->bindValue(':password', $password);
        $statement->execute();
        $user = $statement->fetch();
        $isValidLogin = count($user) > 0;
        if (!$isValidLogin) {
            return false;
        } else {
            $userId = $user['id'];
            $statement->closeCursor();
            return $userId;
        }
        if ($isValidLogin == True) {
            $query = $DB->prepare("INSERT INTO accounts (email,fname,lname,birthday,password) VALUES
VALUES(:email_address, :fName, :lName, :dob, :password)");
            $query->bindValue(':birthday', $dob);
            $query->bindValue(':email', $email_address);
            $query->bindValue(':fisrt', $fname);
            $query->bindValue(':last', $lname);
            $query->bindValue(':password', $password);
            try {
                if ($query->execute()) {
                    return new Account($email_address, $fName, $lName, $dob);
                }
            } catch (PDOException $err) {
                echo "Account creation failed: " . $err->getMessage();
            }
            $query->closeCursor();
            return null;
        }
    }
}




