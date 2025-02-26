<?php

require 'vendor/autoload.php';


$code = new \pkg6\paypal\Code();

var_dump($code->readState());