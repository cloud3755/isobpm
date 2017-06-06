@extends('layouts.maestra')

@section("content")
  <h1>crear formulario</h1>

  <form  action="/objetivos/store" method="post" role="form">

              {{csrf_field()}}

        <div class="form-grup">
            <label for="">tipo de objetivo id</label>
            <input type="text" class="form-control" name="tipo_objetivo_id" placeholder="escribe el id">
        </div>

        <div class="form-grup">
            <label for="">nombre</label>
            <input type="text" class="form-control" name="nombre" placeholder="escribe el nombre">
        </div>

        <div class="form-grup">
            <label for="">descripcion</label>
            <input type="text" class="form-control" name="descripcion" placeholder="escribe la descripcion">
        </div>

        <div class="form-grup">
            <label for="">fecha</label>
            <input type="date" class="form-control" name="fecha">
        </div>

        <div class="form-grup">
            <label for="">id responsable</label>
            <input type="text" class="form-control" name="usuario_responsable_id" placeholder="escribe el responsable">
        </div>

        <div class="form-grup">
            <label for="">creador id</label>
            <input type="text" class="form-control" name="usuario_creador_id" placeholder="escribe el id del responsable">
        </div>
        <br>

        <center><button type="submit" class="btn btn-primary">submit</button></center>
  </form>
@stop
