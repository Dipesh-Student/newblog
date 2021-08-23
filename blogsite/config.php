<?php 
ini_set( "display_errors", true );//false on live server
date_default_timezone_set( "Asia/Kolkata" );  // http://www.php.net/manual/en/timezones.php
define( "DB_DSN", "mysql:host=localhost;dbname=cms" );
define( "DB_USERNAME", "root" );
define( "DB_PASSWORD", "" );

define( "CLASS_PATH", "classes" );//path to main class files

define("CLASS_PATH_USER","classes/user/");// path to object user file
require( CLASS_PATH_USER . "user.php" );

define("CLASS_PATH_POST","classes/post/");// path to object post file
require(CLASS_PATH_POST . "post.php");

define("TEMPLATE_PATH", "templates" );//path to html templates
define("TEMPLATE_PATH_USER","templates/user_temp/");

define( "HOMEPAGE_NUM_ARTICLES", 5 );//no of articles to be shown on homepage 
define( "ADMIN_USERNAME", "dipesh" );//
define( "ADMIN_PASSWORD", "dipesh" );

function handleException( $exception ) {
  echo "Sorry, a problem occurred. Please try later.";
  error_log( $exception->getMessage() );
}

set_exception_handler( 'handleException' );
?>