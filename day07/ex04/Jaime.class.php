<?php

class Jaime extends Lannister {
    public function sleepWith($partner) {
        if (get_parent_class($partner) !== "Lannister") {
            echo "Let's do this.".PHP_EOL;
        } elseif (get_class($partner) === "Cersei") {
            echo "With pleasure, but only in a tower in Winterfell, then.".PHP_EOL;
        } else {
            echo "Not even if I'm drunk !".PHP_EOL;
        }
    }
}

//EOF