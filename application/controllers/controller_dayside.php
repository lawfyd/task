<?php

class Controller_Dayside extends Controller
{

    public function action_index()
    {
        

        require_once(ROOT . '/dayside-master/index.php');

        return true;

    }

}