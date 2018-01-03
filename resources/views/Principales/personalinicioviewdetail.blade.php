@extends('layouts.principal2')

@section('content')


</br>

@if(Session::has('flash_message'))
<script>
alert ('{{Session::get('flash_message')}}')
</script>
@endif



<script src="/js/getorgchart/getorgchart.js"></script>
<link href="/css/getorgchart/getorgchart.css" rel="stylesheet" />


<link rel="stylesheet" href="/css/jquery-ui.css">
<script src="/js/jquery-1.12.4.js"></script>
<script src="/js/jquery-ui.js"></script>
<script src="/js/organigramageneralviewdetail.js"></script>


<div id="pruebasjquery"></div>
<center><button type="button" class="btnobjetivo" onclick=location="/recpersonal" data-dismiss="modal" id="btnCloseUpload">Regresar</button></center>
<!--<br>
<div class="row">
  <center>
    <div class="col-lg-4">
      </div>
   <div class="col-lg-4">
     <select class="form-control" name="filtroOrg" id="filtroOrg" >
                <option value="1" selected="selected" >Puestos general</option>
                <option value="2">Detalle usuarios</option>
     </select>
   </div>
  </center>
</div>
-->
<style type="text/css">
    html, body {
        margin: 0px;
        padding: 0px;
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    #people {
        width: 100%;
        height: 100%;
    }

    .btn path {
        fill: #dbdbdb;
    }

    .btn:hover path {
        fill: #ffffff;
    }

    select, input[type=text], input[type=email] {
        width: 100%;
    }
</style>

</br>


  				<div class="orgchart" id="people"></div>


           <div id="dialog" title="Acciones sobre puesto">
            <form id="fileinfo" name="fileinfo" class=""  action=""  method="post" accept-charset="UTF-8" enctype="multipart/form-data" >
               <input type="hidden" name="_token" id="_token" value="<?php echo csrf_token(); ?>">
               <input type="hidden" name="hdnId" id="hdnId" />
               <input type="hidden" name="hdnparentId" id="hdnparentId" />
               <div>
                   <label for="txtName">Puesto</label><br /><input name="txtName" id="txtName" type="text" onkeypress="return pulsar(event)"/>
               </div><br />
            <center>
               <input id="btnVer" type="button" class="btnobjetivo" value="Ver informacion de puesto" onclick="iradescripcion()"/>
            <!--   <input type="submit"> -->
            </center>
            </form>
           </div>





@stop
