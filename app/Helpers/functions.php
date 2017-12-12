<?php

if (!function_exists('trim_without_array')) {

    /**
     * Trim without value is array
     *
     * @param array $values  Array will be trim
     * @param array $excepts Array except
     *
     * @return string
     */
    function trim_without_array($values, $excepts = [])
    {
        array_walk($values, function (&$value, $key) use ($excepts) {
            if (!is_array($value) && !in_array($key, $excepts)) {
                $value = trim($value);
            }
        });
        return $values;
    }
}

if (!function_exists('currentUserLogin')) {

    /**
     * Get current user login
     *
     * @return \App\Models\CallingUser|App\Models\User
     */
    function currentUserLogin()
    {
        return JWTAuth::parseToken()->authenticate();
    }
}

if (!function_exists('guest')) {

    /**
     * Check current user is guest
     *
     * @return bool
     */
    function guest()
    {
        return JWTAuth::getToken() == false;
    }
}

if (!function_exists('toPgArray')) {

    /**
     * Convert to array postgres
     *
     * @param array $data Data
     *
     * @return bool
     */
    function toPgArray(array $data)
    {
        $result = [];
        foreach ($data as $value) {
            if (is_array($value)) {
                $result[] = toPgArray($value);
            } else {
                $value = str_replace('"', '\\"', $value);
                if (!is_numeric($value)) {
                    $value = '"' . $value . '"';
                }
                $result[] = $value;
            }
        }

        return '{' . implode(",", $result) . '}';
    }
}

if (!function_exists('clientIp')) {
    /**
     * Get current client ip
     *
     * @return ip
     */
    function clientIp()
    {
        foreach (array(
                     'HTTP_CLIENT_IP',
                     'HTTP_X_FORWARDED_FOR',
                     'HTTP_X_FORWARDED',
                     'HTTP_X_CLUSTER_CLIENT_IP',
                     'HTTP_FORWARDED_FOR',
                     'HTTP_FORWARDED',
                     'REMOTE_ADDR') as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    $ip = trim($ip); // just to be safe

                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE
                            | FILTER_FLAG_NO_RES_RANGE) !== false) {
                        return $ip;
                    }
                }
            }
        }
        return '127.0.0.1';//undefine ip
    }
}

if (!function_exists('buildColumnsWithAlias')) {

    /**
     * The code below will do:
     * ['user_id' => 'ID', 'username'] => ['user_id as ID', 'username']
     *
     * @param array $array Array
     *
     * @return string
     */
    function buildColumnsWithAlias(array $array)
    {
        $out = array();
        foreach ($array as $key => $value) {
            $out[] = (is_string($key) ? "$key as " : '') . $value;
        }

        return $out;
    }
}

if (!function_exists('setLocaleSystem')) {

    /**
     * Set locale information
     *
     * @return void
     */
    function setLocaleSystem()
    {
        setlocale(LC_ALL, 'en_US.UTF-8');
    }
}
