<?php

// Database design
use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

require __DIR__ .'/vendor/autoload.php';

$capsule = new Capsule();

$capsule->addConnection([
    'driver'    => 'sqlite',
    'database' => __DIR__ . '/app/database.sqlite',
    'prefix' => '',
]);

/* for MySQL
$capsule->addConnection([
    'driver'    => 'mysql',
    'host'      => 'localhost',
    'database'  => 'database',
    'username'  => 'root',
    'password'  => 'password',
    'charset'   => 'utf8mb4',
    'collation' => 'utf8mb4_unicode_ci',
    'prefix'    => '',
]);
*/

$capsule->setAsGlobal();
$capsule->bootEloquent();

Capsule::schema()->dropAllTables();
Capsule::schema()->create('posts', function (Blueprint $table) {
    $table->increments('id');
    $table->timestamp('created_at')->useCurrent();
    $table->string('title', 200);
    $table->text('content');
    $table->string('thumbnail', 100)->nullable();
    $table->string('tags', 200)->nullable();
});
