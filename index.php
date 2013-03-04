<?php

// check if there is a config file

if (!file_exists('config.php') && file_exists('config.example.php')) {
  $error = 'config_not-found';

  require_once 'templates/error.php';
  exit;
}

// load ressources

require_once 'config.php';
require_once 'functions/app.inc.php';

// set the $account var containing information about a given id

set_account(isset($_GET['id']) ? $_GET['id'] : '');

// logs

$localLog    = 'log/social-stats_' . $account['twitter'] . '.csv';
$localRawLog = 'log/social-stats_' . $account['twitter'] . '.raw.csv';

// prevent caching

header('Cache-Control: no-cache, must-revalidate');
header('Expires: ' . gmdate('D, d M Y H:i:s', time() - 60 * 60 * 24) . ' GMT');

// handle account related errors

if (count($GLOBALS['accounts']) == 0 || !is_array($account) || empty($account['twitter'])) {
  if (count($GLOBALS['accounts']) == 0) {
    $error = 'config_empty';
  } elseif (!is_array($account)) {
    $error = 'account_not-found';
  } elseif (empty($account['twitter'])) {
    $error = 'account_no-twitter';
  }

  require_once 'templates/error.php';

  exit;
}

// handle updates

if (isset($_GET['update']) || isset($_GET['export'])) {
  echo '{"timestamp": ' . time() . ', "account": "' . $account['twitter'] . '", "status": {';

  if (isset($_GET['update'])) {
    echo '"update": ';
    echo update_log() ? '1, ' : '0, ';
  }

  if (isset($_GET['export'])) {
    echo '"export": ';
    echo export_log() ? '1,' : '0,';
  }

  echo '}}';

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

if (!export_log()) {
  $error = 'log_permission';

  require_once 'templates/error.php';
  exit;
}

require_once 'templates/base.php';

?>