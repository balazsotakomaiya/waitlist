<?php

namespace App\Utils;

class MoveElement {
    public static function moveElement(&$array, $a, $b) {
        $out = array_splice($array, $a, 1);
        array_splice($array, $b, 0, $out);
    }
}
