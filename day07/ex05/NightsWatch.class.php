<?php

class NightsWatch implements IFighter {
    private $fighters = array();

    public function recruit($fighter) {
        if ($fighter instanceof IFighter) {
            array_push($this->fighters, $fighter);
        }
    }

    public function fight() {
        foreach ($this->fighters as $fighter) {
            $fighter->fight();
        }
    }
}

//EOF