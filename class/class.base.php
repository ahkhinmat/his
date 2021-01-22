<?php

class Base {

    protected $settable = true; 
    protected $gettable = true; 
    protected $data = array();
    protected $protected_fields  = array(); 
    private $changed_fields  = array();
    
  
    public function set($name, $value) {
      
        if ($this->settable && !in_array($name, $this->protected_fields))
            $this->_set($name, $value);
    }
    

    public function save() {
        $this->changed_fields = array();
    }
    
    private function _set($name, $value){
        if (array_key_exists($name, $this->data)) {
            if (!array_key_exists($name, $this->changed_fields))
                $this->changed_fields[$name] = $this->data[$name];
            
            $this->data[$name] = $value;
        }
    }
    

    protected function _setFields($fields) {
        if (!is_array($fields))
            trigger_error(__FUNCTION__ . ' expects the first parameter to be a array, '
                    . gettype($fields) . ' received.', E_USER_WARNING);
        
        foreach ($fields as $name => $value) {
            $this->_set($name, $value);
        }
    }
    
    public function setFields($fields) {
        if (!is_array($fields))
            trigger_error(__FUNCTION__ . ' expects the first parameter is an array, '
                    . gettype($fields) . ' received.', E_USER_WARNING);
        
        foreach ($fields as $name => $value) {
            $this->set($name, $value);
        }
    }
    

    public function getModified($save = true) {
        $data = array();
        
        foreach ($this->data as $field => $value) {
            if (array_key_exists($field, $this->changed_fields)) {
                $data[$field] = $value;
            }
        }
        
        if ($save)
            $this->save();
        
        return $data;
    }
    
    public function getFields() {
        return array_keys($this->data);
    }


    public function __set($name, $value) {
        $this->set($name, $value);
    }

 
    public function __get($name) {
        if ($this->gettable) {
            if (array_key_exists($name, $this->data)) {
                return $this->data[$name];
            } else {
                return false;
            }
        }
    }


    public function __isset($name) {
        if ($this->gettable) {
            return array_key_exists($name, $this->data) && $this->data[$name] !== '';
        }
    }


    public function __unset($name) {
        if ($this->settable && !in_array($name, $this->protected_fields)) {

            if (array_key_exists($name, $this->data)) {
                $antigo = "";
                if (array_key_exists($name, $this->changed_fields)) {
                    $antigo = $this->changed_fields[$name];
                    unset($this->changed_fields[$name]);
                }

                $this->data[$name] = $antigo;
            }
        }
    }
}