<?php

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Model::unguard();

  //      		Model::unguard();
        		//insertamos los usuarios
        		$this->call('UserTableSeeder');
            $this->command->info('User table seeded');
            $this->call('EstatusesTableSeeder');
            $this->command->info('statuses table seeded');
            $this->call('LogicasTableSeeder');
            $this->command->info('logicas table seeded');
            $this->call('FrecuenciasTableSeeder');
            $this->command->info('frecuencias table seeded');
            $this->call('TipoProcesosTableSeeder');
            $this->command->info('TipoProcesosTableSeeder table seeded');
            $this->call('TipoObjetivosTableSeeder');
            $this->command->info('tipoobjetivos table seeded');
            $this->call('UnidadesTableSeeder');
            $this->command->info('unidades table seeded');
            $this->call('objetivosTableSeeder');
            $this->command->info('objetivos table seeded');
            $this->call('TypedocumentsTableSeeder');
            $this->command->info('typedocuments table seeded');
            $this->call('TiporiesgosTableSeeder');
            $this->command->info('Tiporiesgos table seeded');
            $this->call('EtapasserTableSeeder');
            $this->command->info('Etapas table seeded');
            $this->call('companiat');
            $this->command->info('empresa table seeded');


        //Model::reguard();
    }
}

class EtapasserTableSeeder extends Seeder {
  public function run()
  {
    db::table('etapas')->insert(array(
             'nombre' => 'flujo de valor'
           ));

    db::table('etapas')->insert(array(
            'nombre' => 'Desperdicios y Restricciones'
           ));
    db::table('etapas')->insert(array(
           'nombre' => 'EVENTOS Y KAIZEN'
            ));

            db::table('etapas')->insert(array(
                   'nombre' => 'Control de Mejoras'
                    ));

                    db::table('etapas')->insert(array(
                           'nombre' => 'DEFINIR'
                            ));
                            db::table('etapas')->insert(array(
                                   'nombre' => 'MEDIR'
                                    ));
                                    db::table('etapas')->insert(array(
                                           'nombre' => 'ANALIZAR'
                                            ));
                                            db::table('etapas')->insert(array(
                                                   'nombre' => 'MEJORAR'
                                                    ));
                                                    db::table('etapas')->insert(array(
                                                           'nombre' => 'CONTROLAR'
                                                            ));
                                                            db::table('etapas')->insert(array(
                                                                   'nombre' => 'MODELAR PROCESO'
                                                                    ));
                                                                    db::table('etapas')->insert(array(
                                                                           'nombre' => 'ANALIZAR PROCESO'
                                                                            ));
                                                                            db::table('etapas')->insert(array(
                                                                                   'nombre' => 'REDISEÑAR PROCESO'
                                                                                    ));
                                                                                    db::table('etapas')->insert(array(
                                                                                           'nombre' => 'IMPLEMENTAR PROCESO'
                                                                                            ));
                                                                                            db::table('etapas')->insert(array(
                                                                                                   'nombre' => 'MONITOREO DE PROCESO'
                                                                                                    ));
                                                                                                  }
}
    class UserTableSeeder extends Seeder {

        public function run()
        {
          db::table('Users')->insert(array(
                   'id_compania' => 1,
                   'usuario'     => 'isobpm@isobpm.com',
                   'password'    =>  Hash::make('isobpm'),
                   'nombre'      =>  'isobpm',
                   'perfil'      =>  1,
                   'email'       =>  'isobpm@isobpm.com',
                   'status'      =>  3,
                   'id_area'        =>  1,
                   'empresa'     =>  1
                 ));

         db::table('Users')->insert(array(
                  'id_compania' => 1,
                  'usuario'     => 'jchavezr@isobpm.com',
                  'password'    =>  Hash::make('jchavezr'),
                  'nombre'      =>  'jchavezr',
                  'perfil'      =>  4,
                  'email'       =>  'jchavezr@isobpm.com'
                ));

            db::table('Users')->insert(array(
                     'id_compania' => 1,
                     'usuario'     => 'otrousuario@isobpm.com',
                     'password'    =>  Hash::make('otrousuario'),
                     'nombre'      =>  'otrousuario',
                     'perfil'      =>  4,
                     'email'       =>  'otrousuario@isobpm.com'
                   ));

                   db::table('Users')->insert(array(
                            'id_compania' => 1,
                            'usuario'     => 'useradmin@isobpm.com',
                            'password'    =>  Hash::make('useradmin'),
                            'nombre'      =>  'useradmin',
                            'perfil'      =>  3,
                            'email'       =>  'useradmin@isobpm.com'
                          ));

        }
     }

     class companiat extends Seeder {

         public function run()
         {
           db::table('empresas')->insert(array(
                    'id_plan' => 1,
                    'razonSocial' => 'Prueba company',
                    'status_id' => 1,

                  ));


         }


}


        class EstatusesTableSeeder extends Seeder {

            public function run()
            {
              db::table('estatuses')->insert(array(
                       'nombre' => 'Abierto'
                     ));
              db::table('estatuses')->insert(array(
                       'nombre' => 'Pendiente'
                     ));
              db::table('estatuses')->insert(array(
                         'nombre' => 'Cerrado'
                      ));
              db::table('estatuses')->insert(array(
                         'nombre' => 'Atrasado'
                      ));

            }


}

