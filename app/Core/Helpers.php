<?php

namespace Core;

/**
 * This is Description of Helpers class
 *
 */
class Helpers
{
    /*
     * Description:
     *
     * @param mixed $data
     * @param string $type
     *
     * @return int or string
     */
    public static function clean($data, $type = "str")
    {
        switch ($type) {
            case "str":
                return nl2br(htmlspecialchars(stripslashes(trim(strip_tags($data)))));
                break;
            case "int":
                return (int)$data;
            default:
                return nl2br(htmlspecialchars(stripslashes(trim(strip_tags($data)))));
                break;
        }
    }

    /*
    * Description:
    * @param string $path The rel-path to the assets
    * @return string $uri The full uri to the assets
    */
    public static function asset($path = '')
    {
        $uri = BASE_PATH . '/' . BASE_ASSET_PATH . '/' . $path;

        return $uri;
    }

    /*
     * Description:
     *
     * @param string $path
     *
     * @return string $uri
     */
    public static function path($path = '')
    {
        $uri = BASE_PATH . '/' . $path;

        return $uri;
    }

    /**
     * Description:
     *
     * @return array $parseUri
     *
     */
    public static function parseURI()
    {
        $parseUri = [] ;
        if (isset($_GET['uri'])) {
            return $parseUri = explode('/', filter_var(rtrim(self::clean($_GET['uri']), '/'), FILTER_SANITIZE_URL));
        }

        return $parseUri;
    }

    /**
     * Description:
     *
     * @return string $query_string
     *
     */
    public static function getQueryString()
    {
        $queryString = filter_var(rtrim(self::clean($_SERVER['QUERY_STRING']), '/'), FILTER_SANITIZE_URL);
        $queryString = explode('&', $queryString);
        unset($queryString[0]);
        $queryString = implode('&', $queryString);
        $queryString = trim($queryString, 'amp;amp;');

        return $queryString;
    }

    /**
     * Description:
     *
     * @return string $current_uri
     *
     */
    public static function getCurrentURI()
    {
        $parseUri = self::parseURI();
        $currentUri = $parseUri ? implode('/', self::parseURI()) : '';

        return $currentUri;
    }

    /**
     * Description:
     *
     * @param string $path
     *
     * @return boolean $bool
     *
     */
    public static function isCurrentURI($path = '')
    {
        $currentUri = self::getCurrentURI();
        $strPos = ($path != '') ? strpos($currentUri, $path, 0) : -1;
        $bool = ($strPos === 0 || $path == $currentUri);

        return $bool;
    }

    /**
     * Description:
     *
     * @param string $method
     *
     * @return boolean $bool
     *
     */
    public static function isRequestMethod($method = "POST")
    {
        $bool = false;
        if (strtoupper($_SERVER['REQUEST_METHOD']) == strtoupper($method)) {
            $bool = true;
        }

        return $bool;
    }

    /**
     * Description:
     *
     * @return boolean $bool
     *
     */
    public static function isAdminAuth()
    {
        return isset($_SESSION['admin_auth']) && $_SESSION['admin_auth'];
    }

    /**
     * Description:
     *
     * @return boolean
     *
     */
    public static function adminAuth()
    {
        return $_SESSION['admin_auth'] = true;
    }

    /**
     * Description:
     *
     * @return void
     *
     */
    public static function adminLogout()
    {
        unset($_SESSION['admin_auth']);
        //header('Location: ' . Helpers::path('users/table'));
        //exit;
    }

}
