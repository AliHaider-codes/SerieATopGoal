<?php
$baseurl =  'https://saw21.dibris.unige.it/~S4811831/Siti';
session_start();
session_destroy();
header("Location: $baseurl/index.php");
exit;
?>