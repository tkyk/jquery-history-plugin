<?php

error_reporting(E_ALL);
ini_set('display_errors', 'on');

function error($msg="") {
    echo $msg;
    exit;
}

function h($s) {
    return htmlspecialchars($s, ENT_QUOTES, 'utf-8');
}

function buildSelector($values, $selected) {
    $ret = array();
    foreach($values as $v){
        $ret[] = sprintf("<option value='%s'%s>%s</option>",
                         h($v), $v == $selected ? ' selected="selected"' : '', h($v));
    }
    return join("\n", $ret);
}

function jsWithTimestamp($file) {
    echo sprintf('<script type="text/javascript" src="%s"></script>',
                 h($file ."?". date('YmdHis')));
}

function jQuerySelector() {
    $jqueries = glob("../jquery/*.js");
    if(count($jqueries) == 0) {
        error("No jquery found in jquery/.");
    }
    sort($jqueries);

    if(!isset($_GET['jquery'])) {
        $jquery = $jqueries[count($jqueries)-1];
    } else {
        foreach($jqueries as $path) {
            if($path === $_GET['jquery']) {
                $jquery = $path;
            }
        }
    }
    return array($jqueries, $jquery);
}

function IEModeSelector() {
    // name => DTD, header
    $modes = array('quirk' => array('', ''),
                   'ie7'   => array('', '<meta http-equiv="X-UA-Compatible" content="IE=7" />'),
                   'xhtml' => array('<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" '
                                    .'"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">', ''));
    $mode = !isset($_GET['ie_mode']) || !isset($modes[$_GET['ie_mode']]) ?
        'xhtml' : $_GET['ie_mode'];
    return array(array_keys($modes),
                 array_merge(array($mode), $modes[$mode]));
}

list($jqueries, $jquery) = jQuerySelector();
list($modes, $mode) = IEModeSelector();

list($ie_mode, $dtd, $header) = $mode;
echo empty($dtd) ? "" : $dtd . "\n";
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <?php echo $header ?>
  <title>jQuery History Plugin Test</title>
  <script type="text/javascript" src="<?php echo $jquery ?>"></script>
    <?PHP echo jsWithTimestamp('../../jquery.history.js') ?>
    <?PHP echo jsWithTimestamp('./debugger.js') ?>
</head>
<body>
    <form action="">
    jQuery: <select name="jquery"><?php echo buildSelector($jqueries, $jquery) ?></select>
    IE Mode: <select name="ie_mode"><?php echo buildSelector($modes, $ie_mode) ?></select>
    <input type="submit" value="change" />
    </form>
  <h1>jQuery History Plugin Debugger Sample</h1>

  <div id="ie-info"></div>
  <div id="type-info"></div>
  <ul class="history-links">
  <li><a href="#1">load 1</a></li>
  <li><a href="#2">load 2</a></li>
  <li><a href="#3">load 3</a></li>
  <li><a href="#åäö">load åäö</a></li>
  <li><a href="#+:/;,???abc=/xyz/&amp;def">load +:/;,???abc=/xyz/&amp;def</a></li>
  <li><a href="#%2525">load %2525</a></li>
  <li><input id="hash-input" size="20" /><input type="button" id="load-hash" value="load hash" />
  <input type="button" id="replace-hash" value="replace hash" /></li>
  </ul>
  <div id="load"></div>
  <p><button onclick="history.back()">history.back()</button></p>
  <textarea id="history-log" style="font-size: 12px; font-family: monospace; width: 800px; height: 100px;">log
</textarea>
  <hr />
  <p>[<a href="../">All samples</a>] [<a href="http://github.com/tkyk/jquery-history-plugin">Project home</a>]</p>
</body>
</html>
