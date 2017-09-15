@extends('layouts.principal2')

@section('content')


</br>

@if(Session::has('flash_message'))
<script>
alert ('{{Session::get('flash_message')}}')
</script>
@endif


<script src="js/getorgchart/getorgchart.js"></script>


<script>
  initControls();

function initControls(){
window.location.hash="red";
window.location.hash="Red" //chrome
window.onhashchange=function(){window.location.hash="red";}
}

</script>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header text-center" style="font-weight: bold; text-shadow: 1px 1px #222; color:#0070B0;font-family: 'LeagueGothic';word-spacing: 5px; letter-spacing: 2px; border-bottom: none">Organigrama</h1>
    </div>
</div>


<center><button type="button" class="btnobjetivo" onclick=location="/bienvenida" data-dismiss="modal" id="btnCloseUpload">Regresar</button></center>


<style type="text/css">
        html, body {margin: 0px; padding: 0px;width: 100%;height: 100%;overflow: hidden; }
		.label {width: 150px; float: left;}
		select{width: 50%;}
		.field {padding: 10px 0 0 10px; height: 21px;}
		#people, .content {width: 100%; height: 100%;}
		#toolbar {width: 100%; background-color: #F3F3F3; height: 100%; }
		#toolbar, select, label, input[type=text] {font-family:"Segoe UI","Segoe UI Web Regular","Segoe UI Symbol","Helvetica Neue","BBAlpha Sans","S60 Sans",Arial,"sans-serif"; color: #444444;font-size: 12px;}
		.title {font-size: 20px; padding: 20px 0 0 10px;}
		#toolbar input {margin-left: 0px;}
		.event-console {width: 87%; height: 149px; background-color: white; margin: 20px 0 0 10px;border: 1px solid #C7C7C7; padding: 10px; overflow-y: scroll;}
		.arrow-left {width: 0; height: 0; border-top: 11px solid transparent;border-bottom: 11px solid transparent; 	border-right:11px solid #444444; float: left;margin-right: 3px;cursor: pointer;		}
		.arrow-right {width: 0; height: 0; border-bottom: 11px solid transparent;border-left: 11px solid #444444; 	border-top:11px solid transparent; float: left;margin-left: 3px;cursor: pointer;}
		.input{width: 50%;float: left; min-width: 183px;}
		.input input{width: 142px;float: left;}
    </style>
</br>


  				<div class="orgchart" id="people"></div>


           <div id="dialog" title="Edit node">
               <p>GetOrgChart is more customizable than you think. This is jquery dialog.</p>
               <input type="hidden" id="hdnId" />
               <div>
                   <label for="txtName">name</label><br /><input id="txtName" type="text" />
               </div><br />
               <div>
                   <label for="txtTitle">title</label><br /><input id="txtTitle" type="text" />
               </div><br />
               <div>
                   <label for="txtMail">mail</label><br /><input id="txtMail" type="email" />
               </div><br />
               <div>
                   <label for="txtCar">Car</label><br />
                   <select id="txtCar">
                       <option value="volvo">Volvo</option>
                       <option value="saab">Saab</option>
                       <option value="opel">Opel</option>
                       <option value="audi">Audi</option>
                   </select>
               </div><br />
               <div>
                   <label for="txtHasDriverLicense">has driver license</label><br /><input id="txtHasDriverLicense" type="checkbox" />
               </div><br />
               <input id="btnSave" type="button" value="save" />
           </div>





   <script type="text/ecmascript">

   function redrawChart(){

     $("#people").getOrgChart({
       primaryColumns: ["name"],

       editable: true,
       zoomable: true,
       searchable: false,
       printable: false,
       movable: true,
       scale: true,
       gridView: true,
       theme: "cassandra",
       color: "blue",
       orientation: 0,
       linkType: "M",
       levelSeparation: 100,
       siblingSeparation: 30,
       subtreeSeparation: 100,
       enableEdit: false,
       enableDetailsView: false,
       clickEvent: function(sender, args) {alert("deleting person with id: " + args.id);},
       updatedEvent: function () {
    init();
},


    //   removeEvent: function(sender, args) {log("deleting person with id: " + args.id); return true; },
    //   updateEvent: function(sender, args) {log("updating person with id: " + args.id); return true; },
    //   renderBoxContentEvent: function(sender, args) {log("render content box with id: " + args.id); },
    //   clickEvent: function(sender, args) {log("clicked person with id: " + args.id); return true; },

       dataSource: [
/*         { id: 1, parentId: "", name: "Mary D. Barnes", title: "Founder", phone: "765-386-5597", image: "images/f-57.jpg" },
         { id: 2, parentId: 1, name: "Larry B. Welborn", title: "Podiatrist", phone: "516-922-7920", image: "images/f-56.jpg" },
         { id: 3, parentId: 1, name: "John D. Blakely", title: "Ballet master", phone: "617-361-4327", mail: "john.blakely@dom.com" },
         { id: 4, parentId: 2, name: "Megan F. Borg", title: "Botanist", phone: "205-324-9284", image: "images/f-54.jpg" },
         { id: 5, parentId: 2, name: "Kyle E. Christensen", title: "Animal control officer", phone: "702-486-3752", image: "images/f-53.jpg" },
         { id: 6, parentId: 3, name: "Luther L. Myers", title: "Log sorter", phone: "949-599-1120", image: "images/f-52.jpg" },
         { id: 7, parentId: 3, name: "Ruth J. Christopher", title: "Certified athletic", phone: "256-759-3427", image: "images/f-51.jpg" }
*/
         { id: 1, parentId: null, name: "Jefe", CustomHtml: "<div>DIV</div>" },
          { id: 2, parentId: 1, name: "supervisor", CustomHtml: "<image style='width: 100px;' src='https://s-media-cache-ak0.pinimg.com/736x/e0/c8/1b/e0c81b6fc2eb7d3f5f8ab57e593a6861.jpg' />" },
          { id: 3, parentId: 1, name: "ejecutivo" }
       ]
     });

   }

   redrawChart();


  /* $("#dialog").dialog({
       modal: true,
       autoOpen: false,
       show: {
           effect: "explode",
           duration: 200
       },
       hide: {
           effect: "explode",
           duration: 200
       }
   });*/

   var btnAdd = '<g data-action="add" class="btn" transform="matrix(0.14,0,0,0.14,0,0)"><rect style="opacity:0" x="0" y="0" height="300" width="300" /><path  fill="#686868" d="M149.996,0C67.157,0,0.001,67.158,0.001,149.997c0,82.837,67.156,150,149.995,150s150-67.163,150-150 C299.996,67.156,232.835,0,149.996,0z M149.996,59.147c25.031,0,45.326,20.292,45.326,45.325 c0,25.036-20.292,45.328-45.326,45.328s-45.325-20.292-45.325-45.328C104.671,79.439,124.965,59.147,149.996,59.147z M168.692,212.557h-0.001v16.41v2.028h-18.264h-0.864H83.86c0-44.674,24.302-60.571,40.245-74.843 c7.724,4.15,16.532,6.531,25.892,6.601c9.358-0.07,18.168-2.451,25.887-6.601c7.143,6.393,15.953,13.121,23.511,22.606h-7.275 v10.374v13.051h-13.054h-10.374V212.557z M218.902,228.967v23.425h-16.41v-23.425h-23.428v-16.41h23.428v-23.425H218.9v23.425 h23.423v16.41H218.902z"/></g>';
   var btnEdit = '<g data-action="edit" class="btn" transform="matrix(0.14,0,0,0.14,50,0)"><rect style="opacity:0" x="0" y="0" height="300" width="300" /><path fill="#686868" d="M149.996,0C67.157,0,0.001,67.161,0.001,149.997S67.157,300,149.996,300s150.003-67.163,150.003-150.003 S232.835,0,149.996,0z M221.302,107.945l-14.247,14.247l-29.001-28.999l-11.002,11.002l29.001,29.001l-71.132,71.126 l-28.999-28.996L84.92,186.328l28.999,28.999l-7.088,7.088l-0.135-0.135c-0.786,1.294-2.064,2.238-3.582,2.575l-27.043,6.03 c-0.405,0.091-0.817,0.135-1.224,0.135c-1.476,0-2.91-0.581-3.973-1.647c-1.364-1.359-1.932-3.322-1.512-5.203l6.027-27.035 c0.34-1.517,1.286-2.798,2.578-3.582l-0.137-0.137L192.3,78.941c1.678-1.675,4.404-1.675,6.082,0.005l22.922,22.917 C222.982,103.541,222.982,106.267,221.302,107.945z"/></g>';
   var btnDel = '<g data-action="delete" class="btn" transform="matrix(0.14,0,0,0.14,100,0)"><rect style="opacity:0" x="0" y="0" height="300" width="300" /><path fill="#686868" d="M112.782,205.804c10.644,7.166,23.449,11.355,37.218,11.355c36.837,0,66.808-29.971,66.808-66.808 c0-13.769-4.189-26.574-11.355-37.218L112.782,205.804z"/> <path stroke="#686868" fill="#686868" d="M150,83.542c-36.839,0-66.808,29.969-66.808,66.808c0,15.595,5.384,29.946,14.374,41.326l93.758-93.758 C179.946,88.926,165.595,83.542,150,83.542z"/><path stroke="#686868" fill="#686868" d="M149.997,0C67.158,0,0.003,67.161,0.003,149.997S67.158,300,149.997,300s150-67.163,150-150.003S232.837,0,149.997,0z M150,237.907c-48.28,0-87.557-39.28-87.557-87.557c0-48.28,39.277-87.557,87.557-87.557c48.277,0,87.557,39.277,87.557,87.557 C237.557,198.627,198.277,237.907,150,237.907z"/></g>';

   getOrgChart.themes.cassandra.box += '<g transform="matrix(1,0,0,1,350,10)">'
           + btnAdd
           + btnEdit
           + btnDel
           + '</g>';



   function getNodeByClickedBtn(el) {
             while (el.parentNode) {
                 el = el.parentNode;
                 if (el.getAttribute("data-node-id"))
                     return el;
             }
             return null;
         }

         var init = function () {
             var btns = document.getElementsByClassName("btn");
             for (var i = 0; i < btns.length; i++) {

                 btns[i].addEventListener("click", function () {
                     var nodeElement = getNodeByClickedBtn(this);
                     var action = this.getAttribute("data-action");
                     var id = nodeElement.getAttribute("data-node-id");
                     var node = orgChart.nodes[id];

                     switch (action) {
                         case "add":
                             orgChart.insertNode(id);
                             break;
                         case "edit":
                             document.getElementById("hdnId").value = node.id;
                             document.getElementById("txtName").value = node.data.name ? node.data.name : "";
                             document.getElementById("txtTitle").value = node.data.title ? node.data.title : "";
                             document.getElementById("txtMail").value = node.data.mail ? node.data.mail : "";
                             document.getElementById("txtCar").value = node.data.car ? node.data.car : "";
                             document.getElementById("txtHasDriverLicense").value = node.data.hasDriverLicense ? node.data.hasDriverLicense : "";
                             $("#dialog").dialog("open");
                             break;
                         case "delete":
                             orgChart.removeNode(id);
                             break;
                     }
                 });
             }
         }
         init();

         document.getElementById("btnSave").addEventListener("click", function () {
             var node = orgChart.nodes[document.getElementById("hdnId").value];
             node.data.name = document.getElementById("txtName").value;
             node.data.title = document.getElementById("txtTitle").value;
             node.data.mail = document.getElementById("txtMail").value;
             node.data.car = document.getElementById("txtCar").value;
             node.data.hasDriverLicense = document.getElementById("txtHasDriverLicense").value;
             orgChart.updateNode(node.id, node.pid, node.data);
             $("#dialog").dialog("close");
         });



/*
   function log(message){
     var d = new Date();
     var time = d.getHours();
     time += ":" + d.getMinutes();
     time += ":" + d.getSeconds() + " - ";
     document.getElementById("eventConsole").innerHTML =  time + message + "<br />" + document.getElementById("eventConsole").innerHTML;
   }

   $(".arrow-left, .arrow-right").click(function() {
     var inc = parseFloat($(this).attr("inc"));
     var $inp = $(this).parent().find("input");
     var val = parseFloat($inp.val());
     var def = parseFloat($inp.attr("def"));
     var min = parseFloat($inp.attr("min"));

     if (!$.isNumeric(val))
       $inp.val(def);
     else if (val > min)
       $inp.val(Math.round((val + inc) * 100) / 100);
     redrawChart();
   });
*/
   </script>



@stop
