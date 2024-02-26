<?php
// helper.php
include 'cabin_mapping.php';

include '../cabin_mapping.php';



function getCabinClassName($classCode) {
    global $classToCabinMap;
    
    return $classToCabinMap[$classCode] ?? 'Unknown Cabin';
}
?>