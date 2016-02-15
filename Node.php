<?php

require_once('Collection.php');
require_once('Attribute.php');

/**
 * Class which represents Xml node
 */
class Node
{
  /**
   * @var string - Xml node tag
   */
  protected $tag;

  /**
   * @var Collection - collection of tag attributes
   */
  protected $attributes;

  /**
   * @var Collection - collection of child nodes
   */
  protected $nodes;

  /**
   * @var string
   */
  protected $text

  /**
   * @var Xml - parent node
   */
  protected $parent;

  /**
   * Constructor
   *
   * @param string $tag
   */
  public function __construct($tag)
  {
    $this->tag        = $tag;
    $this->attributes = new Collection();
    $this->nodes      = new Collection();
  }

  /**
   * Gets tag
   *
   * @return string
   */
  public function getTag()
  {
    return $this->tag;
  }

  /**
   * Adds new attribute to node
   *
   * @param string $name
   * @param string $value
   *
   * @return Node
   */
  public function addAttribute($name, $value)
  {
    $value = $this->escapeText($value);

    $attribute = new Attribute($name, $value);
    $this->attributes->add($attribute);

    return $this;
  }

  /**
   * Removes attribute from node
   *
   * @param Attribute $attribute
   */

  public function removeAttribute(Attribute $attribute)
  {
    $this->attributes->remove($attribute);
  }

  /**
   * Gets all attributes
   *
   * @return array
   */
  public function getAttributes()
  {
    return $this->attributes->toArray();
  }

  /**
   * Gets all attributes as array of names as keys and values as values
   *
   * @return array
   */
  public function getAttributeKeyVals()
  {
    $attrs = [];
    foreach ($this->attributes->toArray() as $attr) {
      $attrs[$attr->getName()] = $attr->getValue();
    }

    return $attrs;
  }

  /**
   * Creates new node based on tag and returns newly created node
   *
   * @param string tag
   *
   * @return Node
   */
  public function addNode($tag)
  {
    $node = new Node($tag);
    $node->setParent($this);
    $this->nodes->add($node);

    return $node;
  }

  /**
   * Removes node
   *
   * @param Node $node
   */
  public function removeNode(Node $node)
  {
    $this->nodes->remove($node);
  }

  /**
   * Gets all nodes as array
   *
   * @return array
   */
  public function getNodes()
  {
    return $this->nodes->toArray();
  }

  /**
   * Sets inner element text
   *
   * @param string $text
   *
   * @return Node
   */
  public function setText($text)
  {
    $this->text = $this->escapeText($text;

    return $this;
  }

  /**
   * Gets inner element text
   *
   * @return string
   */
  public function getText()
  {
    return $this->text;
  }

  /**
   * Sets parent node
   *
   * @param Node $node
   *
   * @return Node
   */
  public function setParent(Node $node)
  {
    $this->parent = $node;

    return $this;
  }

  /**
   * Gets parent node
   *
   * @return Node or Xml
   */
  public function getParent()
  {
    return $this->parent;
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
    if ($this->nodes->isEmpty()) {
      $xml .= $this->getShortTag();
    } else {
      $xml .= $this->getStartTag();
      foreach ($this->nodes->toArray() as $node) {
        $xml .= $node->toXml();
      }
      $xml .= $this->getEndTag();
    }

    return $xml;
  }

  /**
   * Gets short xml tag ie. <tag attr1="attr1" />
   *
   * @return string
   */
  private function getShortTag()
  {
    return "<{$this->tag}{$this->getTagAttributes()} />";
  }

  /**
   * Gets start tag ie. <tag attr1="attr1">
   *
   * @return string
   */
  private function getStartTag()
  {
    return "<{$this->tag}{$this->getTagAttributes()}>";
  }

  /**
   * Gets all tag's attributes ie. attr1="attr1"
   *
   * @return string
   */
  private function getTagAttributes()
  {
    $tag = '';
    foreach ($this->attributes->toArray() as $attribute) {
      $tag .= " {$attribute->getName()}=\"{$attribute->getValue()}\"";
    }

    return $tag;
  }

  /**
   * Gets end tag ie. </tag>
   *
   * @return string
   */
  private function getEndTag()
  {
    return "</{$this->tag}>";
  }

  /**
   * Appends Xml as child node. Before appending it is converted to Node.
   * Returns newly appended node.
   *
   * @param Xml $xml
   *
   * @return Node
   */
  public function appendXml(Xml $xml)
  {
    $newNode = $xml->toNode()->setParent($this);
    $this->nodes->add($newNode);

    return $newNode;
  }

  /**
   * Finds a descendant node by tag name, returns new collection with matched
   * nodes
   *
   * @param string $tag
   *
   * @return Collection
   */
  public function findNodesByTag($tag)
  {
    $matchedNodes = new Collection();
    foreach ($this->nodes->toArray() as $node) {
      if ($node->getTag() === $tag) {
        $matchedNodes->add($node);
      }
      $matchedNodes->merge($node->findNodesByTag($tag));
    }

    return $matchedNodes;
  }

  /**
   * Finds a descendant node by tag name and an array attributes, returns
   * new collection with matched nodes
   *
   * @param string $tag
   * @param array $attributes
   *
   * @return Collection
   */
  public function findNodesByTagAndAttibutes($tag, array $attributes)
  {
    $matchedNodes = new Collection();
    foreach ($this->nodes->toArray() as $node) {
      $areAttrsMatch = true;
      foreach ($attributes as $attr => $val) {
        $attrs = $this->getAttributeKeyVals();
        if (!isset($attrs[$attr]) || $attrs[$attr] !== $val) {
          $areAttrsMatch = false;
          break;
        }
      }
      if ($areAttrsMatch && $node->getTag() === $tag) {
        $matchedNodes->add($node);
      }
      $matchedNodes->merge($node->findNodesByTagAndAttibutes($tag));
    }

    return $matchedNodes;
  }

  /**
   * Escapes special characters
   *
   * @param string $value
   *
   * @return string
   */
  protected function escapeText($value) {
    return str_replace(
      ['<',     '>',    '&',      "'",      '"'],
      ['&lt;',  '&gt;', '&amp;',  '&apos;', '&quot;'],
      $value
    );
  }
}
