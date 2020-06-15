<?php

class Tyrion extends Lannister {
    public function sleepWith($partner) {
        if (get_parent_class($partner) !== 'Lannister') {
            echo "Let's do this.".PHP_EOL;
        } else {
            echo "Not even if I'm drunk !".PHP_EOL;
        }
    }
}

//EOF