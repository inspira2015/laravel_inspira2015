<?php 

namespace App\Model\Dao;

use App\Model\UserAddress;

class UserAddressDao
{
	public function getById($id) 
	{
		return UserAddress::find($id);
	}

	public function getAll() 
	{
		return UserAddress::all();
	}
	
	

}