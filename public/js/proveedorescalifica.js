

  $(document).ready(function() {

    //$('#proveedor').find('option:first').attr('selected', 'selected').parent('select');
    $('#radios').hide();
    $('#selectinsumos').hide();
    $('#pedidos').hide();
    $('#btnsubmit').hide();


  $("#proveedor").change(function() {
    //$('#proveedor').val('0').find('option[value="0"]‌​').remove();
    $("#proveedor option[value='0']").remove();
    $('#selectinsumos').show();
    $("#insumo").empty();
    var id = $('#proveedor').val();
    var route = "/provedores/califica/insumo/"+ $('#proveedor').val();


    $.get(route, function(res){
      $("#insumo").append('<option value="0">Selecciona un insumo</option>');
      for (var i = 0; i < res.length; i++) {
        $("#insumo").append('<option value="'+res[i].idinsumo+'">'+res[i].Producto_o_Servicio+'</option>');
      }
      });
      var test = $("input[name=proveedorid]:hidden").val(id);
              });


    $("#insumo").change(function() {
      $("#insumo option[value='0']").remove();
      $('#pedidos').show();
      $('#btnsubmit').show();
      $('#radios').show();
      var id2 = $('#insumo').val();
      var test2 = $("input[name=insumoid]:hidden").val(id2);


                });



});
