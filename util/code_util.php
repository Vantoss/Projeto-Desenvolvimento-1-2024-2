<!-- arquivo para guardar codigos possivelmente uteis para o projeto -->
<html>
<body>

<?php
$startdate=strtotime("Saturday");
$enddate=strtotime("+20 weeks", $startdate);

while ($startdate < $enddate) {
  echo date("M d", $startdate) . "<br>";
  $startdate = strtotime("+1 week", $startdate);
}
?>

</body>
</html>

<!-- Displays:  -->
Sep 28
Oct 05
Oct 12
Oct 19
Oct 26
Nov 02
