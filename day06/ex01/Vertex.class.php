<?php

class Vertex {
    private         $_x;
    private         $_y;
    private         $_z;
    private         $_w = 1.0;
    private         $_color;
    public static   $verbose = false;

    public function         __construct($init) {
        $this->_x = $init['x'];
        $this->_y = $init['y'];
        $this->_z = $init['z'];

        if (isset($init['w']) && !empty($init['w'])) {
            $this->_w = $init['w'];
        }
        
        if (isset($init['color']) && !empty($init['color']) && $init['color'] instanceof Color) {
            $this->_color = $init['color'];
        } else {
            $this->_color = new Color(array('red' => 255, 'green' => 255, 'blue' => 255));
        }

        if (Self::$verbose) {
            printf("Vertex( x: %.2f, y: %.2f, z:%.2f, w:%.2f, Color( red: %3d, green: %3d, blue: %3d ) ) constructed\n",
                    $this->_x, $this->_y, $this->_z, $this->_w, $this->_color->red, $this->_color->green, $this->_color->blue);
        }
    }

    function                __destruct() {
        if (Self::$verbose) {
            printf("Vertex( x: %.2f, y: %.2f, z:%.2f, w:%.2f, Color( red: %3d, green: %3d, blue: %3d ) ) destructed\n",
                    $this->_x, $this->_y, $this->_z, $this->_w, $this->_color->red, $this->_color->green, $this->_color->blue);
        }
    }

    public function         __toString() {
        if (Self::$verbose) {
            return sprintf("Vertex( x: %.2f, y: %.2f, z:%.2f, w:%.2f, Color( red: %3d, green: %3d, blue: %3d ) )",
                            $this->_x, $this->_y, $this->_z, $this->_w, $this->_color->red, $this->_color->green, $this->_color->blue);
        }
        return sprintf("Vertex( x: %.2f, y: %.2f, z:%.2f, w:%.2f )",
                        $this->_x, $this->_y, $this->_z, $this->_w);
    }

    public static function  doc() {
        if (file_exists("./Vertex.doc.txt")) {
            readfile("./Vertex.doc.txt");
        }
    }

    public function         getX() {
        return ($this->_x);
    }

    public function         setX($x) {
        $this->_x = $x;
    }

    public function         getY() {
        return ($this->_y);
    }

    public function         setY($y) {
        $this->_y = $y;
    }

    public function         getZ() {
        return ($this->_z);
    }

    public function         setZ($z) {
        $this->_z = $z;
    }

    public function         getW() {
        return ($this->_w);
    }

    public function         setW($w) {
        $this->_w = $w;
    }

    public function         getColor() {
        return ($this->_color);
    }

    public function         setColor($color) {
        $this->_color = $color;
    }
}

//EOF