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
 * @version    $Id$
 * @author     Bento Vilas Boas <geral@petala-azul.com >
 */

class Bvb_Grid_Form extends Zend_Form  {

    public $elementDecorators = array(
        'ViewHelper',
        'Errors',
        array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element')),
        array('Label', array('tag' => 'td')),
        array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
    );

    public $buttonDecorators = array(
        'ViewHelper',
        array(array('data' => 'HtmlTag'), array('tag' => 'td', 'class' => 'element','colspan'=>'2')),
        array(array('row' => 'HtmlTag'), array('tag' => 'tr'))
    );


    public function loadDefaultDecorators()
    {
        $this->setDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag' => 'table')),
            'Form',
        ));
    }


	public $options;

	public $fields;

	public $cascadeDelete;

	function __call($name, $args) {
		$this->options [$name] = $args [0];
		return $this;
	}

	function setCallbackBeforeDelete($callback) {

		if (! is_callable ( $callback )) {
			throw new Exception ( $callback . ' not callable' );
		}

        $this->options ['callbackBeforeDelete'] = $callback;

		return $this;
	}

	function setCallbackBeforeUpdate($callback) {

		if (! is_callable ( $callback )) {
			throw new Exception ( $callback . ' not callable' );
		}

		$this->options ['callbackBeforeUpdate'] = $callback;

		return $this;
	}

	function setCallbackBeforeInsert($callback) {

		if (! is_callable ( $callback )) {
			throw new Exception ( $callback . ' not callable' );
		}

		$this->options ['callbackBeforeInsert'] = $callback;

		return $this;
	}

	function setCallbackAfterDelete($callback) {

		if (! is_callable ( $callback )) {
			throw new Exception ( $callback . ' not callable' );
		}

		$this->options ['callbackAfterDelete'] = $callback;

		return $this;
	}

	function setCallbackAfterUpdate($callback) {

		if (! is_callable ( $callback )) {
			throw new Exception ( $callback . ' not callable' );
		}

		$this->options ['callbackAfterUpdate'] = $callback;

		return $this;
	}

	function setCallbackAfterInsert($callback) {

		if (! is_callable ( $callback )) {
			throw new Exception ( $callback . ' not callable' );
		}

		$this->options ['callbackAfterInsert'] = $callback;

		return $this;
	}

	function onDeleteCascade($options) {
		$this->cascadeDelete [] = $options;
		return $this;

	}

	function addColumns() {

		$columns = func_get_args ();

		$final = array ();

		if (is_array ( $columns [0] )) {
			$columns = $columns [0];
		}

		foreach ( $columns as $value ) {
			if ($value instanceof Bvb_Grid_Form_Column) {

			    $value = $value->options;


            $this->addElement('text', $value['field'], array(
            'decorators' => $this->elementDecorators,
            'label'       =>  $value['field'],
            'description'=>'Depois de ti')
        );
				array_push ( $final, $value );
			}
		}

		$this->addElement('submit', 'update', array(
            'decorators' => $this->buttonDecorators,
            'label'       =>  'Save')
        );

		$this->fields = $final;

		return $this;

	}

}