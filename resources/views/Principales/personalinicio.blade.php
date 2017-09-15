@extends('layouts.principal2')

@section('content')
<link charset="utf-8" href="/js/getorgchart/getorgchart.js">



<br>
<center>

@if(Session::has('flash_message'))
<script>
alert ('{{Session::get('flash_message')}}')
</script>
@endif

</center>


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




<div id="people"></div>





<script type="text/ecmascript">

function redrawChart(){
  $("#people").getOrgChart({
    primaryColumns: ["name", "title", "phone", "mail"],
    imageColumn: "image",
    editable: true,
    zoomable: true,
    searchable: true,
    printable: true,
    movable: true,
    scale: true,
    gridView: true,
    theme: "cassandra",
    color: "black",
    orientation: "0",
    linkType: "M",
    levelSeparation: "100",
    siblingSeparation: "30",
    subtreeSeparation: "100",
    removeEvent: function(sender, args) {log("deleting person with id: " + args.id); return true; },
    updateEvent: function(sender, args) {log("updating person with id: " + args.id); return true; },
    renderBoxContentEvent: function(sender, args) {log("render content box with id: " + args.id); },
    clickEvent: function(sender, args) {log("clicked person with id: " + args.id); return true; },
    dataSource: [
      { id: 1, parentId: "", name: "Mary D. Barnes", title: "Founder", phone: "765-386-5597", image: "images/f-57.jpg" },
      { id: 2, parentId: 1, name: "Larry B. Welborn", title: "Podiatrist", phone: "516-922-7920", image: "images/f-56.jpg" },
      { id: 3, parentId: 1, name: "John D. Blakely", title: "Ballet master", phone: "617-361-4327", mail: "john.blakely@dom.com" },
      { id: 4, parentId: 2, name: "Megan F. Borg", title: "Botanist", phone: "205-324-9284", image: "images/f-54.jpg" },
      { id: 5, parentId: 2, name: "Kyle E. Christensen", title: "Animal control officer", phone: "702-486-3752", image: "images/f-53.jpg" },
      { id: 6, parentId: 3, name: "Luther L. Myers", title: "Log sorter", phone: "949-599-1120", image: "images/f-52.jpg" },
      { id: 7, parentId: 3, name: "Ruth J. Christopher", title: "Certified athletic", phone: "256-759-3427", image: "images/f-51.jpg" }
    ]
  });

}

redrawChart();

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

</script>



<?php

 ?>




@stop
