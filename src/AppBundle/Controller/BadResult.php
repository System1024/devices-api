<?php
/**
 * Created by PhpStorm.
 * User: Sergey
 * Date: 16.03.2016
 * Time: 20:07
 */

namespace AppBundle\Controller;


class BadResult
{
    protected $result = ['result' => 'Fail'];

    public function __construct($message = '')
    {
        if (!empty($message)) {
            $this->setMessage($message);
        }
    }

    public function setMessage($message)
    {
        $this->result['message'] = $message;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function __invoke()
    {
        return $this->getResult();
    }

    public function __toString()
    {
        return json_encode($this->getResult());
    }

}