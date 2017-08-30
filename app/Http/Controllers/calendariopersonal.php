<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventModel;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;


use App\Models\User;
use App\Models\lista_eventos;
use Carbon\Carbon;
use Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;


class calendariopersonal extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

      $events = [];
      $options = [];

$allevents = EventModel::all();
//return(dd($allevents));

    foreach ($allevents as $event) {
        $events[] = \Calendar::event(
            $event->title,
            $event->all_day,
            new \DateTime($event->start),
            new \DateTime($event->end),
            $event->id,
            $options= ['url'=>$event->url,
                       'editable'=>$event->editable,
                       'color'=>$event->color]
         );

         }


  $calendar = \Calendar::addEvents($events) //add an array with addEvents
   ->setOptions(
     [//set fullcalendar options
     'firstDay' => 1]
     );

/*
     alert("Clicked on: " + date.format());

     alert("Coordinates: " + jsEvent.pageX + "," + jsEvent.pageY);

     alert("Current view: " + view.name);
     alert("Resource ID: " + resourceObj.id);
*/

$calendar = \Calendar::setCallbacks([
    'eventClick' => 'function(calEvent, jsEvent, view) {
     alert("Hello world");
     alert("Resource ID: " + resourceObj.id);
 }',

 'dayClick' => 'function(date, jsEvent, view) {
    alert("Hello world");
 }',

 'eventMouseover' => 'function(calevent, jsEvent, view) {
  $(this).css("color", "black");
  $(this).css("font-weight", "bolder");
}',

'eventMouseout' => 'function(calevent, jsEvent, view) {
 $(this).css("color", "white");
 $(this).css("font-weight", "normal");
}',


     ]);

/*
    $calendar->setCallbacks([
        'dayClick' => 'function(date, jsEvent, view) {
          alert('Clicked on: ' + date.format());

          alert('Coordinates: ' + jsEvent.pageX + ',' + jsEvent.pageY);

          alert('Current view: ' + view.name);

          // change the day's background color just for fun
          $(this).css('background-color', 'red');
            }'' ]);

*/


/*

$eloquentEvent = EventModel::first(); //EventModel implements MaddHatter\LaravelFullcalendar\Event



$calendar = \Calendar::addEvents($events) //add an array with addEvents
   ->addEvent($eloquentEvent, [ //set custom color fo this event
       'color' => '#800',
   ])->setOptions([ //set fullcalendar options
   'firstDay' => 1
 ])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
   'eventClick' => 'function(calEvent, jsEvent, view) {
    showModal();
}'
   ]);
*/


        //muestra formulario de calendariopersonal
        return view('calendariopersonal', compact('calendar'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        
        $user = Auth::user();
        $Event= new EventModel;
        $Event->title = $request->input('title');
        $Event->all_day = $request->input('all_day');
      //  return(dd(strtotime($request->input('start'))));
      //2017-08-02T19:01
      //  echo date ( 'Y-m-d\TH:i' , time()  )
        $Event->start = strtotime($request->input('start'));
        $Event->end = strtotime($request->input('end'));

        $Event->url = '';
        $Event->editable = '1';
        $Event->color = $request->input('color');
        $Event->Descripcion = $request->input('descripcion');

        $Event->save();

        session()->flash('flash_msg',"Se creó una nueva entrada en la agenda");
        session()->flash('flash_type','warning');
        $acces=$request->input('listaAreasSeleccionadas');

        for ($i=0;$i<count($acces);$i++)
        {
        $acce = new lista_eventos;
        $acce ->id_area = $acces[$i];
        $acce ->id_evento = $Event->id;
        $acce ->save();
        }

return Redirect('/bienvenida');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
