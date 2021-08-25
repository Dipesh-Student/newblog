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

    /**
     * check username and password if exists start session with required values
     */
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
                // case user not registered
                echo "Not registered";
            } else {
                // case user is registered
                $resultset = $stmt->fetch();
                $db_pass = $resultset['userpass'];
                if (password_verify($password, $db_pass)) {
                    echo "valid password";
                    $_SESSION['username'] = $username;
                    $_SESSION['isloggedin'] = true;
                    //header("Location:index.php");
                } else {
                    echo "invalid credentials";
                }
            }
        } catch (PDOException $e) {
            $e->getMessage();
        }
    }

    /**
     * register user 
     */
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

    /**
     * create post function 
     */
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

    /**
     * return all records as array of data
     */
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

    /**
     * return record for @param int $id as array of data
     */
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

    /**
     * return record for @param string $key as array of data
     */
    public static function get_post_key($key)
    {
        $search = trim($key);

        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "SELECT * FROM `articles` WHERE title LIKE :search OR content LIKE :search";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':search', $search, PDO::PARAM_STR);
        $stmt->execute();
        echo $count = $stmt->rowCount();
        $resultset = $stmt->fetchAll();
        $conn = null;
        if ($count === 0) {
            return array("error" => "No result for " . $search);
        } else {
            return array("res" => $resultset);
        }
    }

    /**
     * return record for @param string $username as array of data /LOGGED IN USER
     */

    public static function get_post_user($user)
    {
        $username = trim($user);

        $conn = new PDO(DB_DSN, DB_USERNAME, DB_PASSWORD);
        $sql = "SELECT * FROM `articles` WHERE username=:username;";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->execute();
        echo $count = $stmt->rowCount();
        $resultset = $stmt->fetchAll();
        $conn = null;
        if ($count === 0) {
            return array("error" => " You haven't made any post yet ");
        } else {
            return array("res" => $resultset);
        }
    }
}
