<?php
require("config.php");
session_start();

/**
 * if exists bind session username to variable  
 */
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
}

$action = isset($_GET['action']) ? $_GET['action'] : "";

switch ($action) {
    case 'login':
        login();
        break;
    case 'logout':
        logout();
        break;
    case 'register':
        register_user();
        break;
    case 'post':
        mk_post();
        break;
    case 'view_post':
        view_post();
        break;
    case 'search':
        search();
        break;
    case 'myprofile':
        myprofile();
        break;
    default:
        home();
        break;
}

function login()
{
    /**
     * @array to store values required for templates
     */
    $result = new ArrayObject();

    /**
     *  CASE : '1' perform checks if user has already logged in
     * CHECKING SESSION HAS VALUES
     * else load login form
     */

    /**
     * CASE : '2'  if form is post submit pass post variable to perform login checks using
     * verify_user_login 
     */
    if (isset($_SESSION['username']) && isset($_SESSION['upassword'])) {
        echo "Already logged in";
        print_r($_SESSION['username']);
    } elseif (isset($_POST['login'])) {
        echo user::verify_user_login($_POST['username'], $_POST['upassword']);
        echo "hi";
        if (isset($_SESSION['username'])) {
            // print_r($_SESSION['username']);
            // require(TEMPLATE_PATH . "/homepage.php");
            home();
        } else {
            echo "session empty";
        }
    } else {
        $result['pagetitle'] = "try login";

        require(TEMPLATE_PATH_USER . "login_form.php");
    }
}

function logout()
{
    /**
     * unlink and destroy session values and redirect user to login
     */
    session_unset();
    session_destroy();
    login();
}

function register_user()
{
    if (isset($_POST['register'])) {
        echo user::register_user($_POST['email'], $_POST['upassword'], $_POST['cpassword']);
    } else {
        require(TEMPLATE_PATH . "/user_temp/register_from.php");
    }
}

function home()
{
    $r = array();
    $post_list = user::get_all_post();
    $r['data'] = $post_list['res'];

    require(TEMPLATE_PATH . "/homepage.php");
}

function mk_post()
{
    $result = array();
    if (isset($_POST['makepost'])) {
        $title = $_POST['btitle'];
        $content = $_POST['bcontent'];
        $summary = implode(' ', array_slice(str_word_count($content, 1), 0, 15));

        $post = user::make_post('user', $title, $summary, $content);
        $result['error'] = $post;
    }
    header("Location:index.php");
}

function view_post()
{
    $r = array();
    $data = user::get_post_byid($_GET['pid']);
    $r['data'] = $data['res'];

    $result['pagetitle'] = "hello";

    require(TEMPLATE_PATH . "/view_post.php");
    exit;
}

function search()
{
    $s = $_POST['search'];
    //echo $s;
    $result = array();
    $post_list = user::get_post_key($s);
    $result['error'] = $post_list['error'];
    $result['data'] = $post_list['res'];

    require(TEMPLATE_PATH . "/search.php");
}

function myprofile()
{
    //$u = trim($_SESSION['username']);
    // if (isset($_SESSION['username'])) {
    //     $result['username'] = $_SESSION['username'];
    //     $result['pagetitle'] = "Profile " . $result['username'];

    //     $data = user::get_post_user($result['username']);
    //     require(TEMPLATE_PATH . "/myprofile.php");
    // } else {
    //     echo "n";
    // }
    if(isset($_SESSION['username'])){
        $r = array();
        $post_list = user::get_post_user($_SESSION['username']);
        $r['data'] = $post_list['res'];
        require(TEMPLATE_PATH . "/homepage.php");
    }
    else{
        echo "Can't show any post's from your profile";
    }

    
}
