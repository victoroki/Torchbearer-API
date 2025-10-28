<?php
echo "Current directory: " . __DIR__ . "<br>";
echo "Parent directory: " . dirname(__DIR__) . "<br>";
echo "Torchbearer path: " . __DIR__.'/../torchbearer/' . "<br>";
echo "Autoload exists: " . (file_exists(__DIR__.'/../torchbearer/vendor/autoload.php') ? 'YES' : 'NO') . "<br>";
echo "Bootstrap exists: " . (file_exists(__DIR__.'/../torchbearer/bootstrap/app.php') ? 'YES' : 'NO') . "<br>";
?>