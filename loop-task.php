<?php
while (true) {
    echo shell_exec('php artisan auction:check-expired');
    sleep(60);
}
