<?php
/**
 * Description of Session
 *
 * @author Moussa Thimbo
 */
class Session {

    protected $key, $name, $cookie;

    public function __construct($key, $name = 'MDM_SITE') {
        $this->key = $key;
        $this->name = $name;
        $this->cookie = array(
            'lifetime' => 0,
            'path' => ini_get('session.cookie_path'),
            'domain' => ini_get('session.cookie_domain'),
            'secure' => isset($_SERVER['HTTPS']),
            'httponly' => true);

        $this->setup();
    }

    protected function setup() {
        //ini_set('session.use_cookies', 1);
        //ini_set('session.use_only_cookies', 1);

        session_name($this->name);

        /*session_set_cookie_params(
                $this->cookie['lifetime'], $this->cookie['path'], $this->cookie['domain'], $this->cookie['secure'], $this->cookie['httponly']
        );*/
    }

    public function delete() {
        unset($_SESSION[$this->key]);
    }

    public function get() {
        return isset($_SESSION[$this->key]) ? $_SESSION[$this->key] : null;
    }

    public function set($value) {
        $_SESSION[$this->key] = $value;
    }

    public static function exist($key) {
        return isset($_SESSION[$key]);
    }

    public function start() {
        if (session_id() === '') {
            if (session_start()) {
                return (mt_rand(0, 4) === 0) ? $this->refresh() : true; // 1/5
            }
        }

        return false;
    }

    public function forget() {
        if (session_id() === '') {
            return false;
        }

        $_SESSION = array();

        setcookie(
                $this->name, '', time() - 42000, $this->cookie['path'], $this->cookie['domain'], $this->cookie['secure'], $this->cookie['httponly']
        );

        return session_destroy();
    }

    public function isExpired($ttl = 30) {
        $activity = isset($_SESSION['_last_activity']) ? $_SESSION['_last_activity'] : false;

        if ($activity !== false && time() - $activity > $ttl * 60) {
            return true;
        }

        $_SESSION['_last_activity'] = time();

        return false;
    }

    public function isFingerprint() {
        $hash = md5(
                $_SERVER['HTTP_USER_AGENT']  .
                  (ip2long($_SERVER['REMOTE_ADDR']) & ip2long('255.255.0.0')) // use salt intead 
        );

        if (isset($_SESSION['_fingerprint'])) {
            return $_SESSION['_fingerprint'] === $hash;
        }

        $_SESSION['_fingerprint'] = $hash;

        return true;
    }

    public function isValid($ttl = 30) {
        return !$this->isExpired($ttl) && $this->isFingerprint();
    }

    public function destroy() {
        session_destory();
    }

    public function refresh() {
        session_regenerate_id(true);
    }

    public function save() {
        setcookie(
                $this->name, json_decode($_SESSION[$this->key]), time() - 42000, $this->cookie['path'], $this->cookie['domain'], $this->cookie['secure'], $this->cookie['httponly']
        );
    }

}
