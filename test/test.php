<?php
$str = "'2024-03-04', '2024-03-06', '2024-03-08', '2024-03-10'";
$arr = explode(",",$str);

$i = sizeof($arr);

foreach ($arr as $key =>  $val) {
    if($key == ($i-1))
    {echo " e ";}
    echo $val;
    
}

?>