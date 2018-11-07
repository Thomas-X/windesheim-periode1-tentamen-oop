<?php
/**
 * Created by PhpStorm.
 * User: thomas
 * Date: 04/10/18
 * Time: 00:09
 */

namespace Qui\lib;


class CNotifierParser
{
    private const PARSE_VAL_DEFAULT = [];
    private const CUR_ID_DEFAULT = null;
    private $parseVal = CNotifierParser::PARSE_VAL_DEFAULT;
    private $curId = CNotifierParser::CUR_ID_DEFAULT;

    public function init()
    {
        $this->parseVal = CNotifierParser::PARSE_VAL_DEFAULT;
        $this->curId = CNotifierParser::CUR_ID_DEFAULT;
        return $this;
    }

    public function newNotification()
    {
        $count = count($this->parseVal);
        $this->curId = $count;
        return $this;
    }

    public function typeAdder(string $type)
    {
        $this->parseVal[$this->curId]['type'] = $type;
        return $this;
    }

    public function success()
    {
        return $this->typeAdder('success');
    }

    public function warning()
    {
        return $this->typeAdder('warning');
    }

    public function error()
    {
        return $this->typeAdder('danger');
    }

    public function info()
    {
        return $this->typeAdder('info');
    }

    public function message(string $message)
    {
        $this->parseVal[$this->curId]['message'] = $message;
        return $this;
    }

    public function make()
    {
        return $this->parseVal;
    }
}