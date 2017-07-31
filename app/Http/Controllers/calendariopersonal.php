<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EventModel;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;

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

$events[] = \Calendar::event(
   'Primer Evento', //event title
   false, //full day event?
   '2017-07-27T0800', //start time (you can also use Carbon instead of DateTime)
   '2017-07-28T1200', //end time (you can also use Carbon instead of DateTime)
 0 //optionally, you can specify an event ID
);

$events[] = \Calendar::event(
   "Fin de mes", //event title
   true, //full day event?
   new \DateTime('2017-07-31'), //start time (you can also use Carbon instead of DateTime)
   new \DateTime('2017-07-31'), //end time (you can also use Carbon instead of DateTime)
 'stringEventId' //optionally, you can specify an event ID
);



$eloquentEvent = EventModel::first(); //EventModel implements MaddHatter\LaravelFullcalendar\Event



$calendar = \Calendar::addEvents($events) //add an array with addEvents
   ->addEvent($eloquentEvent, [ //set custom color fo this event
       'color' => '#800',
   ])->setOptions([ //set fullcalendar options
   'firstDay' => 1
 ])->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
   'eventClick' => 'function(calEvent, jsEvent, view) {
    alert("Hello world!");
}'
   ]);

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
