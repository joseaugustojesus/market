<?php

namespace app\traits;

use app\core\Request;
use app\support\Flash;

trait Validations
{

    public function unique(string $field, $class)
    {
        $data = Request::input($field);
        $model = new $class;
        $registerFound = $model->findBy($field, $data);
        if ($registerFound) {
            if (LANG === 'en') $message = "The value {$data} is already registered";
            else if (LANG === 'pt-br') $message = "O valor {$data} já está registrado";
            Flash::set($field, $message);
            return null;
        }

        return strip_tags($data);
    }

    public function email(string $field)
    {
        if (!filter_input(INPUT_POST, $field, FILTER_VALIDATE_EMAIL)) {
            if (LANG === 'en') $message = "The email provided is not valid";
            else if (LANG === 'pt-br') $message = "O e-mail fornecido não é válido";
            Flash::set($field, $message);
            return null;
        }

        return strip_tags(Request::input($field), '<p>');
    }

    public function maxLen(string $field, int $length)
    {
        $data = Request::input($field);
        if (strlen($data) > $length) {
            if (LANG === 'en') $message = "Field limit is {$length} characters";
            else if (LANG === 'pt-br') $message = "O limite do campo é de {$length} caracteres";
            Flash::set($field, $message);
            return null;
        }

        return strip_tags($data, '<p>');
    }

    public function required(string $field)
    {
        $data = Request::input($field);
        if (empty($data)) {
            if ($data !== '0') {
                if (LANG === 'en') $message = "The field is required";
                else if (LANG === 'pt-br') $message = "O campo é obrigatório";
                Flash::set($field, $message);
                return null;
            }
        }

        if (is_array($data)) return $data;
        else return strip_tags($data, '<p><b><ul><span><em>');
    }


    public function number(string $field)
    {
        $data = Request::input($field);
        if (empty($data)) {
            if (LANG === 'en') $message = "The field must be a number";
            else if (LANG === 'pt-br') $message = "O campo precisa ser um número";
            Flash::set($field, $message);
            return null;
        }

        return str_replace(['.', ','], ['', '.'], $data);
        // if (is_array($data)) return $data;
        // else return strip_tags($data, '<p><b><ul><span><em>');
    }


    public function withoutValidation(string $field)
    {
        return Request::input($field);
    }
}
