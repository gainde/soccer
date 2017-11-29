<?php

/**
 * Description of ArrayUtils
 *
 * @author Moussa Thimbo
 */
class ArrayUtils {
    public static function remove_empty($array) {
        $new_array = array();
        foreach ($array as $value) {
            $value = trim($value);
            if ($value != "") {
                $new_array[] = $value;
            }
        }
        return $new_array;
    }
}
