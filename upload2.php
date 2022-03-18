<?php

$accepted_origins = array("http://localhost", "http://107.161.82.130");

//pra onde vai as imagens

$imageFolder = "assets/posts/";

reset($_FILES);
$temp = current($_FILES);

session_start();
$_SESSION['pageCount'] = $_SESSION['pageCount']+1;
$count = $_SESSION['pageCount'];
$fotos = array($_FILES);
$_SESSION['fotos'][$count] = $fotos;

if (is_uploaded_file($temp['tmp_name'])) {
    if (isset($_SERVER['HTTP_ORIGIN'])) {
        if (in_array($_SERVER['HTTP_ORIGIN'], $accepted_origins)) {
            header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']);
        } else {
            header('HTTP/1.1 403 Origin Denied');
            return;
        }
    }

    // Sanitize inputi
    if (preg_match("/([^\w\s\d\-_~,;:\[\](\).])|([\.]{2,})/", $temp['name'])) {
        header("HTTP/1.1 400 Invalid file name.");
        return;
    }

    //Verify extension
    if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "png","jpeg"))) {
        header("HTTP/1.1 400 Invalid extension.");
        return;
    }

    //Accept upload if there was no origin, or if it is an accepeted origin
    $id = $_SESSION['id'];
    mkdir('assets/posts/'.$id.'/', 0777, true);
    $imageFolder = 'assets/posts/'.$id.'/';
    $filetowrite = $imageFolder . $temp['name'];
    move_uploaded_file($temp['tmp_name'], $filetowrite);

    //Respond to the successful upload with JSON.
    //Use a location key to specify the path to the saved image resource.
    // { location : '/your/uploaded/image/file}
    echo json_encode(array('location' => $filetowrite));

} else {
    //Notify editor that the upload failed
    header('HTTP/1.1 550 Server Error');
}

?>