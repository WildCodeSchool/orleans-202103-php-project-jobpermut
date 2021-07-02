<?php

namespace App\Service;

use DateTime;
use DateInterval;

class FormatDuration
{
    const NBSECONDINADAY = 86400;
    const NBSECONDINANHOUR = 3600;
    
    public function duration(int $time): array
    {
        $dateFirst = new DateTime();
        $dateSecond = new DateTime();

        $dateSecond->add(new DateInterval('PT'.$time.'S'));
     
        $duration = $dateSecond->diff($dateFirst);

        $day = '';
        $hour = '';
        switch ($time){
            case $this::NBSECONDINADAY < $time:
                $day = '%a';
            case $this::NBSECONDINANHOUR < $time:
                $hour = '%h';
            default :
                break;
        }

        $duration = $duration->format($day . ',' . $hour . ',' . '%i');

        $durations = explode(',', $duration);
        $result = [
            'days' => $durations[0],
            'hours' => $durations[1],
            'minutes' => $durations[2]
        ];

        return $result;
    }
}
