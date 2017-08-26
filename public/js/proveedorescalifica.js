

  $(document).ready(function() {


        $('#pedido').keypress(function(tecla) {
            if( (tecla.charCode < 48 || tecla.charCode > 57) && (tecla.charCode < 97 || tecla.charCode > 122) && (tecla.charCode < 65 || tecla.charCode > 90) && (tecla.charCode != 45)  ) return false;
        });
    //$('#proveedor').find('option:first').attr('selected', 'selected').parent('select');
    $('#radios').hide();
    $('#selectinsumos').hide();
    $('#pedidos').hide();
    $('#btnsubmit').hide();
    $('#archivos').hide();
    $('#areas').hide();
    $('#comnt').hide();



  $("#proveedor").change(function() {
    //$('#proveedor').val('0').find('option[value="0"]‌​').remove();
    $("#proveedor option[value='0']").remove();
    $('#selectinsumos').show();
    $('#archivos').show();
    $("#elistaDisponibles").empty();
    $("#elistaSeleccionada").empty();
    var id = $('#proveedor').val();
    var route = "/provedores/califica/insumo/"+ $('#proveedor').val();

    $('#comnt').show();
    $('#pedidos').show();
    $('#areas').show();
    $('#radios').show();
    var id2 = $('#insumo').val();

    $.get(route, function(res){
      for (var i = 0; i < res.length; i++) {
        $("#elistaDisponibles").append('<option value="'+res[i].idinsumo+'">'+res[i].Producto_o_Servicio+'</option>');
      }
      });
      var test = $("input[name=proveedorid]:hidden").val(id);


              });

  $("#area").change(function() {
    $("#area option[value='0']").remove();
    $('#btnsubmit').show();
                    });


  initControls();

              });


              function initControls(){
              window.location.hash="red";
              window.location.hash="Red" //chrome
              window.onhashchange=function(){window.location.hash="red";}
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



    var select = document.getElementById('elistaSeleccionada');

    for ( var i = 0, l = select.options.length, o; i < l; i++ )
    {
      o = select.options[i];
        o.selected = true;
    }

}
