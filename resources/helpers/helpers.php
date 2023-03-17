<?php

    use Illuminate\Support\Str;

    use App\Extensions\MongoSessionHandler;
    use Illuminate\Support\Facades\Session;
    use Illuminate\Support\ServiceProvider;

    use Carbon\Carbon;

    use Illuminate\Support\Facades\Log;



    /**
     *genère un code qui peux être utilisé comme matricule
     */
    function code($longueur)
    {
        /**$longueur represente la taille du matricule souhaité */
        $alphabet ="1234567890";
        $converted = Str::substr(date('Y'), -2, 2).'-'.Str::substr(str_shuffle(str_repeat($alphabet, $longueur)), 0, $longueur);
        return $converted;
    }


    /**les dates */
    function dates(){
        $date = Carbon::now()->timezone('Africa/Lubumbashi')->format('Y-m-d H:i:s');
        return  $date;
    }

    /**ajouter des jours a une date */
    function addjourdates($date,$jour){
        $dateinfo = Carbon::createFromFormat('Y-m-d H:i:s', $date);
        $date = $dateinfo->addDays($jour);
        return  $date;
    }

    /**l"age d'une personne */
    function age($datenaissance){

        $datejour = Carbon::now()->format('Y-m-d');

        $now   = strtotime($datejour);
        $date2 = strtotime($datenaissance);

        $diff = abs($now - $date2); // abs pour avoir la valeur absolute, ainsi éviter d'avoir une différence négative

        $years  = floor($diff / (365 * 60 * 60 * 24));
        $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days   = floor(($diff  - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));

        $retour = $years. 'an(s) '.$months.' mois '.$days.' jour(s)';

        /*$months = floor(($dateDifference - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
        $days   = floor(($dateDifference - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 *24) / (60 * 60 * 24));
        $years = floor($diff / (365*60*60*24));*/

        return $retour;
    }

    /**traduit les dates en francais */
    function translatedates($date){
        Carbon::setLocale(config('app.locale'));
        return Carbon::parse($date)->translatedFormat('d F Y à H\hi');
    }


    /**enregistrement des logs */
    function loggers($status,$message, $arrayvalue = null){
        if($status =="debug"){
            Log::debug($message, $arrayvalue);
        }
        if($status =="info"){
            Log::info($message);
        }
        if($status =="notice"){
            Log::notice($message, $arrayvalue);
        }
        if($status =="warning"){
            Log::warning($message, $arrayvalue);
        }
        if($status =="error"){
            Log::error($message, $arrayvalue);
        }
        if($status =="critical"){
            Log::critical($message, $arrayvalue);
        }
        if($status =="alert"){
            Log::alert($message, $arrayvalue);
        }
        if($status =="emergency"){
            Log::emergency($message, $arrayvalue);
        }

    }









