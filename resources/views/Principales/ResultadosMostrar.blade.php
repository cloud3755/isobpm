@extends('layouts.principal2')

@section('content')

<br><br><br><br><br><br><br><br><br>
<br>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-red">
            <div class="panel-heading">
                Indicadores para resultados
            </div>
        <div class="panel-body">
            <div class="dataTable_wrapper">
                <table width="100%" class="table table-responsive table-striped table-bordered table-hover" id="tblProIn">
                  <thead style='background-color: #868889; color:#FFF'>
                    <tr>
                      <th><div class="th-inner sortable both">  ID</div></th>
                      <th><div class="th-inner sortable both">  Objetivo ID</div></th>
                      <th><div class="th-inner sortable both">  Nombre</div></th>
                      <th><div class="th-inner sortable both">  Descripcion</div></th>
                      <th><div class="th-inner sortable both">  Responsable</div></th>
                      <th><div class="th-inner sortable both">  frecuencia_id</div></th>
                      <th><div class="th-inner sortable both">  unidad</div></th>
                      <th><div class="th-inner sortable both">  logica</div></th>
                      <th><div class="th-inner sortable both">  meta</div></th>
                      <th><div class="th-inner sortable both">  Resultados</div></th>
                    </tr>
                  </thead>
                  <!-- aqui va la consulta a la base de datos para traer las filas se hace desde el controlador-->
                  <tbody id="myTable">
                    <?php foreach ($indicadorrelacion as $indicadorrel): ?>
                    <tr><td><?=$indicadorrel->id?></td>
                    <td><?=$indicadorrel->indicadoresobjetivo?></td>
                    <td><?=$indicadorrel->nombreindicador?></td>
                    <td><?=$indicadorrel->descripcionindicador?></td>
                    <td><?=$indicadorrel->userindicador?></td>
                    <td><?=$indicadorrel->frecuenciaindicador?></td>
                    <td><?=$indicadorrel->simboloindicador?></td>
                    <td><?=$indicadorrel->logicaindicador?></td>
                    <td><?=$indicadorrel->indicadormeta?></td>
                      <td>
                        <button type="button" class="btnproceso" onclick=location="/resultado/registro/<?=$indicadorrel->id ?>" id="<?=$indicadorrel->id ?>">Resultados</button>
                      </td>
                    </tr>
                    <?php endforeach ?>
                  </tbody>
                </table>
            </div>
            <div class="col-md-12 text-center">
              <ul class="pagination pagination-lg pager" id="myPager"></ul>
            </div>
        </div>
      </div>
    </div>
  </div>



  <script type="text/javascript">

  $.fn.pageMe = function(opts){
      var $this = this,
          defaults = {
              perPage: 7,
              showPrevNext: false,
              hidePageNumbers: false
          },
          settings = $.extend(defaults, opts);

      var listElement = $this;
      var perPage = settings.perPage;
      var children = listElement.children();
      var pager = $('.pager');

      if (typeof settings.childSelector!="undefined") {
          children = listElement.find(settings.childSelector);
      }

      if (typeof settings.pagerSelector!="undefined") {
          pager = $(settings.pagerSelector);
      }

      var numItems = children.size();
      var numPages = Math.ceil(numItems/perPage);

      pager.data("curr",0);

      if (settings.showPrevNext){
          $('<li><a href="#" class="prev_link">«</a></li>').appendTo(pager);
      }

      var curr = 0;
      while(numPages > curr && (settings.hidePageNumbers==false)){
          $('<li><a href="#" class="page_link">'+(curr+1)+'</a></li>').appendTo(pager);
          curr++;
      }

      if (settings.showPrevNext){
          $('<li><a href="#" class="next_link">»</a></li>').appendTo(pager);
      }

      pager.find('.page_link:first').addClass('active');
      pager.find('.prev_link').hide();
      if (numPages<=1) {
          pager.find('.next_link').hide();
      }
        pager.children().eq(1).addClass("active");

      children.hide();
      children.slice(0, perPage).show();

      pager.find('li .page_link').click(function(){
          var clickedPage = $(this).html().valueOf()-1;
          goTo(clickedPage,perPage);
          return false;
      });
      pager.find('li .prev_link').click(function(){
          previous();
          return false;
      });
      pager.find('li .next_link').click(function(){
          next();
          return false;
      });

      function previous(){
          var goToPage = parseInt(pager.data("curr")) - 1;
          goTo(goToPage);
      }

      function next(){
          goToPage = parseInt(pager.data("curr")) + 1;
          goTo(goToPage);
      }

      function goTo(page){
          var startAt = page * perPage,
              endOn = startAt + perPage;

          children.css('display','none').slice(startAt, endOn).show();

          if (page>=1) {
              pager.find('.prev_link').show();
          }
          else {
              pager.find('.prev_link').hide();
          }

          if (page<(numPages-1)) {
              pager.find('.next_link').show();
          }
          else {
              pager.find('.next_link').hide();
          }

          pager.data("curr",page);
        	pager.children().removeClass("active");
          pager.children().eq(page+1).addClass("active");

      }
  };

  $(document).ready(function(){

    $('#myTable').pageMe({pagerSelector:'#myPager',showPrevNext:true,hidePageNumbers:false,perPage:5});

  });


  </script>

@Stop
