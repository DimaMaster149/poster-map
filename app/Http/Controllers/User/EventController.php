<?php

namespace App\Http\Controllers\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use DateTime;
use App\Event;
use App\State;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image as Image;
use Carbon\Carbon;

class EventController extends Controller
{
	//Список опубликованных ивентов на сегодня
	public function publishedDailyEvents() {
		$date = new DateTime();
		$publishedEvents = Event::orderby('event_id')->where('event_state', 1)->where('event_date', $date->format('Y-m-d'))->get();
		return response()->json($publishedEvents);
	}
	//Список опубликованных ивентов по выбранной дате
	public function publishedEventsSearch(Request $request) {
		$events = Event::orderby('event_id')->where('event_state', 1)->where('event_date', $request->event_date)->get();
		return response()->json($events);
	}
	//Список предложенных ивентов определенным пользователем
	public function proposedEvents() {
		$userId = Auth::user()->id;
		$proposedEvents = Event::orderby('event_id')->where('event_state', 2)->where('event_user', $userId)->get();
		return response()->json($proposedEvents);
	}
	//Добавление, редактирование и удаление предложенных событий определенным пользователем
	//todo: Добавление без картинки или базовой картинкой
	public function proposedEventsStore(Request $request) {
		$file = $request->file('event_image'); //?
		if($file){
			$extension = $file->getClientOriginalName();
			//$fileName = time().'_'.$extension;
			$fileName = $extension;
			$resizedImage = Image::make($file)->resize(640,480);
			$resizedImage->save('images/'.$fileName);
		}else{
			$fileName = 'default.jpg';
		}

		$userId = Auth::user()->id;
		$eventId = $request->event_id;
		if($eventId){
			$originalImage = Event::where('event_id', $eventId)->first()->event_image;
		}
		if($eventId){
			if($file){
				Event::where('event_id', $eventId)->update([
					'event_title' =>  $request->input('event_title'),
					'event_description' => $request->input('event_description'),
					'event_state' => 2,
					'event_user' => $userId,
					'event_image' =>$fileName,
					'event_date' => $request->input('event_date'),
					'event_time' => $request->input('event_time'),
					'event_location' => $request->input('event_location'),
				]);

				$proposedUpdateEvent = new Event();
				$proposedUpdateEvent->event_id = $eventId;
				$proposedUpdateEvent->event_title = $request->input('event_title');
				$proposedUpdateEvent->event_description = $request->input('event_description');
				$proposedUpdateEvent->event_state =  2;
				$proposedUpdateEvent->event_user = $userId;
				$proposedUpdateEvent->event_image = $fileName;
				$proposedUpdateEvent->event_date =  $request->input('event_date');
				$proposedUpdateEvent->event_time = $request->input('event_time');
				$proposedUpdateEvent->event_location = $request->input('event_location');
				return response()->json($proposedUpdateEvent);
			}else{
				Event::where('event_id', $eventId)->update([
					'event_title' =>  $request->input('event_title'),
					'event_description' => $request->input('event_description'),
					'event_state' => 2,
					'event_user' => $userId,
					'event_date' => $request->input('event_date'),
					'event_time' => $request->input('event_time'),
					'event_location' => $request->input('event_location'),
				]);

				$proposedUpdateEvent = new Event();
				$proposedUpdateEvent->event_id = $eventId;
				$proposedUpdateEvent->event_title = $request->input('event_title');
				$proposedUpdateEvent->event_description = $request->input('event_description');
				$proposedUpdateEvent->event_state =  2;
				$proposedUpdateEvent->event_user = $userId;
				$proposedUpdateEvent->event_image = $originalImage;
				$proposedUpdateEvent->event_date =  $request->input('event_date');
				$proposedUpdateEvent->event_time = $request->input('event_time');
				$proposedUpdateEvent->event_location = $request->input('event_location');
				return response()->json($proposedUpdateEvent);
			}

		}else{
			$proposedEvent = new Event($request->all());
			$proposedEvent->event_image=$fileName;
			$proposedEvent->event_user = $userId;
			$proposedEvent->event_state=2;
			$proposedEvent->save();
			return response()->json($proposedEvent);
		}
	}


	public function proposedEventsDelete($id){
		try{
			Event::destroy($id);
			return response([], 204);
		} catch(\Exception $e){
			return response(['Deleting error', 500]);
		}
	}
}