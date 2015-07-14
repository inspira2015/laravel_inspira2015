<?php
namespace App\Libraries;
use App\Model\Code as Code;

interface Ivalidate 
{
	public function setCode(Code $code);
	public function checkValid();
	public function getErrors();
}