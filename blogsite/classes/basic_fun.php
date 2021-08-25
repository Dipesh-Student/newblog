<?php

/**
 * this script contain some miscellaenous function to be used across project
 */

class basic_fun
{
    public static function elapsed_time($datetime, $username, $full = false)
    {        
        //utc
        $user_timezone = null;
        $localdatetime = null;
        try {
            $conn = new PDO(DB_DSN,DB_USERNAME,DB_PASSWORD);
            $sql_time = "SELECT * FROM `user` WHERE usermail=:username;";
            $stmt = $conn->prepare($sql_time);
            $stmt->bindParam(":username", $username);
            $stmt->execute();
            $result = $stmt->rowCount();
            if ($result === 0) {
                echo "Failed to retrieve userdata timezone;";
                $user_timezone = "UTC";//set default to utc
            } else {
                while ($row = $stmt->fetch()) {
                    $user_timezone = $row['timezone'];
                    //echo "datab : ".$user_timezone;
                }
            }
        } catch (PDOException $e) {
            //echo $e->getMessage();
        } //get timezone from database
        if (!empty($user_timezone)) {
            //convert utcdatestamp to localtime
            $utcval = $datetime; //utc datetimestamp from function
            $convertto = $user_timezone; //user local timezone val from database
            $utc_date = DateTime::createFromFormat(
                'Y-m-d H:i:s',
                $utcval,
                new DateTimeZone('UTC')
            );

            $acst_date = clone $utc_date; // we don't want PHP's default pass object by reference here
            $acst_date->setTimeZone(new DateTimeZone($convertto));

            //echo '<br>value passed from database UTC :  ' . $utc_date->format('Y-m-d H:i:s');
            $utc_date->format('Y-m-d H:i:s');
            //echo " /// local time ", $localdatetime = $acst_date->format('Y-m-d H:i:s') . " $convertto,";
            $localdatetime = $acst_date->format('Y-m-d H:i:s');
        }

        //convert time to timepassed ago
        $now = new DateTime;

        $ago = new DateTime($localdatetime);
        $diff = $now->diff($ago);
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
        $string = array('y' => 'year', 'm' => 'month', 'w' => 'week', 'd' => 'day', 'h' => 'hour', 'i' => 'minute', 's' => 'second');
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now' . $user_timezone;
    }
}
//echo basic_fun::elapsed_time("2021-08-24 22:20:31","dipesh");
