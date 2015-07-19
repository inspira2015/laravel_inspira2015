<?php
//affiliations_description
use Illuminate\Database\Seeder;

class AffiliationsDescriptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    //	DB:table('states')->delete();
        $affiliations = array(
            array( "affiliations_id" => "1", 
                   "description_es" => "Reservaciones en los hoteles mas lujosos de México y el mundo a los precios mas bajos",
                    "description_en" => "Reservations at the lowest price guaranteed, in the most luxurious hotels in Mexico and the world."),

            array( "affiliations_id" => "1", 
                   "description_es" => "Reservaciones en los cruceros mas lujosos de México y el mundo a los precios mas bajos",
                    "description_en" => "Reservations at the lowest price guaranteed, in the best cruises in Mexico and the world."),

            array( "affiliations_id" => "1", 
                   "description_es" => "Tarifas preferenciales en compra de boletos de avión y renta de automoviles",
                    "description_en" => "Preferential rates in airline tickets and car rental."),

            array( "affiliations_id" => "1", 
                   "description_es" => "Sistema de reservación automatizado y disponible las 24 hrs. desde la comodidad de su hogar",
                    "description_en" => "Automated reservations system, available 24/7 from the comfort of your home"),

            array( "affiliations_id" => "1", 
                   "description_es" => "Reservaciones libres de riesgos",
                    "description_en" => "Reservations free of risk."),

            array( "affiliations_id" => "2", 
                   "description_es" => "Reservaciones en los hoteles mas lujosos de México y el mundo a los precios mas bajos",
                    "description_en" => "Reservations at the lowest price guaranteed, in the most luxurious hotels in Mexico and the world."),
            
            array( "affiliations_id" => "2", 
                   "description_es" => "Reservaciones en los cruceros mas lujosos de México y el mundo a los precios mas bajos",
                    "description_en" => "Reservations at the lowest price guaranteed, in the best cruises in Mexico and the world."),

            array( "affiliations_id" => "2", 
                   "description_es" => "Tarifas preferenciales en compra de boletos de avión y renta de automoviles",
                    "description_en" => "Preferential rates in airline tickets and car rental."),

            array( "affiliations_id" => "2", 
                   "description_es" => "Sistema de reservación automatizado y disponible las 24 hrs. desde la comodidad de su hogar",
                    "description_en" => "Automated reservations system, available 24/7 from the comfort of your home"),

            array( "affiliations_id" => "2", 
                   "description_es" => "Reservaciones libres de riesgos",
                    "description_en" => "Reservations free of risk."),

            array( "affiliations_id" => "2", 
                   "description_es" => "Sistema de Puntos Inspira, que le permite ahorrar hasta el 50%, en su próximo viaje",
                    "description_en" => "Inspira points system, it lets you save up to 50% on your next vacation."),

            array( "affiliations_id" => "2", 
                   "description_es" => "Acceso a nuestro sistema de ahorro; Fondo Vacacional, el cual le permite planificar
                                         sus viajes de acuerdo a su presupuesto y ahorrar obteniendo puntos Inspira.",
                    "description_en" => "Access to our Vacation Fund Program, which help you plan your vacation according to 
                                        your budget and save by earningInspira points."),

            array( "affiliations_id" => "3", 
                   "description_es" => "Reservaciones en los hoteles mas lujosos de México y el mundo a los precios mas bajos",
                    "description_en" => "Reservations at the lowest price guaranteed, in the most luxurious hotels in Mexico and the world."),
            
            array( "affiliations_id" => "3", 
                   "description_es" => "Reservaciones en los cruceros mas lujosos de México y el mundo a los precios mas bajos",
                    "description_en" => "Reservations at the lowest price guaranteed, in the best cruises in Mexico and the world."),

            array( "affiliations_id" => "3", 
                   "description_es" => "Tarifas preferenciales en compra de boletos de avión y renta de automoviles",
                    "description_en" => "Preferential rates in airline tickets and car rental."),

            array( "affiliations_id" => "3", 
                   "description_es" => "Sistema de reservación automatizado y disponible las 24 hrs. desde la comodidad de su hogar",
                    "description_en" => "Automated reservations system, available 24/7 from the comfort of your home"),

            array( "affiliations_id" => "3", 
                   "description_es" => "Reservaciones libres de riesgos",
                    "description_en" => "Reservations free of risk."),

            array( "affiliations_id" => "3", 
                   "description_es" => "Sistema de Puntos Inspira, que le permite ahorrar hasta el 50%, en su próximo viaje",
                    "description_en" => "Inspira points system, it lets you save up to 50% on your next vacation."),

            array( "affiliations_id" => "3", 
                   "description_es" => "Acceso a nuestro sistema de ahorro; Fondo Vacacional, el cual le permite planificar
                                         sus viajes de acuerdo a su presupuesto y ahorrar obteniendo puntos Inspira.",
                    "description_en" => "Access to our Vacation Fund Program, which help you plan your vacation according to 
                                        your budget and save by earningInspira points."),

            array( "affiliations_id" => "3", 
                   "description_es" => "Servicio de Concierge o guía de viaje",
                    "description_en" => "Concierge service or travel guide."),
        );
        
        DB::table('affiliations_description')->insert($affiliations);
    }
}
