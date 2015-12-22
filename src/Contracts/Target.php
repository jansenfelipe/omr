<?php

namespace JansenFelipe\OMR\Contracts;


abstract class Target
{
    /**
     * Store results if the target was marked
     *
     * @var boolean
     */
    protected $marked = false;

    /**
     * Identifier
     *
     * @var string
     */
    protected $id;

    /**
     * Checks if the target was marked
     *
     * @return boolean
     */
    public function isMarked()
    {
        return $this->marked;
    }

    /**
     * Tells whether the target was marked
     *
     * @param boolean $marked
     */
    public function setMarked($marked)
    {
        $this->marked = $marked;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

}