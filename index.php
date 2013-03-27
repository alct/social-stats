<?php

// prevent caching

header('Cache-Control: no-cache, must-revalidate');
header('Expires: ' . gmdate('D, d M Y H:i:s', time() - 60 * 60 * 24) . ' GMT');

// check if there is a config file

if (!file_exists('config.php') && file_exists('config.example.php')) {
  $error = 'config_not-found';

  require_once 'templates/error.php';
  exit;
}

// load ressources

require_once 'config.php';
require_once 'functions/app.inc.php';

// set the $currentIdentity var (first identity in the config file by default)

set_current_identity();

// logs

$localLog    = 'log/social-stats_' . $currentIdentity['twitter'] . '.csv';
$localRawLog = 'log/social-stats_' . $currentIdentity['twitter'] . '.raw.csv';

// handle updates

if (isset($_GET['update'])) {
  if ($json = update_log()) {
    echo $json;
  } else {
    header('HTTP/1.0 404 Not Found');
  }

  exit;
}

// handle identity related errors

if (count($GLOBALS['identities']) == 0 || !is_array($currentIdentity) || empty($currentIdentity['twitter'])) {
  if (count($GLOBALS['identities']) == 0) {
    $error = 'config_empty';
  } elseif (!is_array($currentIdentity)) {
    $error = 'identity_not-found';
  } elseif (empty($currentIdentity['twitter'])) {
    $error = 'identity_no-twitter';
  }

  require_once 'templates/error.php';
  exit;
}

// if the log files have not been created yet

if (!file_exists($localRawLog)) {
  if(!update_log()) {
    $error = 'log_permission';

    require_once 'templates/error.php';
    exit;
  }
}

// export raw log

if (!export_log()) {
  $error = 'log_permission';

  require_once 'templates/error.php';
  exit;
}

// include base template

require_once 'templates/base.php';

?>