<?php

/**
 * Description of Uri
 *
 * @author Moussa
 */
class Uri {
    public static function redirect($url, $permanent = false)
    {
        header('Location: ' . $url, true, $permanent ? 301 : 302);

        exit();
    }

}
