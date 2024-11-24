<?php

while (true) {
    try {
        // تشغيل الأمر Artisan
        $output = shell_exec('php artisan auction:check-expired 2>&1');

        // تسجيل الإخراج في ملف لتتبع الأخطاء (اختياري)
        file_put_contents('background-loop.log', date('Y-m-d H:i:s') . " - " . $output . PHP_EOL, FILE_APPEND);

        // انتظار لمدة دقيقة واحدة قبل إعادة التشغيل
        sleep(60);
    } catch (Exception $e) {
        // تسجيل أي أخطاء قد تحدث
        file_put_contents('background-loop.log', date('Y-m-d H:i:s') . " - ERROR: " . $e->getMessage() . PHP_EOL, FILE_APPEND);
        sleep(60); // استمر بعد الخطأ
    }
}
