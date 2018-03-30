<?php

$content->setTitle("Přihlášení");

if (isset($_POST["odeslat"])) {
    if ($auth->userLogin($_POST["jmeno"], $_POST["heslo"])) {
        header("location: ./");
    }
}

$content->addContent('
<form action="./?s=login" method="POST">
  <table id="login">
    <tr><td>' . $auth->getAnnounce() . '</td></tr>
    <tr><td>Uživatelské jméno<br />
      <input type="text" name="jmeno"></td></tr>
    <tr><td>Heslo<br />
      <input type="password" name="heslo"></td></tr>
    <tr><td><input type="submit" value="Přihlásit se" name="odeslat"></td></tr>        
  </table>
</form>
');