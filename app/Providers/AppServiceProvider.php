<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Noticias;
use Carbon\Carbon;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /*$noticia = new Noticias;
        $today = date("Y-m-d");
        $noticias = \DB::table('Noticias')->where('fecha_creacion',$today)->get();
        //$noticias->where('fecha_creacion','=',$today)->get();
        $arreglo = compact($noticias);
        if($noticias!=null)
        {
            View::share('noticiasw', $noticias);
        }
        else
        {
            View::share('noticias', $today);
        }
        /*

        */
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}


/*object(Illuminate\Database\Eloquent\Collection) 103 (1) {
     ["items":protected]=> array(2)
        { [0]=> object(App\Models\Noticias) 104 (23)
     { ["connection":protected]=> NULL
     ["table":protected]=> NULL
     ["primaryKey":protected]=> string(2) "id"
     ["perPage":protected]=> int(15)
     ["incrementing"]=> bool(true)
     ["timestamps"]=> bool(true)
     ["attributes":protected]=>
        array(7) {
            ["id"]=> int(4)
            ["id_empresa"]=> int(1)
            ["id_UsuarioCreo"]=> int(1)
            ["fecha_creacion"]=> string(10) "2017-07-21"
            ["Noticia"]=> string(1) "X"
            ["created_at"]=> string(19) "2017-07-21 00:13:03"
            ["updated_at"]=> string(19) "2017-07-21 00:13:03" } ["original":protected]=> array(7) { ["id"]=> int(4) ["id_empresa"]=> int(1) ["id_UsuarioCreo"]=> int(1) ["fecha_creacion"]=> string(10) "2017-07-21" ["Noticia"]=> string(1) "X" ["created_at"]=> string(19) "2017-07-21 00:13:03" ["updated_at"]=> string(19) "2017-07-21 00:13:03" } ["relations":protected]=> array(0) { } ["hidden":protected]=> array(0) { } ["visible":protected]=> array(0) { } ["appends":protected]=> array(0) { } ["fillable":protected]=> array(0) { } ["guarded":protected]=> array(1) { [0]=> string(1) "*" } ["dates":protected]=> array(0) { } ["dateFormat":protected]=> NULL ["casts":protected]=> array(0) { } ["touches":protected]=> array(0) { } ["observables":protected]=> array(0) { } ["with":protected]=> array(0) { } ["morphClass":protected]=> NULL ["exists"]=> bool(true) ["wasRecentlyCreated"]=> bool(false) } [1]=> object(App\Models\Noticias)#105 (23) { ["connection":protected]=> NULL ["table":protected]=> NULL ["primaryKey":protected]=> string(2) "id" ["perPage":protected]=> int(15) ["incrementing"]=> bool(true) ["timestamps"]=> bool(true) ["attributes":protected]=> array(7) { ["id"]=> int(5) ["id_empresa"]=> int(1) ["id_UsuarioCreo"]=> int(1) ["fecha_creacion"]=> string(10) "2017-07-21" ["Noticia"]=> string(3) "233" ["created_at"]=> string(19) "2017-07-21 00:13:59" ["updated_at"]=> string(19) "2017-07-21 00:13:59" } ["original":protected]=> array(7) { ["id"]=> int(5) ["id_empresa"]=> int(1) ["id_UsuarioCreo"]=> int(1) ["fecha_creacion"]=> string(10) "2017-07-21" ["Noticia"]=> string(3) "233" ["created_at"]=> string(19) "2017-07-21 00:13:59" ["updated_at"]=> string(19) "2017-07-21 00:13:59" } ["relations":protected]=> array(0) { } ["hidden":protected]=> array(0) { } ["visible":protected]=> array(0) { } ["appends":protected]=> array(0) { } ["fillable":protected]=> array(0) { } ["guarded":protected]=> array(1) { [0]=> string(1) "*" } ["dates":protected]=> array(0) { } ["dateFormat":protected]=> NULL ["casts":protected]=> array(0) { } ["touches":protected]=> array(0) { } ["observables":protected]=> array(0) { } ["with":protected]=> array(0) { } ["morphClass":protected]=> NULL ["exists"]=> bool(true) ["wasRecentlyCreated"]=> bool(false) } } }
            */
