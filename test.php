<?php
date_default_timezone_set('Pacific/Fiji');
echo 'PHP time: ' . date('Y-m-d H:i:s') . '<br>';
echo 'PHP +10 min: ' . date('Y-m-d H:i:s', strtotime('+10 minutes'));
?>