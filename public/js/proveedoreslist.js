

//Funcion para llenar el modal de edicion
//

function aprobar(btn){
  var route = "/proveedor/show/"+btn.value;

  $("#rid").val(btn.value);


}

function rechazo(btn){
  var route = "/proveedor/show/"+btn.value;

  $("#rid").val(btn.value);


}



function Editar(btn){
  var route = "/proveedor/show/"+btn.value;
  var route2 = "/proveedor/show2/"+btn.value;
  var route3 = "/proveedor/show3/"+btn.value;
  var route4 = "/proveedor/show4/"+btn.value;

  $.get(route, function(res){

    $("#eproveedor").val(res.proveedor);
    $("#eemail").val(res.email);
    $("#etelefono").val(res.telefono);
    $("#edireccion").val(res.direccion);
    $("#eobservaciones").val(res.observaciones);
    $("#eid").val(res.id);
    $("#ecomentariorechazo").val(res.comentariorechazo);
    $("#documentosalta").val(res.id);
    $("#fid").val(res.id);

    if (res.activo == 'Rechazado' && btn.name==1)
    {
      $("#ecomentariorechazocont").show();
    }
    else {
      $("#ecomentariorechazocont").hide();
    }


    $("#eactivo").empty();
    $("#eactivo").append('<option selected="selected" value="'+res.activo+'">'+res.activo+'</option>');


  var profile = $("#euprofile").val();

     if(profile!=4)
     {
      $("#eactivo").append('<option value="En espera de aprobacion"> En espera de aprobacion </option>'+
                           '<option value="Activo / aprobado" > Activo / aprobado </option>'+
                           '<option value="Inactivo"> Inactivo </option>');
     }
  });



    if(btn.name==1)
    {    $('#containeredit').find('input, textarea, button, select').attr('disabled',true);
         $("#elistaSeleccionada").empty();
         $('#guardacambios').hide();
         $('#documentosalta').hide();
         $('#selectinsumos').hide();
         $('#listtinsumos').show();
         $("#elist").empty();
         $('#listfiles').show();
         $("#elistfile").empty();


         $.get(route2, function(res){
             for (var i = 0; i < res.length; i++) {
               $("#elist").append('<li class="list-group-item" id="'+res[i].idinsumo+'"><center><h5>'+res[i].Producto_o_Servicio+' <a href="/insumo/file/ver/'+res[i].idinsumo+'"> <span class="glyphicon glyphicon-download-alt"></i></a></h5></center></li>');
//               $("#elist").append('<li class="list-group-item" id="'+res[i].idinsumo+'"><center><h5>'+res[i].Producto_o_Servicio+'</h5></center></li>');

             }
           });


         $.get(route4, function(res){
             for (var i = 0; i < res.length; i++) {
               $("#elistfile").append('<li class="list-group-item" id="'+res[i].id+'"><center><h5>'+res[i].archivo+'  <a href="/proveedor/file/ver/'+res[i].id+'"> <span class="glyphicon glyphicon-download-alt"></i></a></h5></center></li>');

             }

           });

    }
    else {$('#containeredit').find('input, textarea, button, select').attr('disabled',false);
          $('#guardacambios').show();
          $('#documentosalta').show();
          $("#elist").empty();
          $('#listtinsumos').hide();
          $("#elistfile").empty();
          $('#listfiles').hide();
          $("#ecomentariorechazocont").hide();
          $('#selectinsumos').show();
          $("#elistaSeleccionada").empty();
          $("#elistaDisponibles").empty();

          $.get(route2, function(res){
            for (var i = 0; i < res.length; i++) {
              $("#elistaSeleccionada").append('<option value="'+res[i].idinsumo+'">'+res[i].Producto_o_Servicio+'</option>');
            }

            var select = document.getElementById('elistaSeleccionada');

            for ( var i = 0, l = select.options.length, o; i < l; i++ )
            {
              o = select.options[i];
                o.selected = true;
            }

          });

          $.get(route3, function(res){
            for (var i = 0; i < res.length; i++) {
              $("#elistaDisponibles").append('<option value="'+res[i].id+'">'+res[i].Producto_o_Servicio+'</option>');
            }

            var select = document.getElementById('elistaDisponibles');

          });
         $("#ecomentariorechazocont").hide();
    }

}


//Funcion para llenar el modal de archivo


function Archivo(btn){
  var route = "/proveedor/file/show/"+btn.value;

  $.get(route,function(res){
    $("#snombrearchivo").val("");
    $("#snombrearchivo").empty();
    $("#archivo").val("");
    $("#archivo").empty();
    $("#FmyTable").empty();
    for (var i = 0; i < res.length; i++) {
      $("#FmyTable").append('<tr><td>'+res[i].nombre+'</td><td>'+res[i].archivo+'</td><td>'+res[i].size+'</td><td><form class="form-inline" action="/proveedor/file/delete/'+res[i].id+'" method="delete"> <a href="/proveedor/file/ver/'+res[i].id+'" target="_blank" style=\'color:#FFF\'><button type="button" class="btnobjetivo"><i class="glyphicon glyphicon-download-alt"></i> Ver archivo </button> </a>  <input type="hidden" name="_token" value="{{{ csrf_token() }}}"> <button type="submit" class="btnobjetivo" id="btndelete_'+res[i].id+'" style="font-family: Arial;" dataid="'+res[i].id+'" onclick="return confirm(\'Estas seguro de eliminar el archivo: ' +
       res[i].nombre +'?\')"><i class="glyphicon glyphicon-remove"></i> Eliminar</button></form></td></tr>');
    }




  });
  }