class TiporiesgosTableSeeder extends Seeder {

    public function run()
    {
      db::table('tiporiesgos')->insert(array(
               'nombre' => 'Calidad'
             ));
      db::table('tiporiesgos')->insert(array(
               'nombre' => 'Seguridad Laboral'
             ));
      db::table('tiporiesgos')->insert(array(
               'nombre' => 'Impacto Ambiental'
             ));
      db::table('tiporiesgos')->insert(array(
               'nombre' => 'Financiero'
             ));
      db::table('tiporiesgos')->insert(array(
               'nombre' => 'Legal'
             ));
      db::table('tiporiesgos')->insert(array(
               'nombre' => 'Operativo'
             ));
      db::table('tiporiesgos')->insert(array(
               'nombre' => 'Seguridad de Información'
             ));
      db::table('tiporiesgos')->insert(array(
               'nombre' => 'Continidad de Negocios'
             ));
      db::table('tiporiesgos')->insert(array(
               'nombre' => 'Crediticio'
             ));
      db::table('tiporiesgos')->insert(array(
               'nombre' => 'Reputacional'
             ));
      db::table('tiporiesgos')->insert(array(
               'nombre' => 'Tecnológico'
             ));
      db::table('tiporiesgos')->insert(array(
               'nombre' => 'Comercial'
             ));
      db::table('tiporiesgos')->insert(array(
               'nombre' => 'Inocuidad'
             ));
      db::table('tiporiesgos')->insert(array(
               'nombre' => 'Lavado y Antiterrorismo'
             ));

    }


}

class LogicasTableSeeder extends Seeder {

    public function run()
    {
      db::table('logicas')->insert(array(
                 'simbolo' => '='
             ));
             db::table('logicas')->insert(array(
                        'simbolo' => '<>'
                    ));
                    db::table('logicas')->insert(array(
                               'simbolo' => '>'
                           ));
                           db::table('logicas')->insert(array(
                                      'simbolo' => '<'
                                  ));
                                  db::table('logicas')->insert(array(
                                             'simbolo' => '>='
                                         ));
                                         db::table('logicas')->insert(array(
                                                    'simbolo' => '<='
                                                ));
    }

}
    class FrecuenciasTableSeeder extends Seeder {

        public function run()
        {
          db::table('frecuencias')->insert(array(
                     'nombre' => 'Diaria'
                 ));

                 db::table('frecuencias')->insert(array(
                            'nombre' => 'Mensual'
                        ));
                        db::table('frecuencias')->insert(array(
                                   'nombre' => 'Semestral'
                               ));
                               db::table('frecuencias')->insert(array(
                                          'nombre' => 'Anual'
                                      ));
        }
}

        class TipoProcesosTableSeeder extends Seeder {

            public function run()
            {
              db::table('tipoprocesos')->insert(array(
                         'nombreproceso' => 'Gestion'
                     ));
                     db::table('tipoprocesos')->insert(array(
                                'nombreproceso' => 'Core'
                            ));
                            db::table('tipoprocesos')->insert(array(
                                       'nombreproceso' => 'Financiero'
                                   ));

            }

}

