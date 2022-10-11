<?php

namespace app\core;

use Exception;

class Request
{
    /**
     * This method is responsible for returning a single index of the super global $_POST
     *
     * @param string $name
     * @return string|null
     */
    public static function input(string $name)
    {
        if (isset($_POST[$name])) {
            return $_POST[$name];
        }
        return null;
    }

    public static function setInput(string $key, mixed $value)
    {
        $_POST[$key] = $value;
    }




    /**
     * Method responsible for returning all fields of the request form
     *
     * @return array
     */
    public static function all()
    {
        return $_POST;
    }

    /**
     * This method returns only the fields from the $_POST super global that were requested
     *
     * @param string|array $only
     * @return array
     */
    public static function only($only)
    {
        $fieldsPost = self::all();
        $fieldsPostKeys = array_keys($fieldsPost);

        $fieldsFiltered = [];
        foreach ($fieldsPostKeys as $index => $value) {
            $onlyField = (is_string($only) ? $only : (isset($only[$index]) ? $only[$index] : null));
            if (isset($fieldsPost[$onlyField]))
                $fieldsFiltered[$onlyField] = $fieldsPost[$onlyField];
        }

        return $fieldsFiltered;
    }




    /**
     * This method returns all fields from the $_POST super global except the fields provided.
     *
     * @param string|array $excepts
     * @return array
     */
    public static function excepts($excepts)
    {
        $fieldsPost = self::all();

        if (is_array($excepts)) {
            foreach ($excepts as $index => $value) {
                if (isset($fieldsPost[$value]))
                    unset($fieldsPost[$value]);
            }
        } else if (is_string($excepts)) {
            if (isset($fieldsPost[$excepts]))
                unset($fieldsPost[$excepts]);
        }

        return $fieldsPost;
    }


    /**
     * Method responsible for obtaining a parameter from the URL (Query String);
     *
     * @param string $name
     * @return string
     */
    public static function query(string $name)
    {
        if (!isset($_GET[$name])) {
            return null;
        }
        return $_GET[$name] != '' ? $_GET[$name] : null;
    }


    /**
     * Method responsible for converting an array to JSON
     *
     * @param array $data
     * @return string
     */
    public static function toJson(array $data)
    {
        return json_encode($data);
    }

    /**
     * Method responsible for counting the number of items within the field
     *
     * @param string $input
     * @return int
     */
    public static function countInput(string $input)
    {
        return count($_POST[$input]);
    }


    /**
     * Method responsible for converting a JSON to array
     *
     * @param string $data
     * @return array
     */
    public static function toArray(string $data)
    {
        if (isJson($data)) {
            return json_decode($data);
        }
        throw new Exception("O parâmetro informado não corresponde a um JSON");
    }
}
