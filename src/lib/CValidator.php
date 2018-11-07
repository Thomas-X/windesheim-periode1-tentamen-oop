<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 14/09/18
 * Time: 18:33
 */

namespace Qui\lib;

/*
 * usage:
 * $validator = new \Qui\Validator();

    dd($validator
        ->isLen('addd', 4)
        ->isEmail('t@t.nl')
        ->validate()
    );

 * */

/*
 * the specific methods don't need much explaining, the naming should speak for how the method works, e.g isEmail()
 * */

use Symfony\Component\Validator\Constraints\Valid;

/**
 * Class Validator
 * @package Qui\core
 */
class CValidator
{
    private $validators = [];
    private const EMAIL_REGEX = '/^[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+$/';
    public const OPTIONAL = 'optional';
    public const REQUIRED = 'required';
    public const BOOLEAN = 'boolean';
    public const INTEGER = 'integer';
    public const FLOAT = 'double';
    public const STRING = 'string';
    public const ARRAY = 'array';
    public const OBJECT = 'object';
    public const NULL = 'NULL';

    /**
     * @param $value
     * @param $message
     */
    private function addValidator($value, $message)
    {
        $this->validators[] = [
            'result' => $value,
            'message' => $message
        ];
    }

    /**
     * @param $val
     * @param $type
     * @param array $messages
     * @param bool $isNot
     * @return $this
     */
    private function typeValidator($val, $type, array $messages, $isNot = false)
    {
        $typeMatches = gettype($val) == $type;
        if ($typeMatches && $isNot == false) {
            $this->addValidator(true, $messages['messageTrue']);
        } else {
            if ($isNot && !$typeMatches) {
                $this->addValidator(true, $messages['messageTrue']);
            } else {
                $this->addValidator(false, $messages['messageFalse']);
            }
        }
        return $this;
    }

    /**
     * @param $val
     * @param array $messages
     */
    private function nonTypeValidator($val, array $messages)
    {

        // verbose, but readable
        if ($val == true) {
            $this->addValidator($val, $messages['messageTrue']);
        } else if ($val == false) {
            $this->addValidator($val, $messages['messageFalse']);
        }
    }

    /**
     * @param $field
     * @return array
     */
    private function message($field)
    {
        return [
            'messageTrue' => null,
            'messageFalse' => "Invalid field: {$field}"
        ];
    }

    // Chainable type/regex checkers

    /**
     * @param $string
     * @param string $field
     * @return CValidator
     */
    public function isString($string, $field = 'isString')
    {
        return $this->typeValidator($string, CValidator::STRING, $this->message($field));
    }

    /**
     * @param $int
     * @param string $field
     * @return CValidator
     */
    public function isInt($int, $field = 'isInt')
    {
        return $this->typeValidator($int, CValidator::INTEGER, $this->message($field));
    }

    /**
     * @param $float
     * @param string $field
     * @return CValidator
     */
    public function isFloat($float, $field = 'isFloat')
    {
        return $this->typeValidator($float, CValidator::FLOAT, $this->message($field));
    }

    public function isBool($bool, $field = 'isBool')
    {
        return $this->typeValidator($bool, CValidator::BOOLEAN, $this->message($field));
    }

    public function isArray($array, $field = 'isArray')
    {
        return $this->typeValidator($array, CValidator::ARRAY, $this->message($field));
    }

    /**
     * @param $value
     * @param string $field
     * @return CValidator
     */
    public function isNotNull($value, $field = 'isNotNull')
    {
        return $this->typeValidator($value, CValidator::NULL, $this->message($field), true);
    }

    public function isNull($value, $field = 'isNull')
    {
        return $this->typeValidator($value, CValidator::NULL, $this->message($field));
    }

    /**
     * @param $value
     * @param $len
     * @param string $field
     * @return $this
     */
    public function isLen($value, $len, $field = 'isLen')
    {
        if (gettype($value) == 'string') {
            if (strlen($value) == $len) {
                $this->nonTypeValidator(true, $this->message($field));
            } else {
                $this->nonTypeValidator(false, $this->message($field));
            }
        } else if (gettype($value) == 'array') {
            if (count($value) == $len) {
                $this->nonTypeValidator(true, $this->message($field));
            } else {
                $this->nonTypeValidator(false, $this->message($field));
            }
        } else {
            $this->nonTypeValidator(false, $this->message($field));
        }
        return $this;
    }

    /**
     * @param string $value
     * @param string $field
     * @return $this
     */
    public function isAlphaNumeric(string $value, $field = 'isAlphaNumeric')
    {
        if (ctype_alnum($value)) {
            $this->nonTypeValidator(true, $this->message($field));
        } else {
            $this->nonTypeValidator(false, $this->message($field));
        }
        return $this;
    }

    /**
     * @param $value
     * @param string $field
     * @return $this
     */
    public function isEmail($value, $field = 'isEmail')
    {
        $result = preg_match_all(CValidator::EMAIL_REGEX, $value);
        if ($result == 1) {
            $this->nonTypeValidator(true, $this->message($field));
        } else {
            $this->nonTypeValidator(false, $this->message($field));
        }
        return $this;
    }

    // End of chain

    /**
     * @return array
     */
    public function validate(): array
    {
        $messages = [];
        foreach ($this->validators as $validator) {
            if ($validator['result'] == false) {
                // Reset validators since the same instance is going to be used in the App binding,
                // thus creating conflicts if the validators aren't 'flushed'
                $messages[] = $validator['message'];
            }
        }
        $this->validators = [];
        // if there are no error messages, that means we've passed the validation
        $passed = count($messages) == 0;

        return compact('passed', 'messages');
    }

    // $isValid = Validator::checkMultiple($req->params, ['email' => 'required|string']);

    /*
     * A function for validating fields in an assoc array. Useful for parameter validation
     *
     * usage:
     * $errors = Validator::validateRequest([
            'email' => 'thomas@zwarts.codes',
        ],
            [
                'email' => 'required|string',
                'fname' => 'required|string'
            ]);
*
     *
     * if (count($errors) >= 1) /* do some error handling stuff here?
    */
    public function validateRequest($values, $requirements)
    {
        $errors = [];
            foreach ($requirements as $requirementName => $requirement) {
                if (!isset($values[$requirementName])) {
                    $errors[] = [
                        'field' => $requirementName,
                        'isValid' => false
                    ];
                    continue;
                }
                foreach ($values as $valueKey => $value) {
                    if ($valueKey == $requirementName) {
                    $keypair = explode('|', $requirement);
                    $conditional = $keypair[0];
                    $type = $keypair[1];
                    if ($conditional == CValidator::REQUIRED && gettype($value) != $type) {
                        // if type is invalid, add it to the errors arrays
                        $errors[] = [
                            'field' => $requirementName,
                            'isValid' => false
                        ];
                    }
                }
            }
        }
        return $errors;
    }
}