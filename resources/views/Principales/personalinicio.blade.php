@extends('layouts.principal2')

@section('content')


<title>jQuery orgChart Plugin Demo</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="/js/Create-An-Editable-Organization-Chart-with-jQuery-orgChart-Plugin/jquerysctipttop.css" rel="stylesheet" type="text/css">
<link href="/js/Create-An-Editable-Organization-Chart-with-jQuery-orgChart-Plugin/jquery.orgchart.css" media="all" rel="stylesheet" type="text/css" />
<style type="text/css">
#orgChart{
width: auto;
height: auto;
}

#orgChartContainer{
width: 1000px;
height: 500px;
overflow: auto;
background: #eeeeee;
}

</style>





<br>
<center>

@if(Session::has('flash_message'))
<script>
alert ('{{Session::get('flash_message')}}')
</script>
@endif

</center>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header text-center" style="font-weight: bold; text-shadow: 1px 1px #222; color:#0070B0;font-family: 'LeagueGothic';word-spacing: 5px; letter-spacing: 2px; border-bottom: none">Modulo personal ogranigrama</h1>
    </div>
</div>

<center><button type="button" class="btnobjetivo" onclick=location="/bienvenida" data-dismiss="modal" id="btnCloseUpload">Regresar</button></center>

<br><br><br><br><br>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-red">
            <div class="panel-heading">

                <button type="button" class="btn btn-green btn-xs" data-toggle="modal" data-target=""><i class="glyphicon glyphicon-upload"></i></button>
            </div>
        </div>
    </div>
</div>


    <div id="orgChartContainer">
      <div id="orgChart"></div>
    </div>
    <div id="consoleOutput">
    </div>
<script src="/js/Create-An-Editable-Organization-Chart-with-jQuery-orgChart-Plugin/jquery-1.11.1.min.js"></script>
    <script type="text/javascript" src="/js/Create-An-Editable-Organization-Chart-with-jQuery-orgChart-Plugin/jquery.orgchart.js"></script>
    <script type="text/javascript">
    var testData = [
        {id: 1, name: 'My Organization', parent: 0},
        {id: 2, name: 'CEO Office', parent: 1},
        {id: 3, name: 'Division 1', parent: 1},
        {id: 4, name: 'Division 2', parent: 1},
        {id: 6, name: 'Division 3', parent: 1},
        {id: 7, name: 'Division 4', parent: 1},
        {id: 8, name: 'Division 5', parent: 1},
        {id: 5, name: 'Sub Division', parent: 3},

    ];
    $(function(){
        org_chart = $('#orgChart').orgChart({
            data: testData,
            showControls: true,
            allowEdit: true,
            onAddNode: function(node){
                log('Created new node on node '+node.data.id);
                org_chart.newNode(node.data.id);
            },
            onDeleteNode: function(node){
                log('Deleted node '+node.data.id);
                org_chart.deleteNode(node.data.id);
            },
            onClickNode: function(node){
                log('Clicked node '+node.data.id);
            }

        });
    });

    // just for example purpose
    function log(text){
        $('#consoleOutput').append('<p>'+text+'</p>')
    }
    </script><script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-36251023-1']);
  _gaq.push(['_setDomainName', 'jqueryscript.net']);
  _gaq.push(['_trackPageview']);


</script>



<?php

 ?>




@stop
