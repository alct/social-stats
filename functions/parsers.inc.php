<?php

// twitter parser

function twitter($account)
{
    global $twitter;

    if (! empty($account)) {

        $req = curl_init();

        curl_setopt($req, CURLOPT_FAILONERROR, true);
        curl_setopt($req, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($req, CURLOPT_HTTPHEADER, ['Accept-Language: en-us,en;q=0.5']);
        curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($req, CURLOPT_URL, 'https://twitter.com/' . $account);

        if ($res = curl_exec($req)) {

          $twitter['followers'] = preg_match('!"follower_stats"(?:.*)<strong title="([\d.,]+)"[^>]*>(?:[\d.,]+[MK]?)</strong>!iU', $res, $matches) ? str_replace([',', '.'], '', $matches[1]) : 'error';
          $twitter['tweets']    = preg_match('!"tweet_stats"(?:.*)<strong title="([\d.,]+)"[^>]*>(?:[\d.,]+[MK]?)</strong>!iU', $res, $matches) ? str_replace([',', '.'], '', $matches[1]) : 'error';

          curl_close($req);

        } else {

          $twitter['followers'] = 'error';
          $twitter['tweets']    = 'error';
        }
    } else {

        $twitter['followers'] = 0;
        $twitter['tweets']    = 0;
    }
}

// identica parser

function identica($account)
{
    global $identica;

    if (! empty($account)) {

        $req = curl_init();

        curl_setopt($req, CURLOPT_FAILONERROR, true);
        curl_setopt($req, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($req, CURLOPT_HTTPHEADER, ['Accept-Language: en-us,en;q=0.5']);
        curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($req, CURLOPT_URL, 'https://identi.ca/' . $account);

        if ($res = curl_exec($req)) {

            $identica['followers'] = preg_match('!>Followers</a>\s*([\d\.,]+)\s*</h2>!iU', $res, $matches) ? str_replace([',', '.'], '', $matches[1]) : 'error';
            $identica['notices']   = preg_match('!entity_notices">\s*<dt>Notices</dt>\s*<dd>([\d\.,]+)</dd>!iU', $res, $matches) ? str_replace([',', '.'], '', $matches[1]) : 'error';

            curl_close($req);

        } else {

            $identica['followers'] = 'error';
            $identica['notices']   = 'error';
        }
    } else {

        $identica['followers'] = 0;
        $identica['notices']   = 0;
    }
}

// facebook parser

function facebook($page)
{
    global $facebook;

    if (!empty($page)) {

        $req = curl_init();

        curl_setopt($req, CURLOPT_COOKIESESSION, true);
        curl_setopt($req, CURLOPT_FAILONERROR, true);
        curl_setopt($req, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($req, CURLOPT_HTTPHEADER, ['Accept-Language: en-us,en;q=0.5']);
        curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($req, CURLOPT_URL, $page);
        curl_setopt($req, CURLOPT_USERAGENT, 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/536.5 (KHTML, like Gecko) Chrome/19.0.1084.9 Safari/536.5');

        if ($res = curl_exec($req)) {

            $facebook['likes'] = preg_match('!>([\d\.,]+) likes ·!iU', $res, $matches) ? str_replace([',', '.'], '', $matches[1]) : 'error';

            curl_close($req);

        } else {

            $facebook['likes'] = 'error';
        }
    } else {

        $facebook['likes'] = 0;
    }
}
