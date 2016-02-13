<?php

/**
 * Class which represents Xml tag attribute
 */
class Attribute
{
  /**
   * @var string
   */
  private $name;

  /**
   * @var string
   */
  private $value;

  /**
   * Constructor
   *
   * @param string $name
   * @param string $value
   */
  public function __construct($name, $value)
  {
    $this->name   = $name;
    $this->value  = $value;
  }

  /**
   * Sets name
   *
   * @param string $name
   *
   * @return Attribute
   */
  public function setName($name)
  {
    $this->name = $name;

    return $this;
  }

  /**
   * Gets name
   *
   * @return string
   */
  public function getName()
  {
    return $this->name;
  }

  /**
   * Sets value
   *
   * @param string $value
   *
   * @return Attribute
   */
  public function setValue($value)
  {
    $this->value = $value;

    return $this;
  }

  /**
   * Gets value
   *
   * @return string
   */
  public function getValue()
  {
    return $this->value;
  }
}
