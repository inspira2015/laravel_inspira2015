<?php

use Illuminate\Database\Seeder;

class AffiliationsSeeder extends Seeder
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
            array( "name_es" => "DESCUBRE", 
                   "name_eng" => "DISCOVER", 
                   "small_desc_es" => "Descubre es nuestra afiliación mas básica,
                    su costo es mínimo y te permite experimentar gran parte de lo que Inspira ofrece",
                    "small_desc_eng" => "Discover is our most basic affiliation program; 
                    it has a minimum cost and it lets you experiment a lot of what Inspira offers",
                    "tier_id" => "81"),

            array( "name_es" => "PLATINO", 
                   "name_eng" => "PLATINUM", 
                   "small_desc_es" => "Platino es nuestro plan de afiliación intermedio. 
                   Con el tendrás una inmensa variedad de beneficios y ahorros para tu vacación",
                    "small_desc_eng" => "Platinum is our intermediate affiliation plan. With it,
                     you´ll enjoy a great amount of vacation benefits and savings",
                    "tier_id" => "82"),

           array( "name_es" => "DIAMANTE", 
                   "name_eng" => "DIAMOND", 
                   "small_desc_es" => "Diamante es nuestra afiliación de mayor categoría. 
                    Con ella obtendrás los máximos ahorros y podrás experimentar paquetes de mayor 
                    prestigio que las afiliaciones anteriores.",
                    "small_desc_eng" => "Diamond is our most prestigious program. 
                    With it you´ll receive maximum savings and will be able to enjoy more luxurious vacation packages.",
                    "tier_id" => "83"),
            
            array( "name_es" => "BRONCE", 
                   "name_eng" => "BRONZE", 
                   "small_desc_es" => "Afliacion Bronce",
                    "small_desc_eng" => "Affiliation BRONZE",
                    "tier_id" => "91"),

            array( "name_es" => "ORO", 
                   "name_eng" => "GOLD", 
                   "small_desc_es" => "Afliacion ORO",
                    "small_desc_eng" => "GOLD Affiliation",
                    "tier_id" => "89"),

            array( "name_es" => "Tarjeta Inspira", 
                   "name_eng" => "Inspira Card", 
                   "small_desc_es" => "Tarjeta Inspira",
                    "small_desc_eng" => "Inspira Card",
                    "tier_id" => "80"),

            array( "name_es" => "Interna", 
                   "name_eng" => "Internal", 
                   "small_desc_es" => "Afiliacion interna",
                    "small_desc_eng" => "Internal affiliation",
                    "tier_id" => "85"),

        );
        
        DB::table('affiliations')->insert($affiliations);
    }
}
