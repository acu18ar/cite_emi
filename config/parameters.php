
<?php

return [
    'org_name' => 'EMI',
    'web_page' => 'www.emi.edu.bo',
    'date_format' => env('DATE_FORMAT', 'Y-m-d H:i:s'),
    'date_format_insert' => env('DATE_FORMAT_INSERT', 'Y-m-d H:i:s'),
    'app_url' => env('APP_URL','http://localhost:8000/'),
    'generated_files' => env('APP_GENERATED_FILES','http://localhost:8000/tmp/'),
    'url_logo' => env('URL_LOGO','http://lcoalhost:8000/images/emi_logo.png'),
    'auth_office365' => env('O365_LOGIN', true),
    'auth_2step' => env('AUTH_2STEP', true),
    'auth_google_recaptcha' => env('GOOGLE_RECAPTCHA', false),
    'storage_path' => env('STORAGE_PATH', storage_path()),
    'public_path' => env('PUBLIC_PATH', public_path()),
    'valid_domains' => env('VALID_DOMAINS', 'gmail.com,yahoo.com,hotmail.com,yahoo.es,outlook.com,adm.emi.edu.bo,doc.emi.edu.bo,est.emi.edu.bo'),
    'gestion_actual' => env('GESTION_ACTUAL', 2020),
    'semestre_actual' => env('SEMESTRE_ACTUAL', 'I')
];