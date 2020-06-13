<?php

class Color {
    public          $red;
    public          $green;
    public          $blue;
    public static   $verbose = false;

    public function         __construct($color) {
        if (isset($color['red']) && isset($color['green']) && isset($color['blue'])) {
            $this->red = intval($color['red']);
            $this->green = intval($color['green']);
            $this->blue = intval($color['blue']);
        } elseif (isset($color['rgb'])) {
            $rgb = intval($color['rgb']);
            $this->red = ($rgb & (0xFF << 16)) >> 16;
            $this->green = ($rgb & (0xFF << 8)) >> 8;
            $this->blue = $rgb & 0xFF;
        }
        if (Self::$verbose) {
            printf("Color( red: %3d, green: %3d, blue: %3d ) constructed.\n", $this->red, $this->green, $this->blue);
        }
    }

    function                __destruct() {
        if (Self::$verbose) {
            printf("Color( red: %3d, green: %3d, blue: %3d ) destructed.\n", $this->red, $this->green, $this->blue);
        }
    }
    
    public function         __toString() {
        return sprintf("Color( red: %3d, green: %3d, blue: %3d )", $this->red, $this->green, $this->blue);
    }

    public function add($arg) {
        if ($arg instanceof Color) {
            return new Color(array(
                'red' => $this->red + $arg->red,
                'green' => $this->green + $arg->green,
                'blue' => $this->blue + $arg->blue
            ));
        }
        return new Color(array(
            'red' => $this->red + $arg,
            'green' => $this->green + $arg,
            'blue' => $this->blue + $arg
        ));
    }

    public function         sub($arg) {
        if ($arg instanceof Color) {
            return new Color(array(
                'red' => $this->red - $arg->red,
                'green' => $this->green - $arg->green,
                'blue' => $this->blue - $arg->blue
            ));
        }
        return new Color(array(
            'red' => $this->red - $arg,
            'green' => $this->green - $arg,
            'blue' => $this->blue - $arg
        ));
    }

    public function         mult($arg) {
        if ($arg instanceof Color) {
            return new Color(array(
                'red' => $this->red * $arg->red,
                'green' => $this->green * $arg->green,
                'blue' => $this->blue * $arg->blue
            ));
        }
        return new Color(array(
            'red' => $this->red * $arg,
            'green' => $this->green * $arg,
            'blue' => $this->blue * $arg
        ));
    }

    public static function  doc() {
        if (file_exists("./Color.doc.txt")) {
            readfile("./Color.doc.txt");
        }
    }
}

//EOF