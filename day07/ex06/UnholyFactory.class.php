<?php

class UnholyFactory {
    private $_fighters = array();

    public function absorb($fighter) {
        if ($fighter instanceof Fighter) {
            if (array_key_exists($fighter->getType(), $this->_fighters)) {
                echo "(Factory already absorbed a fighter of type ".$fighter->getType().")".PHP_EOL;
            } else {
                echo "(Factory absorbed a fighter of type ".$fighter->getType().")".PHP_EOL;
                $this->_fighters[$fighter->getType()] = $fighter;
            }
        } else {
            echo "(Factory can't absorb this, it's not a fighter)".PHP_EOL;
        }
    }

    public function fabricate($type) {
        if (array_key_exists($type, $this->_fighters)) {
            echo "(Factory fabricates a fighter of type ".$type.")".PHP_EOL;
            return clone $this->_fighters[$type];
        }
        echo "(Factory hasn't absorbed any fighter of type ".$type.")".PHP_EOL;
        return null;
    }
}

//EOF