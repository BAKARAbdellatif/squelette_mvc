<?php

class Session
{
    public function __construct()
    {
        session_start();
    }

    public function getParameter($param)
    {
        return isset($_SESSION[$param]) ? $_SESSION[$param] : null;
    }

    public function setParameter($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public function destroy()
    {
        session_destroy();
    }

    public function unsetParameter($key)
    {
        unset($_SESSION[$key]);
    }

    public function has($param)
    {
        return isset($_SESSION[$param]) ? true : false;
    }
}
