<?php

class dbConn
{
    public function __construct($server, $user, $pass, $db_characters, $db_auth, $db_world)
    {

        if (!empty($server) && !empty($user) && !empty($pass) && !empty($db_characters) && !empty($db_auth) && !empty($db_world)) {
            $this->server = $server;
            $this->user = $user;
            $this->pass = $pass;
            $this->db_characters = $db_characters;
            $this->db_auth = $db_auth;
            $this->db_world = $db_world;
            $this->connect();
        } else {
            die("Je nutno nastavit připojení k databázi.");
        }
    }

    public function connect()
    {
        $this->conn = mysql_connect($this->server, $this->user, $this->pass) or die ('Chyba, nelze se připojit k serveru MySQL');
    }

    public function selectDb($database)
    {
        switch ($database) {
            case 'characters':
                mysql_select_db($this->db_characters, $this->conn) or die ('Chyba, nelze se připojit k databázi ' . $this->db_characters . '.');
                mysql_query("SET NAMES 'utf8'");
                break;

            case 'auth':
                mysql_select_db($this->db_auth, $this->conn) or die ('Chyba, nelze se připojit k databázi ' . $this->db_auth . '.');
                mysql_query("SET NAMES 'utf8'");
                break;

            case 'world':
                mysql_select_db($this->db_world, $this->conn) or die ('Chyba, nelze se připojit k databázi ' . $this->db_world . '.');
                mysql_query("SET NAMES 'utf8'");
                break;
        }

    }

}

