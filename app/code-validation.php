<?php

error_reporting(E_ALL);
$code = $argv[1];

eval($code);

return "1";