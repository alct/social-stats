<?php

require_once 'parsers.inc.php';

function set_account($id) {
  global $account;

  $id = str_replace(array('/','[','\\','^','$','.','|','?','*','+','(',')','{','}','&','=','<','>','\'','"'), '', $id);

  if (count($GLOBALS['accounts']) > 0) {
    if (empty($id)) {
      $account['title']    = $GLOBALS['accounts'][0]['title'];
      $account['twitter']  = $GLOBALS['accounts'][0]['twitter'];
      $account['identica'] = $GLOBALS['accounts'][0]['identica'];
      $account['facebook'] = $GLOBALS['accounts'][0]['facebook'];
    } else {
      foreach ($GLOBALS['accounts'] as $array) {
        if (preg_grep('/^' . $id . '$/i', $array)) {
          $account['title']    = $array['title'];
          $account['twitter']  = $array['twitter'];
          $account['identica'] = $array['identica'];
          $account['facebook'] = $array['facebook'];
          break;
        }
      }
    }
  }
}

function update_log() {
  twitter($GLOBALS['account']['twitter']);
  identica($GLOBALS['account']['identica']);
  facebook($GLOBALS['account']['facebook']);

  if (!file_exists($GLOBALS['localRawLog'])) {
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

  if ($file = @fopen($GLOBALS['localRawLog'], 'a+')) {
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

    return true;
  } else {
    return false;
  }
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

  $charts .= !empty($GLOBALS['account']['twitter'])  ? 'true, true, ' : 'false, false, ';
  $charts .= !empty($GLOBALS['account']['identica']) ? 'true, true, ' : 'false, false, ';
  $charts .= !empty($GLOBALS['account']['identica']) ? 'true, '       : 'false, ';

  return $charts;
}

function get_account_menu() {
  global $accountMenu;

  $accountMenu .= '  <div id="accounts">' . "\n";
  $accountMenu .= '    <p><span>Current account:</span> <span class="current" tabindex="2">' . $GLOBALS['account']['title'] . '</span></p>' . "\n";
  $accountMenu .= '    <ul>' . "\n";

  $i = 3;

  foreach ($GLOBALS['accounts'] as $array) {
    $current = $array['title'] == $GLOBALS['account']['title'] ? ' class="current"' : '';

    $accountMenu .= '      <li' . $current . '><a href="?id=' . $array['twitter'] . '" tabindex="' . $i . '">' . $array['title'] . '</a></li>' . "\n";

    $i++;
  }

  $accountMenu .= '    </ul>' . "\n";
  $accountMenu .= '  </div>' . "\n";

  return $accountMenu;
}

?>