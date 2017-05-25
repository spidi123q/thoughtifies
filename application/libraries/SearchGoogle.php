<?php

/**
 * Created by PhpStorm.
 * User: suraj
 * Date: 5/25/17
 * Time: 1:14 PM
 */
class SearchGoogle extends Thread
{
    public function __construct($query)
    {
        $this->query = $query;
    }

    public function run()
    {
        $this->html = file_get_contents('http://google.fr?q='.$this->query);
    }
}