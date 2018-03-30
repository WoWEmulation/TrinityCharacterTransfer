<?php

class Content
{

    private $html;
    private $title;

    public function addContent($text)
    {
        $this->html .= $text . "\n";
    }

    public function getTitle()
    {
        if (!empty($this->title)) {
            return $this->title;
        } else {
            return 'Server';
        }
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function printContent()
    {
        global $auth;

        echo '<!DOCTYPE html>' . "\n";
        echo '<html>' . "\n";
        echo '<head>' . "\n";
        echo '  <meta charset="UTF-8" />' . "\n";
        echo '  <meta name="author" content="Jiří Brada" />' . "\n";
        echo '  <meta name="description" content="Adresář, semestrální práce APV." />' . "\n";
        echo '  <meta name="keywords" content="" />' . "\n";
        echo '  <link rel="stylesheet" type="text/css" href="style.css" />' . "\n";
        echo '  <link rel="shortcut icon" href="img/ikona.ico" />' . "\n";
        echo '  <title>' . $this->getTitle() . ' - Character Transfer</title>' . "\n";
        echo '</head>' . "\n";
        echo '<body>' . "\n";
        echo '<script type="text/javascript" src="http://static.wowhead.com/widgets/power.js"></script>' . "\n";
        echo '<div id="obal">' . "\n";

        if ($auth->isLogged()) {
            echo '<div id="info">' . "\n";
            echo '<ul><li>Přihlášen ' . $_SESSION["user_name"] . "</li>\n";
            echo '<li><a href="./?s=logout">Odhlásit ' . "</a></li>\n";
            echo '<li><a href="./?s=transfer">Převést novou postavu' . "</a></li>\n";
            echo "</ul> \n";
            echo '</div>' . "\n";
        }
        echo '<h1>' . $this->title . '</h1>' . "\n";

        if (isset($this->html) && !empty($this->html)) {
            echo $this->html;
        }
        echo '<div id="footer">Vytvořil Hisgrak, <a href="http://higi.cz/">www.higi.cz</a></div>' . "\n";
        echo '</div></body>' . "\n";
        echo '</html>' . "\n";

    }
}
