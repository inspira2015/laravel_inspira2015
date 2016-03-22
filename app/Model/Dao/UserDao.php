<?php 

namespace App\Model\Dao;
use Carbon;
use App\Model\User;
use App\Model\Entity\UserEntity;


class UserDao extends UserEntity implements ICrudOperations 
{


	public function getById($id) 
	{
		return User::find($id);
	}

	public function getAll() 
	{
		return User::all();
	}

	public function delete($id) 
	{
		if ($id) {
			$User = User::find($id);
			$User->delete();
		}
	}
	
	public function save() 
	{
		$id = isset($this->id) ? (int) $this->id : 0;
		$user = User::firstOrNew( array( 'id' => $id ));
		foreach($this as $key =>$value)
		{
			$user->$key = $value;
		}
		$user->save();
		return $user->id;
	}


	public function load( $id )
	{

		$this->populate( $this->getById( $id ) );
	}

	private function populate( $row )
 	{
 		foreach($row->toArray() as $key => $value)
 		{
 			$this->$key = $value;
 		}
 	}

 	public function getByEmail( $email ){
	 	$user = User::where('email', $email)->first();
	 	if( empty($user) ){
		 	return FALSE;
	 	}
	 	return $user;
 	}
 	
 	public function getDetails( $id )
 	{
	 	$user = new \stdClass();
	 	$phones = new \stdClass();
		
		$phones->cell = $this->getPhoneType( $id, 'cellphone');
		$phones->phone = $this->getPhoneType( $id, 'phone');
		$phones->office = $this->getPhoneType( $id, 'office');
		
		$user->details = $this->getById( $id );
		$user->phones = $phones;
		return $user;
 	}

 	
 	public function getPhoneType( $id, $type )
 	{
	 	$phone = $this->getById( $id )->phones->where('type', $type)->first();
	 	return isset($phone['number']) ? $phone['number'] : null;
 	}
 	

	public function getUserPhoneType( $id, $type )
 	{
 		$this->type = $type;
	 	return User::where('id', $id)->whereHas('phones', function($phon)
	 	{
	 		$phon->where('type', $this->type);
	 	})->first();
 	}

 	public function getAddress( $id )
 	{
	 	return $this->getById( $id )->address;
 	}

 	public function getByFacebookId( $fbUser )
 	{
 		$user = User::where( 'facebook_id', $fbUser->id )->first();
 		if ( empty( $user ) )
 		{
 			return FALSE;
 		}
		return $user;
 	}

 	public function getUsersCode( $id )
 	{
 		return User::where( 'id', $id )->with('code_used')->first();

 	}
 	

 	public function getUserByEmailCode( $code = FALSE )
	{
 		$users = User::where( 'confirmation_code', '=', $code )->get();
		if( empty( $users ) )
		{
			return FALSE;
 		}
		return $users;
 	}
 	
 	public function getUserByLeisureId( $leisure_id = FALSE )
	{
 		$users = User::where( 'leisure_id', '=', $leisure_id )->get()->first();
		if( empty( $users ) )
		{
			return FALSE;
 		}
		return $users;
 	}
 	
 	

 	public function getUserByEmail($email)
 	{
 		return  User::where( 'email', '=', $email )->first();
 	}
 	

 	public function getUserAffiliatonPayment()
 	{
 		$now = Carbon::now();
 		$minimumDay = Carbon::now()->subDays(5);
 		return User::has('affiliations')->where( 'billable_day', '>=',$minimumDay->day  )->where( 'billable_day', '<=',$now->day )->where('days_overdue', '<=',5)->get();
 	}


 	public function getUserAffiliatonPaymentTEST()
 	{
 		$now = Carbon::now();
 		$minimumDay = Carbon::now()->subDays(5);     
 		return User::has('affiliations')->where( 'id', '=', 209  )->first();
 	}


 	public function getVacationFundPayment()
 	{
 		return User::whereHas('funds_log', function($funds)
	 	{
	 		$funds->where('amount','>',0 )->where('active',1);
	 	})->get();

 	}

}