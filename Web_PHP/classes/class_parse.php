<?php

class Parse extends Main
{

    private $commands = array();
    private $targetCharName;
    private $enterCheck = false;

    public $itemSlot = array('ammo', 'head', 'neck', 'shoulder', 'shirt', 'chest', 'belt', 'legs',
        'feet', 'wrist', 'gloves', 'finger 1', 'finger 2', 'trinket 1', 'trinket 2', 'back', 'main hand',
        'off hand', 'ranged', 'tabard', 'first bag (the rightmost one)', 'second bag', 'third bag',
        'fourth bag (the leftmost one)');

    public function __construct($str)
    {
        global $content;
        if ($this->enterCheck = preg_match("/^([1-9][0-9]{0,2},[1-9][0-9]{0,15};)+\|([1-9][0-9]?,[1-9][0-9]{0,15};)+\|[0-9]*\|[1-9][0-9]?\|[A-Z][a-z]{2,10}\|(Death Knight|Druid|Hunter|Mage|Paladin|Priest|Rogue|Shaman|Warlock|Warrior|Monk)$/", $str)) {
            $str = explode("|", $str);
            $this->inBags = explode(";", substr($str[0], 0, -1));
            $this->inv = explode(";", substr($str[1], 0, -1));
            $this->money = $str[2];
            $this->level = $str[3];
            $this->name = $str[4];
            $this->cClass = $str[5];
        }

    }

    public function getEnterCheck()
    {
        return $this->enterCheck;
    }

    public function printInv()
    {
        global $content, $db, $web;


        if ($this->enterCheck) {
            $content->addContent("<h2>" . $this->level . " " . $this->cClass . " " . $this->name . "</h2>");
            $content->addContent("<h2>Iventář - Equiped items</h2>");
            $content->addContent('<table id="vypis">');
            $content->addContent("  <tr><th>SLOT</th><th>NÁZEV ITEMU</th></tr>");

            $db->selectDb('world');

            foreach ($this->inv as &$value) {
                $value = explode(",", $value);
                $res = mysql_fetch_array(mysql_query("SELECT name, quality FROM item_template WHERE entry='" . $web->esc($value[1]) . "'"));
                $content->addContent('<tr><td>' . $this->itemSlot[$value[0]] . '</td><td><a href="http://www.wowhead.com/item=' . $value[1] . '" class="q' . $res["quality"] . '">' . $res["name"] . '</a></td></tr>');
            }

            $content->addContent("<tr><td>" . $this->getGold($this->money) . "</td></tr>");
            $content->addContent("</table>");
        }

    }

    public function printBags()
    {
        global $content, $db, $web;

        if ($this->enterCheck) {
            $content->addContent("<h2>Iventář - Obsah batohů</h2>");
            $content->addContent('<table id="vypis">');
            $content->addContent("  <tr><th>POČET</th><th>NÁZEV ITEMU</th></tr>");

            $db->selectDb('world');

            foreach ($this->inBags as &$value) {
                $value = explode(",", $value);
                $res = mysql_fetch_array(mysql_query("SELECT name, quality FROM item_template WHERE entry='" . $web->esc($value[1]) . "'"));
                if (!empty($res)) {
                    $content->addContent('<tr><td>' . $value[0] . 'x</td><td><a href="http://www.wowhead.com/item=' . $value[1] . '" class="q' . $res["quality"] . '">' . $res["name"] . '</a></td></tr>');
                }
            }
            $content->addContent("</table>");
        }


    }

    private function sendInv()
    {
        $i = 0;
        $it = 0;
        $itemStr = "";

        foreach ($this->inv as &$value) {
            $value = explode(",", $value);
            $i++;
            $it++;
            $itemStr .= " " . $value[1];

            if ($i == 12 || $it == count($this->inv)) {
                array_push($this->commands, 'send items ' . $this->targetCharName . ' "Prevod postavy" "Dobry den  zasilame predmety z programu prevod postavy.  S pozdravem GM team."' . $itemStr);
                $i = 0;
                $itemStr = "";
            }
        }
    }

    private function sendBags()
    {
        $i = 0;
        $it = 0;
        $itemStr = "";

        foreach ($this->inBags as &$value) {
            $value = explode(",", $value);
            $i++;
            $it++;

            if ($value[0] > 1) {
                $itemStr .= " " . $value[1] . "[:" . $value[0] . "]";
            } else {
                $itemStr .= " " . $value[1];
            }

            if ($i == 12 || $it == count($this->inBags)) {
                array_push($this->commands, 'send items ' . $this->targetCharName . ' "Prevod postavy" "Dobry den  zasilame predmety z programu prevod postavy (Obsah batohu).  S pozdravem GM team."' . $itemStr);
                $i = 0;
                $itemStr = "";
            }
        }
    }

    private function sendMoney()
    {
        if ($this->money > 0) {
            array_push($this->commands, 'send money ' . $this->targetCharName . ' "Prevod postavy" "Dobry den  zasilame penize z programu prevod postavy.  S pozdravem GM team." ' . $this->money);
        }
    }

    public function sendItems($charname)
    {
        global $conf, $content, $web, $db;


        if ($this->enterCheck) {

            if (isset($charname) && !empty($charname)) {
                $this->targetCharName = $web->esc(ucfirst(strtolower($charname)));
                $db->selectDb("characters");
                if (mysql_result(mysql_query("SELECT COUNT(guid) FROM characters WHERE name='" . $this->targetCharName . "'"), 0) > 0) {
                    $this->sendInv();
                    $this->sendBags();
                    $this->sendMoney();

                    $ra = new Ra;
                    if ($ra->connect($conf['ip'], $conf['port'])) {
                        if ($ra->login($_SESSION['user_name'], $_SESSION['password'])) {
                            $_SESSION["anno"] = "";
                            foreach ($this->commands as $key => $value) {
                                $ra->sendCommand($this->commands[$key]);
                                $_SESSION["anno"] .= $ra->getAnnounce() . "<br />";
                            }
                            $ra->disconnect();
                            return true;
                        } else {
                            $ra->disconnect();
                            return false;
                        }

                    } else {
                        return false;
                    }
                } else {
                    $this->setAnnounce("Zadané jméno characteru neexistuje");
                    return false;
                }
            } else {
                $this->setAnnounce("Je nutné vyplnit nové jméno postavy.");
                return false;
            }
        }
    }
}
