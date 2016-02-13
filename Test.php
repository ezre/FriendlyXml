<?php

require('./Xml.php');

$xml =
  (new Xml())
    ->setTag('root')
    ->addAttribute('dupa', '1')
    ->addNode('elo')
      ->addAttribute('count', 'derp')
      ->addAttribute('herp', 'derpina1')
      ->addNode('karpatinos')
      ->getParent()
    ->getParent()
  ;

echo "<pre><code>" . htmlentities($xml->toXml()) . "</code></pre>";


$xml
  ->findNodesByTag('karpatinos')
  ->first()
    ->addNode('sraka')
    ->addAttribute('esoes', 'true')
  ;

echo "<BR><BR><BR>";
echo "<pre><code>" . htmlentities($xml->toXml()) . "</code></pre>";
