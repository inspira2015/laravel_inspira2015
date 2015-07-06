<?php
namespace App\Libraries;

interface Validator {
	public function Check();
	public function GetValid( $object );
	public function GetError();
}