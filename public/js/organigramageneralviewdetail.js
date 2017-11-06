




$(document).ready(function(){


     $("#dialog").dialog({
          modal: true,
          width : "50%",
          autoOpen: false,
          show: {
              effect: "explode",
              duration: 200
          },
          hide: {
              effect: "explode",
              duration: 200
          }
      });



      var orgChart = new getOrgChart(document.getElementById("people"), {
          primaryFields: ["nombrepuesto","nombre"],
          photoFields: ["image"],
          enableEdit: false,
          enableDetailsView: false,
         // searchable: false,
         // updatedEvent: updatedEvent,
         // updateNodeEvent: updateNodeEvent,
         // removeNodeEvent: removeNodeEvent,
         // insertNodeEvent: insertNodeEvent,
         enablePrint: true,
          clickNodeEvent: clickNodeEvent,
         // createNodeEvent: createNodeEvent
      });

      $.getJSON("/personalorganigramashowdetail", function (data) {
          orgChart.loadFromJSON(data);


      });



  initControls();



              });

// termina document ready

  function initControls(){
  window.location.hash="red";
  window.location.hash="Red" //chrome
  window.onhashchange=function(){window.location.hash="red";}

  }



  function clickNodeEvent(sender, args) {


/*
  if(args.node.pid == null)
   {
     return false;
   }

    iradescripcion(args.node.id)
    */
  }


  function iradescripcion(val) {

   window.location.replace("/personaldescriptorpuestoview/"+val);

  }



function updateNodeEvent() {

  var x = confirm("Estas seguro de hacer los cambios?");
  if (x){
    var parent =  $("#hdnparentId").val();
    if (parent == null)
    {
      alert("No puedes cambiar el nombre de la empresa desde aqui")
      return false;
    }
var value = $("#hdnId").val();
var route = "/personalorganigramaedit/"+value;
var fd = new FormData(document.getElementById("fileinfo"));
var progressBar = 0;
var token = $("#token").val();



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
   $("#dialog").dialog("close");
   updatedEvent();
 }
});



}
else
 return false;



}




function insertNodeEvent() {

var value = $("#hdnId").val();
$("#txtName").val("Nuevo puesto (Renombrar)");

var route = "/personalorganigramainsert/"+value;
var fd = new FormData(document.getElementById("fileinfo"));

var progressBar = 0;
var token = $("#_token").val();


$("#dialog").dialog("close");

$.ajax({
 url: route,
 headers: {'X-CSRF_TOKEN':  $('meta[name="csrf-token"]').attr('content')},
 type: 'post',
 data: $("#fileinfo").serialize(),

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
   alert("Nuevo puesto agregado favor de renombrar");
   updatedEvent();
 }
});


}




function removeNodeEvent() {

var value = $("#hdnparentId").val();

//$("#hdnId").val();
//$("#hdnparentId").val();
//$("#txtName").val();

  if (value == "")
  {
    alert("No puedes eliminar la empresa desde aqui")
    updatedEvent();
    $("#dialog").dialog("close");
    return false;
  }

   var x = confirm("Estas seguro de querer eliminar el puesto?");
     if (x){
     var value = $("#hdnId").val();

     var route = "/personalorganigramadelete/"+value;

     $.get(route,  function(res){

     alert("Se elimino el puesto y todos sus subniveles")

     });

     updatedEvent();
     $("#dialog").dialog("close");
     return false;


     }

     else
     {
       updatedEvent();
       $("#dialog").dialog("close");
       return false;
     }



}





function createNodeEvent(sender, args) {
alert("hola mundo insert");
alert(args.node.id);
alert(args.node.pid);

}





  function updatedEvent() {

    var orgChart = new getOrgChart(document.getElementById("people"), {
        primaryFields: ["nombrepuesto"],
        enableEdit: false,
        enableDetailsView: false,
        searchable: false,
     //   updatedEvent: updatedEvent,
     //   updateNodeEvent: updateNodeEvent,
     //   removeNodeEvent: removeNodeEvent,
     //   insertNodeEvent: insertNodeEvent,
        clickNodeEvent: clickNodeEvent,
        enablePrint: true,
       // createNodeEvent: createNodeEvent
    });

    $.getJSON("/personalorganigramashow", function (data) {
        orgChart.loadFromJSON(data);

    });

  }



  function ZoomToNode(node) {
      var newViewBox = document.getElementById("people").getElementsByTagName("svg")[0].getAttribute("viewBox");
      newViewBox = "[" + newViewBox + "]";
      newViewBox = eval(newViewBox.replace(/\ /g, ", "));

      var aspectRatio = newViewBox[2] / newViewBox[3];
      newViewBox[2] = node.w * 1.5;
      newViewBox[3] = newViewBox[2] / aspectRatio;
      newViewBox[0] = (node.x - (node.w / 4));
      newViewBox[1] = (node.y - (newViewBox[3] / 2) + node.h / 2);

      orgchart.move(newViewBox)
  }



  function pulsar(e) {
    tecla = (document.all) ? e.keyCode :e.which;
    return (tecla!=13);
  }
