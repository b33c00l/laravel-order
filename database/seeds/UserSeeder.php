<?php

use Illuminate\Database\Seeder;
use App\User;
use App\Client;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$faker = Faker\Factory::create();
    	
	for ($i=0;$i< 20;$i++) {
		$client = Client ::create( [
			'vat_number'           => 'LT' . $faker -> ean13,
			'registration_number'  => $faker -> isbn13,
			'registration_address' => $faker -> address,
			'shipping_address'      => $faker -> address,
			'email'                => $faker -> email,
			'contact_person'       => $faker -> name,
			'phone'                => $faker -> phoneNumber,
			'payment_terms'       => 15
		] );
		
		User ::create( [
			'name'         => $faker -> company,
			'password'          => 'slaptas',
			'role'              => 'user',
			'client_id'         => $client -> id,
			'price_coefficient' => rand( 0, 50 ),
			'disabled'           => 1
		] );
	}
    }
}