//Funciones para la tabla
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

  $('#myTable').pageMe({pagerSelector:'#myPager',showPrevNext:true,hidePageNumbers:false,perPage:10});
  $('#fmyTable').pageMe({pagerSelector:'#FmyPager',showPrevNext:true,hidePageNumbers:false,perPage:10});

  //Funcion para guardar el modal de edicion

  $("#guardacambios").click(function(){
    var value = $("#eid").val();
    var route = "/proveedor/edit/"+value+"";
    var token = $("#token").val();
    var fd = new FormData(document.getElementById("fileinfo"));
    var progressBar = 0;

    $.ajax({
      url: route,
      headers: {'X-CSRF_TOKEN': token},
      type: 'post',
      data: fd,
      processData: false,  // tell jQuery not to process the data
      contentType: false,
      xhr: function() {
        var xhr = $.ajaxSettings.xhr();
        xhr.upload.onprogress = function(e) {
          progressBar.max = e.total;
          progressBar.value = e.loaded;
            console.log(Math.floor(e.loaded / e.total *100) + '%');
        };
        return xhr;
      },
      success: function(){
        alert("Cambios guardados correctamente");
        location.reload();
      }
    });
  });


//Funcion para guardar el modal de archivo
  $("#guardadoc").click(function(){
    var value = $("#fid").val();
    var route = "/proveedor/file/"+value+"";
    var token = $("#token").val();
    var fd = new FormData(document.getElementById("fileup"));
    var progressBar = document.getElementById("progress");

    $.ajax({
      url: route,
      headers: {'X-CSRF_TOKEN': token},
      type: 'post',
      data: fd,
      processData: false,  // tell jQuery not to process the data
      contentType: false,
      xhr: function() {
        var xhr = $.ajaxSettings.xhr();
        xhr.upload.onprogress = function(e) {
          progressBar.max = e.total;
          progressBar.value = e.loaded;
            console.log(Math.floor(e.loaded / e.total *100) + '%');
        };
        return xhr;
      },
      success: function(){
        alert("Cambios guardados correctamente");
        location.reload();
      }
    });
  });

  initControls();

              });


              function initControls(){
              window.location.hash="red";
              window.location.hash="Red" //chrome
              window.onhashchange=function(){window.location.hash="red";}
              }






function doSearch(table,textbuscado)
{
  var tableReg = document.getElementById(table);
  var searchText = document.getElementById(textbuscado).value.toLowerCase();
  var cellsOfRow="";
  var found=false;
  var compareWith="";

  // Recorremos todas las filas con contenido de la tabla
  for (var i = 1; i < tableReg.rows.length; i++)
  {
    cellsOfRow = tableReg.rows[i].getElementsByTagName('td');
    found = false;
    // Recorremos todas las celdas
    for (var j = 0; j < cellsOfRow.length-1 && !found; j++)
    {
      compareWith = cellsOfRow[j].innerHTML.toLowerCase();
      // Buscamos el texto en el contenido de la celda
      if (searchText.length == 0 || (compareWith.indexOf(searchText) > -1))
      {
        found = true;
      }
    }
    if(found)
    {
      tableReg.rows[i].style.display = '';
    } else {
      // si no ha encontrado ninguna coincidencia, esconde la
      // fila de la tabla
      tableReg.rows[i].style.display = 'none';
    }
  }
}




// para select multiple

function agregaSeleccion(origen, destino) {
    obj = document.getElementById(origen);
    if (obj.selectedIndex == -1)
        return;

    for (i = 0; opt = obj.options[i]; i++)
        if (opt.selected) {
            valor = opt.value; // almacenar value
            txt = obj.options[i].text; // almacenar el texto
            obj.options[i] = null; // borrar el item si está seleccionado
            obj2 = document.getElementById(destino);

            opc = new Option(txt, valor,"defaultSelected");
            eval(obj2.options[obj2.options.length] = opc);
        }

        var select = document.getElementById('listaSeleccionada');

        for ( var i = 0, l = select.options.length, o; i < l; i++ )
        {
          o = select.options[i];
            o.selected = true;
        }

        var select = document.getElementById('elistaSeleccionada');

        for ( var i = 0, l = select.options.length, o; i < l; i++ )
        {
          o = select.options[i];
            o.selected = true;
        }


    }

    function agregaTodo(origen, destino) {
        obj = document.getElementById(origen);
        obj2 = document.getElementById(destino);
        aux = obj.options.length;
        for (i = 0; i < aux; i++) {
            aux2 = 0;
            opt = obj.options[aux2];
        valor = opt.value; // almacenar value
        txt = obj.options[aux2].text; // almacenar el texto
        obj.options[aux2] = null; // borrar el item si está seleccionado

        opc = new Option(txt, valor,"defaultSelected");
        eval(obj2.options[obj2.options.length] = opc);
    }

    var select = document.getElementById('listaSeleccionada');

    for ( var i = 0, l = select.options.length, o; i < l; i++ )
    {
      o = select.options[i];
        o.selected = true;
    }

    var select = document.getElementById('elistaSeleccionada');

    for ( var i = 0, l = select.options.length, o; i < l; i++ )
    {
      o = select.options[i];
        o.selected = true;
    }

}

// termina para select multiple