class TipoObjetivosTableSeeder extends Seeder {

    public function run()
    {
      db::table('tipo_objetivos')->insert(array(
                 'nombre' => 'Financieros'
             ));
             db::table('tipo_objetivos')->insert(array(
                        'nombre' => 'Cliente'
                    ));
                    db::table('tipo_objetivos')->insert(array(
                               'nombre' => 'Procesos'
                           ));
                           db::table('tipo_objetivos')->insert(array(
                                      'nombre' => 'Crecimiento'
                                  ));

    }

}
class UnidadesTableSeeder extends Seeder {

    public function run()
    {
      db::table('unidades')->insert(array(
                 'simbolo' => '$'
             ));

      db::table('unidades')->insert(array(
                'simbolo' => '#'
            ));


       db::table('unidades')->insert(array(
                  'simbolo' => '%'
              ));
    }
}

class TypedocumentsTableSeeder extends Seeder {

    public function run()
    {
      //Documentos

      db::table('typedocuments')->insert(array(
                 'id' => '1'
                 ,'nombre' => 'POLITICAS'
             ));

      db::table('typedocuments')->insert(array(
              'id' => '2'
              ,'nombre' => 'MANUALES'
            ));


       db::table('typedocuments')->insert(array(
               'id' => '3'
               ,'nombre' => 'PROCEDIMIENTOS'
              ));

       db::table('typedocuments')->insert(array(
               'id' => '4'
               ,'nombre' => 'INTRUCCIONES DE TRABAJO'
              ));

       db::table('typedocuments')->insert(array(
               'id' => '5'
               ,'nombre' => 'FORMATOS'
              ));

       db::table('typedocuments')->insert(array(
               'id' => '6'
               ,'nombre' => 'DOCUMENTOS EXTERNOS'
              ));

//Estrategias
       db::table('typedocuments')->insert(array(
               'id' => '11'
               ,'nombre' => 'PLANIFICACION ESTRATEGICA'
              ));

       db::table('typedocuments')->insert(array(
               'id' => '12'
               ,'nombre' => 'PARTES INTERESADAS'
              ));

       db::table('typedocuments')->insert(array(
               'id' => '13'
               ,'nombre' => 'OBJETIVOS E INDICADORES'
              ));

       db::table('typedocuments')->insert(array(
               'id' => '14'
               ,'nombre' => 'REVISIONES DIRECTIVAS'
              ));

//Procesos
     db::table('typedocuments')->insert(array(
             'id' => '21'
             ,'nombre' => 'ARQUITECTURA DE PROCESOS'
            ));

     db::table('typedocuments')->insert(array(
             'id' => '22'
             ,'nombre' => 'PROCESOS DE GESTION'
            ));

     db::table('typedocuments')->insert(array(
             'id' => '23'
             ,'nombre' => 'PROCESOS CORE'
            ));

     db::table('typedocuments')->insert(array(
             'id' => '24'
             ,'nombre' => 'PROCESOS DE SOPORTE'
            ));

//Riesgos
     db::table('typedocuments')->insert(array(
             'id' => '31'
             ,'nombre' => 'RIESGOS DE CALIDAD'
            ));

     db::table('typedocuments')->insert(array(
             'id' => '32'
             ,'nombre' => 'RIESGOS AMBIENTALES'
            ));

     db::table('typedocuments')->insert(array(
             'id' => '33'
             ,'nombre' => 'RIESGOS DE SEGURIDAD LABORAL'
            ));

     db::table('typedocuments')->insert(array(
             'id' => '34'
             ,'nombre' => 'RIESGOS DE SUMINISTROS'
            ));

//Recursos
     db::table('typedocuments')->insert(array(
             'id' => '40'
             ,'nombre' => 'ORGANIGRAMA'
            ));

     db::table('typedocuments')->insert(array(
             'id' => '41'
             ,'nombre' => 'PERFIL DE PUESTO'
            ));

     db::table('typedocuments')->insert(array(
             'id' => '42'
             ,'nombre' => 'EXPEDIENTES'
            ));

     db::table('typedocuments')->insert(array(
             'id' => '43'
             ,'nombre' => 'CAPACITACIÓN'
            ));

     db::table('typedocuments')->insert(array(
             'id' => '44'
             ,'nombre' => 'PROGRAMA DE MANTENIMIENTO'
            ));

     db::table('typedocuments')->insert(array(
             'id' => '45'
             ,'nombre' => 'EQUIPO O MAQUINARIA'
            ));

     db::table('typedocuments')->insert(array(
             'id' => '46'
             ,'nombre' => 'PROGRAMA DE CALIBRACIÒN'
            ));

     db::table('typedocuments')->insert(array(
             'id' => '47'
             ,'nombre' => 'EQUIPO DE MED Y PBA'
            ));

//Operacion
    db::table('typedocuments')->insert(array(
      'id' => '51'
      ,'nombre' => 'CALIDAD'
    ));

    db::table('typedocuments')->insert(array(
      'id' => '52'
      ,'nombre' => 'AMBIENTAL'
    ));

    db::table('typedocuments')->insert(array(
      'id' => '53'
      ,'nombre' => 'SEGURIDAD'
    ));

    db::table('typedocuments')->insert(array(
      'id' => '54'
      ,'nombre' => 'PRUEBAS O ENSAYOS'
    ));

    db::table('typedocuments')->insert(array(
      'id' => '55'
      ,'nombre' => 'SUMINISTROS'
    ));

    db::table('typedocuments')->insert(array(
      'id' => '56'
      ,'nombre' => 'DISEÑO Y DESARROLLO'
    ));

    db::table('typedocuments')->insert(array(
      'id' => '57'
      ,'nombre' => 'COMPRAS'
    ));


//Operacion
    db::table('typedocuments')->insert(array(
      'id' => '60'
      ,'nombre' => 'PLANES DE CALIDAD'
    ));

    db::table('typedocuments')->insert(array(
      'id' => '61'
      ,'nombre' => 'PLANES AMBIENTALES'
    ));

    db::table('typedocuments')->insert(array(
      'id' => '62'
      ,'nombre' => 'PLANES DE SEGURIDAD'
    ));

    db::table('typedocuments')->insert(array(
      'id' => '63'
      ,'nombre' => 'PLANES DE SUMINISTROS'
    ));

    db::table('typedocuments')->insert(array(
      'id' => '64'
      ,'nombre' => 'PNCs DE CALIDAD'
    ));

    db::table('typedocuments')->insert(array(
      'id' => '65'
      ,'nombre' => 'PNCs AMBIENTALES'
    ));

    db::table('typedocuments')->insert(array(
      'id' => '66'
      ,'nombre' => 'PNCs DE SEGURIDAD'
    ));

    db::table('typedocuments')->insert(array(
      'id' => '67'
      ,'nombre' => 'PNCs DE SUMINISTROS'
    ));

    db::table('typedocuments')->insert(array(
      'id' => '68'
      ,'nombre' => 'PROGRAMAS DE AUDITORIAS'
    ));

    db::table('typedocuments')->insert(array(
      'id' => '69'
      ,'nombre' => 'AUDITORES INTERNOS'
    ));

    db::table('typedocuments')->insert(array(
      'id' => '70'
      ,'nombre' => 'DICTAMENES DE AUDITORIA'
    ));

    db::table('typedocuments')->insert(array(
      'id' => '71'
      ,'nombre' => 'QUEJAS'
    ));

    //Mejora
    db::table('typedocuments')->insert(array(
      'id' => '81'
      ,'nombre' => 'ACCIONES CORRECTIVAS'
    ));

    db::table('typedocuments')->insert(array(
      'id' => '82'
      ,'nombre' => 'PROYECTOS DE MEJORA'
    ));


    }
}

