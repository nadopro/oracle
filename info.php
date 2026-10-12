<?php

    echo extension_loaded('oci8')
    ? 'OCI8 활성화됨'
    : 'OCI8 활성화 안 됨';

echo '<pre>';

echo 'PHP Version: ' . PHP_VERSION . PHP_EOL;
echo 'PHP SAPI: ' . PHP_SAPI . PHP_EOL;
echo 'php.ini: ' . php_ini_loaded_file() . PHP_EOL;
echo 'extension_dir: ' . ini_get('extension_dir') . PHP_EOL;
echo 'OCI8: ' . (extension_loaded('oci8') ? '활성화' : '비활성화') . PHP_EOL;
echo 'PATH: ' . getenv('PATH') . PHP_EOL;

echo '</pre>';
    phpinfo();
?>