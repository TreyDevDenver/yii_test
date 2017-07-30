<?php

class CheckinForm extends CFormModel
{
	public $phone;

	/**
	 * Declares the validation rules.
	 */
	public function rules()
	{
		return array(
			array('phone', 'required'),
			array('phone', 'length', 'min' => 10, 'max' => 255)
		);
	}
}