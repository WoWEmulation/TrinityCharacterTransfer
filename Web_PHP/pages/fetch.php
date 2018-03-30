<?php

$auth->checkLogged();

$content->setTitle("Zobrazení a kontrola");

if (isset($_POST["kod"]) && !empty($_POST["kod"])) {
    $par = new Parse($_POST["kod"]);
    if ($par->getEnterCheck()) {
        $par->printInv();
        $par->printBags();
        $content->addContent('
      <br />
    <form action="./?s=fetch" method="post">
    Zde napiste jméno cílového characteru:<br />
    <input type="text" name="targetCharacter" value="" />
      <input type="hidden" name="kod2" value="' . $_POST["kod"] . '" />
      <input type="submit" class="button" name="odeslat" value="Odeslat předměty" />
    </form>
    ');
    } else {
        $content->addContent("Data neprošla vstupní kontrolou, nebyla změněna?. <br />");
    }

} else if (isset($_POST["kod2"]) && !empty($_POST["kod2"]) && isset($_POST["targetCharacter"])) {
    $par = new Parse($_POST["kod2"]);
    if ($par->sendItems($_POST["targetCharacter"])) {
        header("location: ./?s=fetch");
        die;
    } else {
        $content->addContent('
    Při odesální předmětů se vyskytla chyba.<br />
    ' . $par->getAnnounce());
    }
} else if (isset($_SESSION["anno"]) && !empty($_SESSION["anno"])) {

    $content->addContent('
  Předměty byly úspěšně odeslány');

    $_SESSION["anno"] = null;

} else {
    header("location: ./");
    die;
}
