<?php

class Main
{
    private $announce;

    public function getAnnounce()
    {
        if (!empty($this->announce)) {
            $pom = $this->announce;
            $this->announce = null;
            return $pom;
        } else {
            return "";
        }
    }

    public function setAnnounce($str)
    {
        $this->announce = $str;
    }

    public function getGold($money)
    {
        $silver = floor($money / 100 % 100);
        $gold = floor($money / 10000);
        $copper = $money % 100;


        return "$gold gold $silver silver $copper copper";
    }


}