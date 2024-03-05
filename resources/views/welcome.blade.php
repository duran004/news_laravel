<?php
echo function_exists('opcache_get_status') && opcache_get_status() && opcache_get_status()['jit']['enabled'] ? 'JIT enabled' : 'JIT disabled';
phpinfo();
