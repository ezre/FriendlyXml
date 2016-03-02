# FriendlyXml
Library to manage xml files which is useful and friendly.

### Usage

```php
<?php

require('./Xml.php');

$xml =
    (new Xml())
        ->setTag('root')
        ->addAttribute('example', 'true')
        ->addNode('child')
            ->addAttribute('myattribute', 'myval')
            ->addAttribute('mynextattribute', 'mynextval')
            ->addNode('nestedchild')
            ->getParent()
        ->getParent()
    ;

echo "<pre><code>" . htmlentities($xml->toXml()) . "</code></pre>";
```
