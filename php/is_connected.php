<?php
/**
 * Created by PhpStorm.
 * User: grego
 * Date: 27/02/2019
 * Time: 08:42
 */

session_start();
require_once('bd.php');

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

$_SESSION['postits'] = array();
$postits = [];

include 'postit_handler.php';

if(isset($_SESSION['username'])) {
    echo json_encode($_SESSION['postits']);
}
else {
    echo json_encode(false);
}