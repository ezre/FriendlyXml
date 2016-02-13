<?php

require('Node.php');
require_once('Collection.php');
require_once('Attribute.php');

/**
 * Xml class has additional methods for changing Xml properties
 */
class Xml extends Node
{
  /**
   * @var string
   */
  private $encoding;

  /**
   * @var string
   */
  private $version;

  /**
   * Constructor
   */
  public function __construct()
  {
    $this->encoding   = 'UTF-8';
    $this->version    = '1.0';
    $this->attributes = new Collection();
    $this->nodes      = new Collection();
  }

  /**
   * Sets xml version
   *
   * @param string
   *
   * @return Xml
   */
  public function setVersion($version)
  {
    $this->version = $version;

    return $this;
  }

  /**
   * Gets version
   *
   * @return string
   */
  public function getVersion()
  {
    return $this->version;
  }

  /**
   * Sets charset encoding
   *
   * @param string
   *
   * @return Xml
   */
  public function setEncoding($encoding)
  {
    $this->encoding = $encoding;

    return $this;
  }

  /**
   * Gets charset encoding
   *
   * @return Xml
   */
  public function getEncoding()
  {
    return $this->encoding;
  }

  /**
   * Sets tag
   *
   * @param string
   *
   * @return Xml
   */
  public function setTag($tag)
  {
    $this->tag = $tag;

    return $this;
  }

  /**
   * Parses xml string and imports it into object structure
   *
   * @param string
   *
   * @return Xml
   */
  public function parse($xmlString)
  {
    $charArray = str_split($xmlString);

    foreach ($charArray as $char) {

    }

    return $this;
  }

  /**
   * Sets parent node
   *
   * @param Node $node
   *
   * @return null
   */
  public function setParent(Node $node)
  {
    return;
  }

  /**
   * Gets parent node
   *
   * @return null
   */
  public function getParent()
  {
    return;
  }

  /**
   * Returns an Xml representation
   *
   * @param string $xml (optional)
   *
   * @return string
   */
  public function toXml($xml = '')
  {
    $xml = "<?xml version=\"{$this->version}\" encoding=\"{$this->encoding}\"?>"
      . parent::toXml();

    return $xml;
  }

  /**
   * Converts Xml to Node by copying tag, attributes and children
   *
   * @return Node
   */
  public function toNode()
  {
    $newNode = new Node($this->tag);
    foreach ($this->attributes->toArray() as $attr) {
      $newNode->addAttribute($attr);
    }
    foreach ($this->nodes->toArray() as $node) {
      $newNode->addNode($node);
    }

    return $newNode;
  }
}
