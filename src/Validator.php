<?php

namespace Doowebdev;



class Validator {

    protected $items;
    protected $db;
    protected $errorHandler;
    protected $rules = ['required','maxlength','minlength','email', 'alphanumeric', 'match'];

    public $erroMsgs = [
                'required'     => 'The :field field is required',
                'minlength'    => 'The :field field must be a minimum length of :satisfier',
                'maxlength'    => 'The :field field must be a maximum length of :satisfier',
                'email'        => 'This is not a valid email address',
                'alphanumeric' => 'The :field field must contain only letters and numbers',
                'match'        => 'The :field field must match the :satisfier field'
            ];

    public function  __construct(ErrorHandler $errorHandler)
    {
        $this->errorHandler = $errorHandler;
       // $this->db = $db;
    }

    public function check( $items, $rules )
    {
        $this->items = $items;

        foreach( $items as $item => $value )
        {
           if( in_array( $item, array_keys($rules) ) )
           {
                $this->validate([
                    'field'=> $item,
                    'value'=> $value,
                    'rules' => $rules[$item]
                ]);
           }

        }
        return $this;
    }

    public function fails()
    {
        return $this->errorHandler->hasErrors();
    }

    public function errors()
    {
        return $this->errorHandler;
    }

    protected function validate( $item )
    {
        $field = $item['field'];

        foreach( $item['rules'] as $rule => $satisfier )
        {
            if( in_array( $rule, $this->rules ))
            {
                if( ! call_user_func_array( [ $this, $rule ], [ $field, $item['value'], $satisfier ] ) )
                {
                        $this->errorHandler->addError(
                            str_replace([':field',':satisfier'],[$field, $satisfier], $this->erroMsgs[$rule]),
                            $field );
                }
            }
        }

    }

    protected function required( $field, $value, $satisfier )
    {
        $trim_value = trim($value);
        return !empty( $trim_value );
    }

    protected function minlength( $field, $value, $satisfier )
    {
        return mb_strlen( $value ) >= $satisfier;
    }

    protected function maxlength( $field, $value, $satisfier )
    {
        return mb_strlen( $value ) <= $satisfier;
    }

    protected function email( $field, $value, $satisfier )
    {
        return filter_var( $value, FILTER_VALIDATE_EMAIL );
    }

    protected function alphanumeric( $field, $value, $satisfier )
    {
        return ctype_alnum( $value );
    }

    protected function match( $field, $value, $satisfier )
    {
        return $value === $this->items[ $satisfier ];
    }




















} 