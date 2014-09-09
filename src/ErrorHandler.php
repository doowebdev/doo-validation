<?php

namespace Doowebdev;


class ErrorHandler {

    protected $errors = [];

    public function addError( $error, $key = null )
    {
        if( $key )
        {
            $this->errors[$key][] = $error;
        }
        else
        {
            $this->errors[] = $error;
        }
    }

    public function all( $key = null )
    {
        return isset( $this->errors[$key] ) ? $this->errors[$key] : $this->errors;
    }

    public function hasErrors()
    {
        return count( $this->all() ) ? true : false ;
    }

    public function first( $key )
    {
        return isset( $this->all()[$key][0] ) ? $this->all()[$key][0] : '';
    }

    public function second( $key )
    {
        return isset( $this->all()[$key][1] ) ? $this->all()[$key][1] : '';
    }

    public function third( $key )
    {
        return isset( $this->all()[$key][2] ) ? $this->all()[$key][2] : '';
    }

    public function fourth( $key )
    {
        return isset( $this->all()[$key][3] ) ? $this->all()[$key][3] : '';
    }



} 