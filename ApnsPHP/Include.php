<?php

$path = dirname(__FILE__);
if(empty($path)) {
  throw new Exception('Current path is empty');
}

$files = array(
  'Abstract.php',
  'Exception.php',
  'Feedback.php',
  'Message.php',
  'Push.php',
  'Log/Interface.php',
  'Log/Embedded.php',
  'Message/Custom.php',
  'Message/Exception.php',
  'Push/Exception.php',
);

foreach($files as $f)
  require_once($path . '/' . $f);
