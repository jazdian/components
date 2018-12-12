<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DateIntervalFunc extends DateInterval
{
    /**
     * @param DateInterval $from
     * @return MyDateInterval
     */
    public static function fromDateInterval(DateInterval $from)
    {
        return new MyDateInterval($from->format('P%yY%dDT%hH%iM%sS'));
    }
    public function add(DateInterval $interval)
    {
        foreach (str_split('ymdhis') as $prop) {
            $this->$prop += $interval->$prop;
        }
        $this->i += (int)($this->s / 60);
        $this->s = $this->s % 60;
        $this->h += (int)($this->i / 60);
        $this->i = $this->i % 60;
    }
}