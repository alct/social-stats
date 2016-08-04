<?php

require_once 'parsers.inc.php';

function get_identity($id) {
  $id = str_replace(array('/','[','\\','^','$','.','|','?','*','+','(',')','{','}','&','=','<','>','\'','"'), '', $id);

  if (count($GLOBALS['identities']) > 0) {
    if (empty($id)) {
      $identity['title']    = $GLOBALS['identities'][0]['title'];
      $identity['twitter']  = $GLOBALS['identities'][0]['twitter'];
      $identity['identica'] = $GLOBALS['identities'][0]['identica'];
      $identity['facebook'] = $GLOBALS['identities'][0]['facebook'];

      return $identity;
    } else {
      foreach ($GLOBALS['identities'] as $array) {
        if (preg_grep('/^' . $id . '$/i', $array)) {
          $identity['title']    = $array['title'];
          $identity['twitter']  = $array['twitter'];
          $identity['identica'] = $array['identica'];
          $identity['facebook'] = $array['facebook'];

          return $identity;
          break;
        }
      }
    }
  } else {
    return false;
  }
}

function set_current_identity() {
  global $currentIdentity;

  $id = isset($_GET['id']) ? $_GET['id'] : '';

  if ($currentIdentity = get_identity($id)) {
    return true;
  } else {
    return false;
  }
}

function update_log() {
  $id         = isset($_GET['id']) ? $_GET['id'] : '';
  $identities = array();

  if (!empty($id)) {
    if (get_identity($id)) {
      $identities[0] = get_identity($id);
    } else {
      return false;
      break;
    }
  } else {
    $identities = $GLOBALS['identities'];
  }

  header('Content-Type: application/json');

  $json  = '';

  $items = count($identities);
  $i     = 0;

  foreach ($identities as $array) {
    if (!file_exists('log/social-stats_' . $array['twitter'] . '.raw.csv')) {
      $headers =
        'date'               . ',' .
        'Twitter followers'  . ',' .
        'Twitter tweets'     . ',' .
        'Identica followers' . ',' .
        'Identica notices'   . ',' .
        'Facebook likes'     . "\n"
      ;
    } else {
      $headers = '';
    }

    $json .= '"' . $array['twitter'] . '":{';

    twitter($array['twitter']);
    $json .= '"twitter":{"followers":' . $GLOBALS['twitter']['followers'] . ',"tweets":' . $GLOBALS['twitter']['tweets'] . '},';

    identica($array['identica']);
    $json .= !empty($array['identica']) ? '"identica":{"followers":' . $GLOBALS['identica']['followers'] . ',"notices":' . $GLOBALS['identica']['notices'] . '},' : '';

    facebook($array['facebook']);
    $json .= !empty($array['facebook']) ? '"facebook":{"likes":' . $GLOBALS['facebook']['likes'] . '},' :  '';

    if ($file = @fopen('log/social-stats_' . $array['twitter'] . '.raw.csv', 'a+')) {
      fputs($file,
        $headers .
        time()                            . ',' .
        $GLOBALS['twitter']['followers']  . ',' .
        $GLOBALS['twitter']['tweets']     . ',' .
        $GLOBALS['identica']['followers'] . ',' .
        $GLOBALS['identica']['notices']   . ',' .
        $GLOBALS['facebook']['likes']     . "\n"
      );

      fclose($file);

      $json .= '"log":1';
    } else {
      $json .= '"log":0';
    }

    $json .= '}' . ($i < $items - 1 ? ',' : '');
    $i++;
  }

  $json = str_replace('error', '"error"', $json);
  return '{' . $json . '}';
}

function export_log() {
  if ($handle = @fopen($GLOBALS['localRawLog'], 'r')) {
    global $data, $csv;

    while (($buffer = fgets($handle)) !== false) {
      $col = explode(',', trim(str_replace('error', 0, $buffer)));

      if ($col[0] != 'date') {
        $col[0] = date('Ymd', $col[0]);

        // if values are already set for a given day, merge data and keep highest values
        if (isset($data[$col[0]])) {
          for ($i = 1; $i < count($col); $i++) {
            $col[$i] = $col[$i] < $data[$col[0]][$i - 1] ? $data[$col[0]][$i - 1] : $col[$i];
          }
        }
      }

      $data[$col[0]] = array($col[1], $col[2], $col[3], $col[4], $col[5]);
    }

    fclose($handle);

    foreach ($data as $timestamp => $stats) {
      $csv .=
        $timestamp . ',' .
        $stats[0]  . ',' .
        $stats[1]  . ',' .
        $stats[2]  . ',' .
        $stats[3]  . ',' .
        $stats[4]  . "\n"
      ;
    }

    if ($file = fopen($GLOBALS['localLog'], 'w+')) {
      fputs($file, $csv);
      fclose($file);

      return true;
    } else {
      return false;
    }

    return true;
  } else {
    return false;
  }
}

function get_visible_charts() {
  global $charts;

  $charts .= !empty($GLOBALS['currentIdentity']['twitter'])  ? 'true, true, ' : 'false, false, ';
  $charts .= !empty($GLOBALS['currentIdentity']['identica']) ? 'true, true, ' : 'false, false, ';
  $charts .= !empty($GLOBALS['currentIdentity']['facebook']) ? 'true, '       : 'false, ';

  return $charts;
}

function get_identities_menu() {
  global $identitiesMenu;

  $identitiesMenu .= '  <div id="identities">' . "\n";
  $identitiesMenu .= '    <p><span>Current identity:</span> <span class="current" tabindex="2">' . $GLOBALS['currentIdentity']['title'] . '</span></p>' . "\n";
  $identitiesMenu .= '    <ul>' . "\n";

  $i = 3;

  foreach ($GLOBALS['identities'] as $array) {
    $current = $array['title'] == $GLOBALS['currentIdentity']['title'] ? ' class="current"' : '';

    $identitiesMenu .= '      <li' . $current . '><a href="?id=' . $array['twitter'] . '" tabindex="' . $i . '">' . $array['title'] . '</a></li>' . "\n";

    $i++;
  }

  $identitiesMenu .= '    </ul>' . "\n";
  $identitiesMenu .= '  </div>' . "\n";

  return $identitiesMenu;
}

?>