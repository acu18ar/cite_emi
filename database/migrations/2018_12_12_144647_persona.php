<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Persona extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() 
    {
        Schema::create('Persona', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('Rol')->unsigned()->nullable();
            $table->string('Grado', 150)->nullable();
            $table->string('ApellidoPaterno', 100)->nullable();
            $table->string('ApellidoMaterno', 100)->nullable();
            $table->string('Nombres', 100)->nullable();
            $table->string('Persona', 650)->nullable();
            $table->string('Cargo', 150)->nullable();
            $table->string('Foto', 350)->nullable();
            $table->string('FirmaDigitalizada', 250)->nullable();
            $table->string('CI', 50)->nullable();
            $table->integer('DepDocId')->unsigned()->nullable();
            $table->integer('idSaga')->unsigned()->nullable();
            $table->string('Codigo', 50)->unsigned()->nullable();
            $table->integer('UnidadAcademica')->unsigned()->nullable();
            $table->string('HUnidadAcademica')->nullable();
            $table->integer('Especialidad')->unsigned()->nullable();
            $table->string('HEspecialidad')->nullable();
            $table->string('TipoPersona', 10)->nullable();  
            /** TipoPersona
             *  I => Interno
             *  E => Externo
             *  O => Otro
             */

            /* credenciales de acceso al sistema */
            $table->string('email')->unique()->nullable();
            $table->string('password')->nullable();
            $table->boolean('Activo')->default(false);
            $table->string('TokenLogin')->nullable();
            $table->rememberToken();

            /* campos para login con Office365 */
            $table->datetime('UltimoInicioSesion')->nullable();
            $table->string('SocialLogin', 50)->nullable();
            $table->string('SocialLoginId', 150)->nullable();
            $table->string('Avatar', 250)->nullable();
            
            $table->nullableTimestamps();
            $table->SoftDeletes();
            $table->string('CreatorUserName', 250)->nullable();
            $table->string('CreatorFullUserName', 250)->nullable();
            $table->string('CreatorIP', 250)->nullable();
            $table->string('UpdaterUserName', 250)->nullable();
            $table->string('UpdaterFullUserName', 250)->nullable();
            $table->string('UpdaterIP', 250)->nullable();
            $table->string('DeleterUserName', 250)->nullable();
            $table->string('DeleterFullUserName', 250)->nullable();
            $table->string('DeleterIP', 250)->nullable();

            $table->foreign('Rol')->references('id')->on('Rol');
            $table->foreign('UnidadAcademica')->references('id')->on('UnidadAcademica');
            $table->foreign('DepDocId')->references('id')->on('DepDocId');
            $table->foreign('Especialidad')->references('id')->on('Especialidad');
        });
    }

    public function down()
    {
        Schema::dropIfExists('Persona');
    }
}
