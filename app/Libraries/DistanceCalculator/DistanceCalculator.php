<?php
namespace App\Libraries\DistanceCalculator;
class DistanceCalculator{
    public static $cash_per_distance = 2;
    public static function GreatCircleDistance($center_lat, $center_lng, $lat, $lng)
    {

        $distance =( 6371 * acos((cos(deg2rad($center_lat))) * (cos(deg2rad($lat))) * (cos(deg2rad($lng) - deg2rad($center_lng)) )+ ((sin(deg2rad($center_lat))) * (sin(deg2rad($lat))))) );
        return round($distance ,PHP_ROUND_HALF_DOWN);
    }
    public static function calculateFair($distance_in_km){
        return static::$cash_per_distance * $distance_in_km;
    }


}
