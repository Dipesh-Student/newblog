<?php

/**
 * Class to complete login request
 */
class user
{

    // Properties    

    public $username = null;

    public $password = null;

    //set object properties with values from array

    public function __construct($data = array())
    {
        $this->username = trim($data['username']);
        $this->password = password_hash($data['upassword'], PASSWORD_DEFAULT);
        $this->cpass = password_hash($data['cpassword'], PASSWORD_DEFAULT);
    }

    public static function verify_user_login($username, $password)
    {
        try {

            $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $sql = "SELECT * FROM `user` WHERE usermail=:usermail";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":usermail", $username, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->rowCount();
            if ($row === 0) {
                //not registered
                echo "Not registered";
            } else {
                //registered
                $resultset = $stmt->fetch();
                $db_pass = $resultset['userpass'];
                if (password_verify($password, $db_pass)) {
                    echo "valid password";
                    $_SESSION['username'] = $username;
                    $_SESSION['isloggedin'] = true;
                } else {
                    echo "invalid credentials";
                }
            }
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    public static function register_user($email, $password, $cpass)
    {
        $email = trim($email);
        $password = trim($password);
        $cpass = trim($cpass);

        $hash_password = null;
        $error_message = null;

        $check_entry_exist = null;

        try {
            $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $sql = "SELECT * FROM `user` WHERE usermail=:usermail";
            $stmt = $conn->prepare($sql);
            $stmt->bindValue(":usermail", $email, PDO::PARAM_STR);
            $stmt->execute();
            $row = $stmt->rowCount();
            if ($row === 0) {
                //
                $check_entry_exist = 0;
            } else {
                $check_entry_exist = 1;
            }
        } catch (PDOException $e) {
            $e->getMessage();
        }
        if ($check_entry_exist === 0) {
            if ($password === $cpass) {
                $hash_password = password_hash($password, PASSWORD_DEFAULT);
                try {
                    $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
                    $conn->beginTransaction();
                    $sql = "INSERT INTO `user`(`usermail`, `userpass`) 
                VALUES (:usermail,:upassword)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindValue(":usermail", $email, PDO::PARAM_STR);
                    $stmt->bindValue(":upassword", $hash_password, PDO::PARAM_STR);
                    $stmt->execute();
                    $conn->commit();
                    $error_message = "Registration successfull";
                } catch (PDOException $e) {
                    $conn->rollBack();
                    //$e->getMessage();
                    $error_message = "Registration unsuccessfull : " . $e->getMessage();
                }
            } else {
                $error_message = "Password not matched";
            }
        } else {
            $error_message = "Already registered";
        }
        return $error_message;
    }

    public static function make_post($user, $title, $summary, $content)
    {
        $error_message = null;

        try {
            $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
            $conn->beginTransaction();
            $sql = "INSERT INTO `articles`(`username`,`title`, `summary`, `content`) 
        VALUES (:user,:title,:summary,:content)";
            $st = $conn->prepare($sql);
            $st->bindValue(':user', $user);
            $st->bindValue(':title', $title);
            $st->bindValue(':summary', $summary);
            $st->bindValue(':content', $content);
            $st->execute();
            $conn->commit();
            $error_message = "Posted Successfull";
        } catch (PDOException $e) {
            $conn->rollBack();
            $error_message = $e->getMessage();
        }
        $conn = null;
        return $error_message;
    }

    public static function get_all_post()
    {

        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "SELECT * FROM articles ORDER BY id DESC;";
        $st = $conn->prepare($sql);
        $st->execute();
        $resultset = $st->fetchAll();
        $conn = null;
        return array("res" => $resultset);
    }

    public static function get_post_byid($id)
    {

        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "SELECT * FROM articles WHERE id=:id ORDER BY id DESC;";
        $st = $conn->prepare($sql);
        $st->bindValue(":id", $id, PDO::PARAM_INT);
        $st->execute();
        $resultset = $st->fetchAll();
        $conn = null;
        return array("res" => $resultset);
    }

    public static function get_post_key($key)
    {   
        $key = trim($key);

        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "SELECT * FROM articles WHERE `content`=':key';";
        $st = $conn->prepare($sql);
        $st->bindParam(':key', $key);
        $st->execute();
        echo $count = $st->rowCount();
        $resultset = $st->fetchAll();
        $conn = null;
        //return array("res" => $resultset);
    }

}
