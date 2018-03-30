<?php

class Login extends Main
{

    public function __construct()
    {
        session_start();
    }

    public function userLogin($user, $password)
    {
        global $web, $db, $conf;

        if (!empty($user) && !empty($password)) {
            $user = strtoupper($web->esc($user));
            $pass = $password;
            $password = $web->getHash($user, $password);

            $db->selectDb('auth');
            $qw = mysql_query("SELECT * FROM account NATURAL JOIN account_access WHERE username='" . $user . "' AND sha_pass_hash='" . $password . "' AND gmlevel>='" . $conf['Raminlvl'] . "'");

            if (mysql_num_rows($qw) > 0) {
                $vysledek = mysql_fetch_array($qw);
                if ($vysledek['locked'] == 0) {
                    $_SESSION['user_name'] = $vysledek['username'];
                    $_SESSION['user_id'] = $vysledek['id'];
                    $_SESSION['password'] = $pass;
                    return true;
                } else {
                    $this->setAnnounce("Účet není aktivovaný.");
                    return false;
                }

            } else {
                $this->setAnnounce("Špatně zadané jméno, nebo heslo.");
                return false;
            }
        } else {
            $this->setAnnounce("Musíte vyplnit všechna pole");
            return false;
        }
    }


    public function checkLogged()
    {
        if (!$this->isLogged()) {
            header('location: ./');
            die();
        }

    }


    public function logout()
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_name']);
        unset($_SESSION['password']);
    }

    public function isLogged()
    {
        return (!empty($_SESSION['user_id']) && !empty($_SESSION['user_name']) && !empty($_SESSION['password']));
    }

    public function isOnline()
    {
        global $db;

        $db->selectDb("auth");
        if (mysql_result(mysql_query("SELECT COUNT(*) FROM account WHERE id='" . $_SESSION["user_id"] . "' AND online=1"), 0) > 0) {
            return true;
        } else
            return false;
    }
}
