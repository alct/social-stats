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

<?= get_identities_menu() ?>
</div>
</div>

<div id="nav">
<div class="wrapper">
  <ul>
    <li class="current"><a href="#dashboard" tabindex="101">Dashboard</a></li>
    <?= (!empty($currentIdentity['twitter']))  ? '<li><a href="#twitter" tabindex="102">Twitter</a></li>' : '' ?>
    <?= (!empty($currentIdentity['identica'])) ? '<li><a href="#identica" tabindex="103">Identica</a></li>' : '' ?>
    <?= (!empty($currentIdentity['facebook'])) ? '<li><a href="#facebook" tabindex="104">Facebook</a></li>' : '' ?>
  </ul>
</div>
</div>

<div id="content">
<div class="wrapper">
  <div id="options">
		<?= (!empty($currentIdentity['twitter']))  ? '
    <div class="network twitter">
      <div>
        <input type="checkbox" checked="checked" name="twitter[]" id="twitter_followers" value="0" tabindex="105" />
        <label for="twitter_followers">Twitter followers</label>
      </div>
      <div>
        <input type="checkbox" checked="checked" name="twitter[]" id="twitter_tweets" value="1" tabindex="106" />
        <label for="twitter_tweets">Twitter tweets</label>
      </div>
    </div>' : '' ?>
		<?= (!empty($currentIdentity['identica'])) ? '
    <div class="network identica">
      <div>
        <input type="checkbox" checked="checked" name="identica[]" id="identica_followers" value="2" tabindex="107" />
        <label for="identica_followers">Identica followers</label>
      </div>
      <div>
        <input type="checkbox" checked="checked" name="identica[]" id="identica_notices" value="3" tabindex="108" />
        <label for="identica_notices">Identica notices</label>
      </div>
    </div>' : '' ?>
		<?= (!empty($currentIdentity['facebook'])) ? '
    <div class="network facebook">
      <div>
        <input type="checkbox" checked="checked" name="facebook[]" id="facebook_likes" value="4" tabindex="109" />
        <label for="facebook_likes">Facebook likes</label>
      </div>
    </div>' : '' ?>
    <div>
      <p id="period"><span class="label">Period:</span><span class="button current" tabindex="110">Overall</span><span class="separator">/</span><span class="button" tabindex="111">Current month</span></p>
      <p id="scale"><span class="label">Scale:</span><span class="button current" tabindex="112">Linear</span><span class="separator">/</span><span class="button" tabindex="113">Logarithmic</span></p>
    </div>
  </div>

	<div id="graph" class="graph"></div>

	<h2>Accounts</h2>

	<ul>
		<?= (!empty($currentIdentity['twitter']))  ? '<li>Twitter account: <a href="https://twitter.com/' . $currentIdentity['twitter'] . '">@' . $currentIdentity['twitter'] . '</a></li>' : '' ?>
		<?= (!empty($currentIdentity['identica'])) ? '<li>Identi.ca account: <a href="https://identi.ca/' . $currentIdentity['identica'] . '">@' . $currentIdentity['identica'] . '</a></li>' : '' ?>
		<?= (!empty($currentIdentity['facebook'])) ? '<li>Facebook page: <a href="' . $currentIdentity['facebook'] . '">' . $currentIdentity['facebook'] . '</a></li>' : '' ?>
	</ul>

	<h2>Data</h2>

	<p>This chart is based uppon the data gathered in this <a href="<?= $localLog ?>">log</a> [<a href="<?= $localRawLog ?>">raw</a>].</p>
</div>
</div>

<div id="footer">
<div class="wrapper">
  <p>Powered by <a href="https://github.com/alct/social-stats">Social stats</a>.</p>
</div>
</div>

<script>
  var localLog = '<?= $localLog ?>';
  var graphVisibility = [<?= get_visible_charts() ?>];
</script>
<script src="js/app-combined.min.js"></script>
</body>
</html>