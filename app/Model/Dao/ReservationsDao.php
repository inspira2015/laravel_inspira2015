<?php 

namespace App\Model\Dao;

use App\Model\ApiUsersReservations as Reservations;

class ReservationsDao
{
	public function getById($id) 
	{
		return Reservations::find($id);
	}

	public function getAll() 
	{
		return Reservations::all();
	}
	
	public function save() 
	{
		$id = isset($this->id) ? (int) $this->id : 0;
		$reservation = Reservations::firstOrNew( array( 'id' => $id ));
		foreach($this as $key =>$value)
		{
			$reservation->$key = $value;
		}
		$reservation->save();
		return $reservation->id;
	}

}