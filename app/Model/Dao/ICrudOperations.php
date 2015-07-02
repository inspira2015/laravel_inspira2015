<?php 

namespace App\Model\Dao;


interface ICrudOperations {

	/**
	* The database table Code by the model.
	*
	* @var string
	*/
	public function getAll();

	public function getById($id);
	
	public function save();
	
	public function delete($id);

}