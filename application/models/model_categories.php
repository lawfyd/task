<?php

class ModelCategory {
    public static function getAllMainCatsWithChildren() {
        $dblocation = '127.0.0.1';
        $dbname = 'myshop';
        $dbuser = 'root';
        $dbpassword = 1111;

        $db = new PDO("mysql:host=localhost; dbname=$dbname", $dbuser, $dbpassword);

        $cateroriesList = array();

        $results = $db->query('SELECT * FROM categories WHERE parent_id = 0');

        $i = 0;
        while($row = $results->fetch()) {
            $cateroriesList[$i]['name'] = $row['name'];
            $i++;
        }

        return $cateroriesList;


    }
}