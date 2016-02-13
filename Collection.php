<?php

/**
 * Collection class which has additional useful methods for managing its
 * elements
 */
class Collection
{
  /**
   * Internal elements array
   *
   * @var array
   */
  private $elements = [];

  /**
   * Add new element
   *
   * @param $elem
   */
  public function add($elem)
  {
    $this->elements[] = $elem;
  }

  /**
   * Removes element
   *
   * @param $elem
   */
  public function remove($elem)
  {
    $elemPos = array_search($elem, $this->elements);
    if (false !== $elemPos) {
      array_splice($this->elements, $elemPos, 1);
    }
  }

  /**
   * Gets an array representation of collection
   *
   * @return array
   */
  public function toArray()
  {
    return $this->elements;
  }

  /**
   * Gets amount of elements in collection
   *
   * @return int
   */
  public function count()
  {
    return count($this->elements);
  }

  /**
   * Checks if collection has no elements
   *
   * @return bool
   */
  public function isEmpty()
  {
    return empty($this->elements);
  }

  /**
   * Adds elements from another collection
   *
   * @param Collection $col
   */
  public function merge(Collection $col)
  {
    $this->elements = array_merge($this->elements, $col->toArray());
  }

  /**
   * Gets first element in collection or returns null if it's empty
   *
   * @return $elem
   */
  public function first()
  {
    return isset($this->elements[0]) ? $this->elements[0] : null;
  }
}
