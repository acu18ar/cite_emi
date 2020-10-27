<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Carbon\Carbon;
use App\Models\Log;

class Persona extends Authenticatable
{
    use Notifiable;

    protected $table = 'Persona';
    protected $fillable = ['Nombres','ApellidoPaterno','ApellidoMaterno','Persona','email',
    'password','Rol','Grado','UnidadAcademica','HUnidadAcademica','TipoPersona','Activo','CI', 'Foto', 'CreatorUserName',
     'CreatorFullUserName', 'UpdaterIP', 'Cargo'];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['URLFoto', 'URLFirma'];

    public function unidadAcademica() {
        return $this->belongsTo(UnidadAcademica::class, 'UnidadAcademica');
    }

    public function especialidad() {
        return $this->belongsTo(Especialidad::class, 'Especialidad');
    }

    public function depDocId() {
        return $this->belongsTo(DepDocId::class, 'DepDocId');
    }
    
    public function rol() {
        return $this->belongsTo(Rol::class, 'Rol');
    }

    public function getURLFotoAttribute() {
        if($this->Foto) {
            return url('/') . '/storage/imagenes/' . $this->Foto;
        } else {
            return url('/') . '/images/default_image_profile.png';
        }
    }

    public function getURLFirmaAttribute() {
        if($this->FirmaDigitalizada) {
            return url('/') . '/storage/signatures/' . $this->FirmaDigitalizada; 
        } else {
            return url('/') . '/images/logo-3.png';
        }
    }

    public function syncSagaAlumnos() {
        //crea tabla temporal en DB local postgres
        $tableName = 'tmp_'.md5(Carbon::now());
            
        $sql = 'create table '. $tableName .' (  
            "idAlumno" integer,
            "CodAlumno" varchar(20),
            "ApPaterno" varchar(550),
            "ApMaterno" varchar(550),
            "Nombre" varchar(550),
            "Alumno" varchar(550),
            "email_emi" varchar(250),
            "CI" varchar(150),
            "idGrado" integer,
            "Grado" varchar(100),
            "Sexo" varchar(100),
            "idRol" integer,
            "idUsuario" integer,
            "idUnidadAcademica" integer,
            "IdDepto" integer,
            "Existe" boolean)';
            
        $data = \DB::update($sql);

        //obtiene registros de SAGA
        $sql = 'select a.idAlumno,a.CodAlumno,a.email_emi,a.Alumno,a.ApPaterno,a.ApMaterno,a.Nombre,a.CI,a.idGrado, g.Grado, a.Sexo, a.idUnidadAcademica,a.IdDepto
                from Alumnos a
                left join Grados g on a.idGrado = g.idGrado
                where a.idAlumno in (
                    select distinct idAlumno 
                    from view_cursos_alumnos 
                    where Gestion = :gestion and PeriodoGestion = :periodoGestion and Periodo = 10
                )';
        //dd($sql);
        $params = array(
            ':gestion' => config('parameters.gestion_actual'),
            ':periodoGestion' => config('parameters.semestre_actual')
        );
        
        $data = \DB::connection('saga')->select($sql, $params);
        $data= json_decode( json_encode($data), true);
        $insert_data = collect($data);
        $chunks = $insert_data->chunk(500);
        foreach ($chunks as $chunk) {
            \DB::table($tableName)->insert($chunk->toArray());
            //\DB::table('items_details')->insert($chunk->toArray());
        }
        //encuenta el id 
        $sql = 'update ' . $tableName . '
            set "idUsuario" = "Persona".id
            from "Persona"
            where "Persona"."idSaga" = ' . $tableName . '."idAlumno"';
        \DB::update($sql);

        //encuenta emaild duplicados
        $sql = 'update ' . $tableName . '
            set email_emi = "CI"
            where email_emi in (select email_emi from ' . $tableName . ' group by email_emi having count(*)>1)';
        \DB::update($sql);
        
        //encuenta CI duplicados
        $sql = 'update ' . $tableName . '
            set email_emi = concat(email_emi,\'_\',"idAlumno")
            where email_emi in (select email_emi from ' . $tableName . ' group by email_emi having count(*)>1)';
        \DB::update($sql);

        //inserta en la tabla Usuario
        $sql = 'insert into "Persona" ("idSaga", "Rol", "ApellidoPaterno", "ApellidoMaterno", "Nombres",
                                        "CI",email,password,"Persona","Activo","Codigo","Grado", "UnidadAcademica", "Cargo", "TipoPersona","DepDocId")
                select z."idAlumno", 5, z."ApPaterno", z."ApMaterno", z."Nombre", 
                z."CI", z.email_emi, z."CI", concat(z."Nombre",\' \',z."ApPaterno",\' \' ,z."ApMaterno"), true, z."CodAlumno", z."Grado", ua.id, \'ESTUDIANTE\',\'I\',z."IdDepto"
                from ' . $tableName . ' z 
                left join "UnidadAcademica" as ua on z."idUnidadAcademica" = ua."idSaga"
                where z."idUsuario" is null';
                
        \DB::update($sql);
        //elimina tabla temporal
        $sql = "drop table " . $tableName;
        \DB::update($sql);
        return true;
    }


    public function imprimir() {
        $item = $this;
        $basePathJRXML = storage_path('jrxml/');
        $basePathGenerated = public_path('tmp/');

        $fileName = md5($item->id . Carbon::now());
        $basePathJasper = $basePathJRXML . '/ActaIndividual.jasper';
        $basePathGenerated = $basePathGenerated . $fileName;

        if(\Storage::exists($basePathGenerated))
            \Storage::delete($basePathGenerated);

        $parametros = array (
            'idPersonaDefensa' => $item->id,
            'urlLogo' => public_path('images/emi_logo.png')
        );
        
        $database = \Config::get('database.connections.pgsql');
        $database['driver'] = 'postgres';

        $reporteJasper = \JasperPHP::process(
            $basePathJasper,
            $basePathGenerated,
            array("pdf"),
            $parametros,
            $database
        );
        //dd($reporteJasper->output());
        $reporteJasper->execute();
        
        return array(
            'url' => config('parameters.app_url'). 'tmp/' . $fileName . '.pdf',
            'uri' => public_path(). '/tmp/' . $fileName . '.pdf'
        );
    }
    

}







