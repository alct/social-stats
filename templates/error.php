<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />

  <link rel="stylesheet" media="screen" href="ui/global.min.css" />

  <title>Social stats</title>
</head>

<body>
<div id="header">
<div class="wrapper">
  <h1><a href="./#dashboard" tabindex="1">Social stats</a></h1>
</div>
</div>

<div id="content">
<div class="wrapper">
<?php

if ($error == 'config_not-found') {
  echo '<h2>Missing config file</h2><p>Please rename the <code>/config.example.php</code> file into <code>/config.php</code></p>';
} elseif ($error == 'config_empty') {
  echo '<h2>Empty config file</h2><p>Please edit the <code>/config.php</code> file.</p>';
} elseif ($error == 'account_not-found') {
  echo '<h2>Account not found</h2><p>The requested account was not found on this server.</p>';
} elseif ($error == 'account_no-twitter') {
  echo '<h2>No Twitter account set</h2><p>Please set a Twitter account in the <code>/config.php</code> file.</p>';
} elseif ($error == 'log_permission') {
  echo '<h2>Access forbidden</h2><p>There was an error trying to read and/or write log file.</p>';
}

?>
</div>
</div>

<div id="footer">
<div class="wrapper">
  <p>Powered by <a href="https://github.com/alct/social-stats">Social stats</a>.</p>
</div>
</div>

</body>
</html>