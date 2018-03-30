<?php

$auth->checkLogged();
$content->setTitle("Transfer postavy");

$content->addContent('
Do textového pole níže, zadejte vygenerovaný kód.<br />
<form action="./?s=fetch" method="POST">
<textarea id="kod" name="kod">
</textarea>

<input type="submit" class="button" value="Odeslat"/>
</form>
');