class objetivosTableSeeder extends Seeder {

    public function run()
    {
      db::table('objetivos')->insert(array(
               'tipo_objetivo_id'            => 1,
               'nombre'                      => 'Crecimiento',
               'descripcion'                 =>  '',
               'usuario_responsable_id'      =>  1,
               'usuario_creador_id'          =>  1,
               'id_compania'                 =>  1
             ));

     db::table('objetivos')->insert(array(
              'tipo_objetivo_id'            => 1,
              'nombre'                      => 'Eficiencia',
              'descripcion'                 =>  '',
              'usuario_responsable_id'      =>  1,
              'usuario_creador_id'          =>  1,
              'id_compania'                 =>  1
            ));

      db::table('objetivos')->insert(array(
               'tipo_objetivo_id'            => 1,
               'nombre'                      => 'Inversion',
               'descripcion'                 =>  '',
               'usuario_responsable_id'      =>  1,
               'usuario_creador_id'          =>  1,
               'id_compania'                 =>  1
             ));

       db::table('objetivos')->insert(array(
                'tipo_objetivo_id'            => 2,
                'nombre'                      => 'Lealtad del cliente',
                'descripcion'                 =>  '',
                'usuario_responsable_id'      =>  1,
                'usuario_creador_id'          =>  1,
                'id_compania'                 =>  1
              ));


       db::table('objetivos')->insert(array(
                'tipo_objetivo_id'            => 2,
                'nombre'                      => 'Nuevos Clientes',
                'descripcion'                 =>  '',
                'usuario_responsable_id'      =>  1,
                'usuario_creador_id'          =>  1,
                'id_compania'                 =>  1
              ));


       db::table('objetivos')->insert(array(
                'tipo_objetivo_id'            => 2,
                'nombre'                      => 'Nuevos Segmentos',
                'descripcion'                 =>  '',
                'usuario_responsable_id'      =>  1,
                'usuario_creador_id'          =>  1,
                'id_compania'                 =>  1
              ));



       db::table('objetivos')->insert(array(
                'tipo_objetivo_id'            => 3,
                'nombre'                      => 'BPM',
                'descripcion'                 =>  '',
                'usuario_responsable_id'      =>  1,
                'usuario_creador_id'          =>  1,
                'id_compania'                 =>  1
              ));


        db::table('objetivos')->insert(array(
                 'tipo_objetivo_id'            => 3,
                 'nombre'                      => 'Certificacion ISO',
                 'descripcion'                 =>  '',
                 'usuario_responsable_id'      =>  1,
                 'usuario_creador_id'          =>  1,
                 'id_compania'                 =>  1
               ));


         db::table('objetivos')->insert(array(
                  'tipo_objetivo_id'            => 3,
                  'nombre'                      => 'Sourcing',
                  'descripcion'                 =>  '',
                  'usuario_responsable_id'      =>  1,
                  'usuario_creador_id'          =>  1,
                  'id_compania'                 =>  1
                ));


         db::table('objetivos')->insert(array(
                  'tipo_objetivo_id'            => 4,
                  'nombre'                      => 'Plan de sucesion',
                  'descripcion'                 =>  '',
                  'usuario_responsable_id'      =>  1,
                  'usuario_creador_id'          =>  1,
                  'id_compania'                 =>  1
                ));


         db::table('objetivos')->insert(array(
                  'tipo_objetivo_id'            => 4,
                  'nombre'                      => 'Gestion por competencias',
                  'descripcion'                 =>  '',
                  'usuario_responsable_id'      =>  1,
                  'usuario_creador_id'          =>  1,
                  'id_compania'                 =>  1
              ));


       db::table('objetivos')->insert(array(
                'tipo_objetivo_id'            => 4,
                'nombre'                      => 'Clima laboral',
                'descripcion'                 =>  '',
                'usuario_responsable_id'      =>  1,
                'usuario_creador_id'          =>  1,
                'id_compania'                 =>  1
            ));



    }


 }
