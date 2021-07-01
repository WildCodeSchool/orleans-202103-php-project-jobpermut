<?php

namespace App\Service;

class FormatDuration
{
    function duration($time)
    {
        $timeTable = array(
            "jours" => 86400,
            "heures" => 3600,
            "minutes" => 60,
        );



        $result = "";


        foreach ($timeTable as $timeUnit => $secondsPerUnit) {

            $$timeUnit = floor($time / $secondsPerUnit);
            $time = $time % $secondsPerUnit;



            if ($$timeUnit > 0 || !empty($result))

                $result .= $$timeUnit . " $timeUnit ";
        }
        return trim($result);
    }
}
