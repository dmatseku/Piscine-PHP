<?php

abstract class Fighter {
    abstract public function fight($target);
    private $_type;

    public function __construct($type) {
        $this->_type = $type;
    }

    public function getType() {
        return $this->_type;
    }
}

//EOF