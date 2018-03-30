<?php

class Web
{
    private $auth;

    public function __construct()
    {
        global $auth, $conf;
        $this->auth = $auth;
        $this->conf = $conf;
    }

    public function getSiteFileName()
    {
        if (!isset($_GET["s"])) {
            if ($this->auth->isLogged())
                $page = "pages/transfer.php";
            else
                $page = "pages/login.php";
        } else {
            if (preg_match("/^[a-z0-9]+$/", $_GET["s"]))
                $page = "pages/" . $_GET["s"] . ".php";

            else
                $page = "pages/404.php";
        }

        return $page;

    }

    public function badCharacter($text)
    {
        return !preg_match("/^[a-zA-Z0-9]{3,20}$/", $text);
    }

    public static function esc($val)
    {
        return mysql_real_escape_string(htmlspecialchars($val));
    }

    public function getHash($jmeno, $heslo)
    {
        return sha1(strtoupper($jmeno) . ':' . strtoupper($heslo));
    }
}