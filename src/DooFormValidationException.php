<?php

namespace DooValidator;


class DooFormValidationException extends \Exception{

    /**
     * @var
     */
    protected $errors;


    public function __construct( $message, $errors )
    {
        $this->errors = $errors;

        parent::__construct( $message );
    }

    public function getErrorFor()
    {
        return $this->errors;
    }




} 
