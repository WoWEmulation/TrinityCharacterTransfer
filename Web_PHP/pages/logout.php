<?php

if ($auth->isLogged())
    $auth->logout();

header("location: ./");
