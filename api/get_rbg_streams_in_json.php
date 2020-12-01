<?php
include_once 'get_rbg_streams.php';

// Return data in json format
header('Content-Type: application/json');
echo json_encode($STREAMS);
