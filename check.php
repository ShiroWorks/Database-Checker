<?php

$db = new PDO('mysql:host=127.0.0.1;dbname=form_database_exists_checker', 'root','');

if(isset($_GET['type'], $_GET['value'])){

    $type = strtolower(trim($_GET['type']));
    $value = $_GET['value'];

    $output = ['exists' => false];

    if(in_array($type, ['username', 'email'])){
        switch($type){
            case 'username':
            $check = $db->prepare("SELECT COUNT(*) AS count
            FROM users
            WHERE username = :value         
            ");
            break;
            case 'email':
            $check = $db->prepare("SELECT COUNT(*) AS count
            FROM users
            WHERE email = :value         
            ");
            break;
        }
        $check->execute(['value' => $value]);

       // print_r($check->fetchObject());

        $output['exists'] = $check->fetchObject()->count ? true : false;
        echo json_encode($output);

    }

}