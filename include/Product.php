<?php


class Product
{
 private  $sessionId;
 private  $id;
 private  $title;
 private  $size;
 private  $color;
 private  $quantity;
 private $timeofcreation;

    /**
     * @return mixed
     */
    public function getTimeofcreation()
    {
        return $this->timeofcreation;
    }

    /**
     * @param mixed $timeofcreation
     */
    public function setTimeofcreation($timeofcreation)
    {
        $this->timeofcreation = $timeofcreation;
    }

    /**
     * Product constructor.
     * @param $sessionId
     * @param int $id
     * @param string $title
     * @param string $size
     * @param string $color
     * @param int $quantity
     * @param $timeofcreation
     */
    public function __construct($sessionId, $id,  $title, $size,  $color, $quantity, $timeofcreation)

    {
        $this->sessionId=$sessionId;
        $this->id = $id;
        $this->title = $title;
        $this->size = $size;
        $this->color = $color;
        $this->quantity = $quantity;
        $this->timeofcreation = $timeofcreation;

    }

    /**
     * @return String
     */
    public function getSessionId()
    {
        return $this->sessionId;
    }

    /**
     * @param String $sessionId
     */
    public function setSessionId( $sessionId)
    {
        $this->sessionId = $sessionId;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getCatId()
    {
        return $this->cat_id;
    }

    /**
     * @param int $cat_id
     */
    public function setCatId($cat_id)
    {
        $this->cat_id = $cat_id;
    }

    /**
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    /**
     * @return float
     */


    /**
     * @return string
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * @param string $size
     */
    public function setSize($size)
    {
        $this->size = $size;
    }

    /**
     * @return string
     */
    public function getColor()
    {
        return $this->color;
    }

    /**
     * @param string $color
     */
    public function setColor($color)
    {
        $this->color = $color;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity( $quantity)
    {
        $this->quantity = $quantity;
    }

    function removeElementWithValue($array, $key, $value){
        foreach($array as $subKey => $subArray){
            if($subArray[$key] == $value){
                unset($array[$subKey]);
            }
        }
        return $array;
    }


}