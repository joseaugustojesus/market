<?php

namespace app\support;

use app\core\Request;
use app\traits\Validations;
use Exception;

class Validate
{

    use Validations;
    private $inputsValidation = [];

    private function getParams($validation, $param)
    {
        if (string_contains($validation, ':')) {
            [$validation, $param] = explode(':', $validation);
        }

        return [$validation, $param];
    }


    private function validationExist($validation)
    {
        if (!method_exists($this, $validation)) {
            throw new Exception("A validação {$validation} não existe");
        }
    }


    public function validate(array $validationsFields)
    {

        foreach ($validationsFields as $field => $validation) {
            $havePipes = string_contains($validation, '|');
            if (!$havePipes) {
                $param = '';

                [$validation, $param] = $this->getParams($validation, $param);

                $this->validationExist($validation);

                $this->inputsValidation[$field] = $this->$validation($field, $param);
            } else if ($havePipes) {
                $validations = explode('|', $validation);
                $param = '';
                $this->multipleValidations($validations, $field, $param);
            }
        }

        return $this->returnValidation();
    }

    private function multipleValidations($validations, $field, $param)
    {
        foreach ($validations as $validation) {
            [$validation, $param] = $this->getParams($validation, $param);


            $this->validationExist($validation);

            $this->inputsValidation[$field] = $this->$validation($field, $param);

            if ($this->inputsValidation[$field] === null) {
                break;
            }
        }
    }


    private function returnValidation()
    {
        Csrf::validateToken(Request::input('token'));

        if (in_array(null, $this->inputsValidation, true)) {
            foreach ($this->inputsValidation as $input => $value) {
                if ($value === null) return $input;
            }
        }

        return $this->inputsValidation;
    }



    public function validated($data)
    {
        if(!is_array($data)) setSession('old', Request::excepts(['token']), 1); 
        return is_array($data);
    }

   
}
