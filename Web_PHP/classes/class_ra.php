<?php

class Ra extends Main
{

    private $link = false;
    private $loged = false;


    public function connect($ip, $port)
    {
        if (!$this->link) {
            $errorstr = "";
            $errorno = "";

            $this->link = @fsockopen($ip, $port, $errorno, $errorstr, 5);
            if ($this->link) {
                fgets($this->link);
                return true;
            } else {
                $this->setAnnounce("Nepodařilo se připojeni k serveru.");
                return false;
            }
        } else {
            return true;
        }
    }

    public function disconnect()
    {
        if ($this->link) {
            fclose($this->link);
        } else {
            return true;
        }
    }

    public function login($user, $pass)
    {
        if ($this->link) {
            if (!empty($user) && !empty($pass)) {
                fputs($this->link, $user . "\n");
                sleep(3);
                fputs($this->link, $pass . "\n");
                sleep(3);

                if (trim(fgets($this->link)) != "Username: Password: Authentication failed") {
                    $this->setAnnounce("Uživatel přihlášen");
                    $this->loged = true;
                    return $this->loged;
                } else {
                    $this->setAnnounce("Chybně zadané uživatelské jméno a heslo");
                    return false;
                }

            } else {
                $this->setAnnounce("Uživatelské jméno a heslo nesmí být prázdné.");
                return false;
            }
        } else {
            $this->setAnnounce("Připojení k serveru nebylo navázáno.");
            return false;
        }

    }

    public function sendCommand($command)
    {

        if ($this->link) {
            if ($this->loged) {
                fputs($this->link, $command . "\n");
                sleep(2);
                fgets($this->link, 5);

                $this->setAnnounce(fgets($this->link));
                return true;
            } else {
                $this->setAnnounce("Uživatel není přihlášen");
                return false;
            }
        } else {
            $this->setAnnounce("Připojení k serveru nebylo navázáno.");
            return false;
        }

    }
}
