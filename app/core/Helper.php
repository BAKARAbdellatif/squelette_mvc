<?php

class HelperFunctions
{

    public function __construct__()
    {
        echo "Hello Helper";
    }

    public function import($path)
    {
        include __DIR__ . $path;
    }

    public static function isEmail($email)
    {
        if (preg_match("/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/", $email)) {
            return true;
        }
        return false;
    }

    public static function encrypt_decrypt($action, $string)
    {
        $output = false;
        $encrypt_method = "AES-256-CBC";
        $secret_key = '4Vob6l32Wn8ITnT4';
        $secret_iv = 'apozi987jhgdhjs6765kjhsfjhsazpmo';
        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        if ($action == 'encrypt') {
            $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
            $output = base64_encode($output);
        } else if ($action == 'decrypt') {
            $output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
        }
        return $output;
    }

    public static function dateFormMYSQLtoFormat($datetimeStr, $format = "d/m/Y à H:i")
    {
        $datetime = DateTime::createFromFormat('Y-m-d H:i:s', $datetimeStr);
        return $datetime->format($format);
    }

    public static function dateDifference($start_date, $end_date)
    {
        // Convert the date strings to DateTime objects
        $start_datetime = new DateTime($start_date);
        $end_datetime = new DateTime($end_date);

        // Calculate the interval between the two dates
        $interval = $start_datetime->diff($end_datetime);

        // Build the result string
        $result = "";
        if ($interval->d > 0) {
            $result .= $interval->d . " Jours";
        }
        if ($interval->h > 0) {
            $result .= " " . $interval->h . " Heures";
        }
        if ($interval->i > 0) {
            $result .= " " . $interval->i . " Minutes";
        }
        if ($interval->s > 0) {
            $result .= " " . $interval->s . " Seconds";
        }

        return $result;
    }

    public static function hasRole($role, $privileges = [])
    {
        if (in_array($role, $privileges)) {
            return true;
        } else {
            return false;
        }
    }

    public static function dateToMySQLFromFormat($date, $format)
    {
        $parsedDate = date_parse_from_format($format, $date);
        if ($parsedDate && $parsedDate["error_count"] === 0) {
            // Obtenez les éléments de date analysés
            $year = $parsedDate["year"];
            $month = str_pad($parsedDate["month"], 2, "0", STR_PAD_LEFT);
            $day = str_pad($parsedDate["day"], 2, "0", STR_PAD_LEFT);

            // Formatez la date au format MySQL (YYYY-MM-DD)
            $mysqlDate = "$year-$month-$day";

            return $mysqlDate;
        } else {
            // La date n'a pas pu être analysée selon le format donné
            return false;
        }
    }
}
