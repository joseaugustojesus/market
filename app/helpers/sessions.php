<?php

function setSession(string $key, $value, $override = false)
{

    if (!isset($_SESSION[$key]) or $override) {
        $_SESSION[$key] = $value;
        return $_SESSION[$key];
    }

    return null;
}


function getSession(string $key)
{
    if (isset($_SESSION[$key])) return $_SESSION[$key];
    else return null;
}


function unsetSession(string $key)
{
    if (isset($_SESSION[$key])) unset($_SESSION[$key]);
}


function old(string $key)
{
    if (isset($_SESSION['old']) and isset($_SESSION['old'][$key])) {
        return $_SESSION['old'][$key];
    }
    return null;
}




function isWrong(string $key)
{
    $sessionIsWrong = isset($_SESSION['isWrong']);
    if (!$sessionIsWrong) return null;
    else {
        return isset($_SESSION['isWrong'][$key]);
    }
}


function isWrongText(string $key)
{
    $sessionIsWrong = isset($_SESSION['isWrong']);
    if (!$sessionIsWrong) return null;
    else {
        return isset($_SESSION['isWrong'][$key]) ? $_SESSION['isWrong'][$key] : null;
    }
}



function forgetSessions($sessions = [])
{
    foreach ($sessions as $index => $session) {
        if (isset($_SESSION[$session])) unset($_SESSION[$session]);
    }
}

function applyWrong($key)
{
    if (getSession('isWrong')) {
        $keyWrong = isWrong($key) ? 'is-invalid' : 'is-valid';
        return $keyWrong;
    }
    return null;
}

function applyWrongText($key)
{
    if (getSession('isWrong')) return isWrongText($key);
    return null;
}

function hasOld()
{
    return getSession('old');
}

function applyOldCheck($key)
{
    $isChecked = '';
    if (hasOld()) $isChecked = old($key) ? 'checked' : '';
    else $isChecked = 'checked';
    return $isChecked;
}


function applyOldSelectSimple($value, $key)
{
    if (!hasOld()) return null;
    else return ($value === old($key)) ? 'selected' : '';
}

function applyOldInput($key)
{
    if (hasOld()) return old($key);
    else return null;
}
