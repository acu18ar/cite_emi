stock_emi_ventas
EMI - Starter KIT
Este repositorio contiene la configuración, dependencias y archivos escenciales para comenzar un proyecto nuevo de acuerdo a las Políticas de Estandarización de Desarrollo de la Escuela Militar de Ingeniería

Requisitos

NodeJS y NPM
Apache, PHP 7.2 o superior, Postgres 11.0

Los pasos para realizar el despliegue son:

copiar el archivo .env_inicio  a.env

composer install

npm install

php artisan key:generate

configurar conexión a la base de datos en el archivo .env

configurar parametros especiales del archivo .env (google keys, office365 keys)

Si estas trabajando en ambiente linux otorgar permisos de escritura a las carpetas storate/logs y storage/framework



php artisan migrate --seed

npm install

npm run dev

(opcional para escuchar cambios en archivos JS y SCSS más activación de hot-reload) npm run -watch-poll

php artisan serve
abrir en el navegador http://localhost:8000 usuario: admin@change.me  contraseña: escuela# cite_emi
# cite_emi
