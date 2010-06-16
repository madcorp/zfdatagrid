<?php

/**
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license
 * It is  available through the world-wide-web at this URL:
 * http://www.petala-azul.com/bsd.txt
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to geral@petala-azul.com so we can send you a copy immediately.
 *
 * @package    Bvb_Grid
 * @copyright  Copyright (c)  (http://www.petala-azul.com)
 * @license    http://www.petala-azul.com/bsd.txt   New BSD License
 * @version    $Id: Date.php 492 2010-01-26 17:08:02Z pao.fresco $
 */
class Bvb_Grid_Formatter_Array implements Bvb_Grid_Formatter_FormatterInterface
{

    // custom callback function
    protected $_callBack;

    // in form: '{{ucc.chType}}: {{chData}}<br />'
    protected $_template;

    // set of fields that are allowd to be displayed
    protected $_displayFields = array();

    // set of fields that shouln't be displayed
    protected $_hiddenFields = array('id', 'hDateTime', 'userID');


    public function __ ($message)
    {
        static $translator = null;

        if ( $translator ) {
            $message = $translator->translate($message);
        } else {
            if ( Zend_Registry::isRegistered('Zend_Translate') ) {
                $translator = Zend_Registry::get('Zend_Translate');
                $message = $translator->translate($message);
            }
        }
        return $message;
    }


    public function __construct ($options = array())
    {
        foreach ( $options as $key => $data ) {
            switch ($key) {
                case 'template':
                    $this->_template = $data;
                    break;
                case 'hiddenFields':
                    $this->_hiddenFields = $data;
                    break;
                case 'displayFields':
                    $this->_displayFields = $data;
                    break;
                case 'callBack':
                    $this->_callBack = $data;
                    break;
            }
        }
    }


    protected function _shouldDisplay ($fieldName)
    {

        // check if it should be hidden
        // @todo: check for fields names with references. e.g. id, ab.id, ucc.id, etc.
        if ( in_array($fieldName, $this->_hiddenFields) ) {
            return false;
        }

        // check if it should be displayed
        // @todo: check for fields names with references. e.g. id, ab.id, ucc.id, etc.
        if ( count($this->_displayFields) > 0 ) {
            return in_array($fieldName, $this->_displayFields);
        }

        // hide all fields that end in 'id', e.g. userID, partID, etc.
        if ( strtolower(substr($fieldName, - 2)) == 'id' and $fieldName != 'id' ) {
            return false;
        }

        return true;
    }


    public function format ($value, $indent = '' )
    {

        // if callback function specified, return its result
        if ( is_callable($this->_callBack) ) {
            return call_user_func($this->_callBack, $value);
        }

        try {
            // do just for the array
            if ( is_array($value) ) {
                $ret = '';
                foreach ( $value as $field => $data ) {
                    // if template is set, replace fields with data
                    if ( isset($this->_template) ) {
                        $fields = array_map(create_function('$value', 'return "{{{$value}}}";'), array_keys($data));
                        $ret .= str_replace($fields, $data, $this->_template);
                    } else {
                        $ret .= $indent;
                        // if current data is a subarray, format it recursively
                        if ( is_array($data) ) {
                            $ret .= $this->format($data, $indent . '&nbsp;');
                        } else {
                            // display just fields that have a value and are allowed to display
                            if ( $data != '' and $this->_shouldDisplay($field) ) {
                                $ret .= $this->__($field) . ': ' . $data . '<br />';
                            }
                        }
                    }
                }
            } else {
                $ret = $value;
            }
        }
        catch (Exception $e) {
            $ret = $value;
        }
        return $ret;
    }

}