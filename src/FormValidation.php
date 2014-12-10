<?php

namespace DooValidator;



abstract class FormValidation extends Validator{

    protected $validation;
    protected $validator;

    public function __construct()
    {
        $errorHandler    = new ErrorHandler;
        $this->validator = new Validator( $errorHandler );
    }

    public function validator(array $formData)
    {
        $this->validation = $this->validator->check( $formData, $this->validationRules() );

        if( $this->validation->fails() )
        {
            throw new DooFormValidationException('Validation failed', $this->validation->errors() );
        }

        return true;
    }

    public function validationFails()
    {
        return $this->validation->fails();
    }

    public function getErrorFor($field, $order )
    {
        return $this->validation->errors()->$order( $field );
    }

    protected function validationRules()
    {
        return $this->rules;
    }



} 
