<?php

ini_set('date.timezone', 'Asia/Tokyo');
mb_internal_encoding("UTF-8");

$protocol   = isset($_SERVER["https"]) ? 'https' : 'http';
$domain     =  $protocol . '://' . $_SERVER['HTTP_HOST'];
$requestUrl = $domain . $_SERVER['REQUEST_URI'];
$route      = ltrim(str_replace($domain, '', $requestUrl), '/');
if ($route == '') { $route = 'index'; }
define("WEB_ROOT"      , $domain);
define("REQUEST_URL"   , $requestUrl);
define("REQUEST_ROUTE" , $route);
define("REQUEST_METHOD", $_SERVER["REQUEST_METHOD"]);
if (REQUEST_ROUTE === 'favicon.ico') { exit(); }


$js = <<<JS

  document.getElementById('result').innerHTML = JSON.stringify(navigator.userAgentData);

  const elm = document.getElementById('sp_menu_btn');
  if (elm) {
    elm.onclick = () => { 
      console.log('########');
    };
  }

JS;

$cssFiles = [
    'element.css',
    'size.css',
    'layout.css',
    'icon.css',
    'spacing.css',
    'style.css',
];

// css build
$pcMinWidth = 800;
$primary = '#4169e1';
$css = '';
foreach ($cssFiles as $cssFile) {
    $css .= file_get_contents('src/' . $cssFile) . "\n";
}

$spacing = '';
foreach (range(1, 20) as $i) {
    $num = $i * 2;
    $spacing .= ".ml{$num} { margin-left: {$num}px; }" . "\n";
    $spacing .= ".mb{$num} { margin-bottom: {$num}px; }" . "\n";
}
$css .= "\n" . $spacing . "\n";
$css = str_replace(['@PC_MIN_WIDTH', '@PRIMARY'], [$pcMinWidth, $primary], $css);

file_put_contents('assets/nora.css', $css);


$html = file_get_contents('example.html');
echo $html;

