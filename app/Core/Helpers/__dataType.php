<?php

namespace App\Core\Helpers;

use App\Core\Helpers\__static;
use Carbon\Carbon;


class __dataType{




    public static function string_to_boolean($value){

       if($value == 'true'){ return true; }
       elseif($value == 'false'){ return false; }

    }
    





    public static function boolean_to_string($value){

       if($value == true){ return 'true'; }
       elseif($value == false){ return 'false'; }

    }






    public static function date_parse($value, $format = 'Y-m-d'){

        $date = null;

        if($value != null || $value != ''){
          $date = Carbon::parse($value)->format($format);
        }

        return $date;

    }






    public static function time_parse($value, $format = 'H:i:s'){

      $time = null;

      if($value != null || $value != ''){
        $time = date($format, strtotime($value));
      }

      return $time;

    }






    public static function string_to_num($value){

      $num = null;

      if($value != null || $value != ''){
        $num = str_replace(',', '', $value);
      }

      return $num;

    }






    public static function construct_time_HM($hrs, $mins){

        while ($mins >= 60) {
          
          $hrs = $hrs + 1;
          $mins = $mins - 60;

        }    

        return sprintf("%02d", $hrs) .':'. sprintf("%02d", $mins);

    }






}