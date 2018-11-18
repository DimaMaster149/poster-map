<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use DateTime;
use App\Event;
use App\State;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image as Image;

class AdminEventController extends Controller
{
	//Все опубликованные события
	public function publishedAdminEvents() {
		$publishedEvents = Event::where('event_state', 1)->orderby('event_id')->get();
		return response()->json($publishedEvents);
	}

	//Для опубликованных событий
	public function publishedAdminEventsEdit($id) {
		$publishedEvent = Event::find($id);
		return response()->json($publishedEvent);
	}

	public function publishedAdminEventsUpdate(Request $request, $id) {
		$file = $request->file('event_image'); //?
		$extension = $file->getClientOriginalName();
		//$fileName = time().'_'.$extension;
		$fileName = $extension;
		$resizedImage = Image::make($file)->resize(640,480);
		$resizedImage->save('images/'.$fileName);
		$userId = Auth::user()->id;

		Event::where('event_id', $id)->update([
			'event_title' =>  $request->input('event_title'),
			'event_description' => $request->input('event_description'),
			'event_state' => 1,
			'event_user' => $userId,
			'event_image' =>$fileName,
			'event_date' => $request->input('event_date'),
			'event_time' => $request->input('event_time'),
			'event_location' => $request->input('event_location'),
		]);
		return redirect('/home');
	}

	//удаление опубликованных событий администратором
	public function publishedAdminEventsDelete($id){
		try{
			Event::destroy($id);
			return response([], 204);
		} catch(\Exception $e){
			return response(['Deleting error', 500]);
		}
	}

	//Все предложенные события
	public function proposedAdminEvents() {
		$proposedEvents = Event::where('event_state', 2)->orderby('event_id')->get();
		return response()->json($proposedEvents);
	}

	//добавление опубликованных событий и обновление предложенных как опубликованных
	public function publishedAdminEventsStore(Request $request) {
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
					'event_state' => 1,
					'event_user' => $userId,
					'event_image' =>$fileName,
					'event_date' => $request->input('event_date'),
					'event_time' => $request->input('event_time'),
					'event_location' => $request->input('event_location'),
					'event_lat' => $request->event_lat,
					'event_long' => $request->event_long,
				]);
				$publishedUpdateEvent = new Event();
				$publishedUpdateEvent->event_id = $eventId;
				$publishedUpdateEvent->event_title = $request->input('event_title');
				$publishedUpdateEvent->event_description = $request->input('event_description');
				$publishedUpdateEvent->event_state =  2;
				$publishedUpdateEvent->event_user = $userId;
				$publishedUpdateEvent->event_image = $fileName;
				$publishedUpdateEvent->event_date =  $request->input('event_date');
				$publishedUpdateEvent->event_time = $request->input('event_time');
				$publishedUpdateEvent->event_location = $request->input('event_location');
				return response()->json($publishedUpdateEvent);
				}
				else{
				Event::where('event_id', $eventId)->update([
					'event_title' =>  $request->input('event_title'),
					'event_description' => $request->input('event_description'),
					'event_state' => 1,
					'event_user' => $userId,
					'event_date' => $request->input('event_date'),
					'event_time' => $request->input('event_time'),
					'event_location' => $request->input('event_location'),
					'event_lat' => $request->event_lat,
					'event_long' => $request->event_long,
				]);
				$publishedUpdateEvent = new Event();
				$publishedUpdateEvent->event_id = $eventId;
				$publishedUpdateEvent->event_title = $request->input('event_title');
				$publishedUpdateEvent->event_description = $request->input('event_description');
				$publishedUpdateEvent->event_state =  2;
				$publishedUpdateEvent->event_image = $originalImage;
				$publishedUpdateEvent->event_user = $userId;
				$publishedUpdateEvent->event_date =  $request->input('event_date');
				$publishedUpdateEvent->event_time = $request->input('event_time');
				$publishedUpdateEvent->event_location = $request->input('event_location');
				return response()->json($publishedUpdateEvent);
			}
		}else{
			$publishedEvent = new Event($request->all());
			$publishedEvent->event_image=$fileName;
			$publishedEvent->event_user = $userId;
			$publishedEvent->event_state=1;
			$publishedEvent->event_lat=$request->event_lat;
			$publishedEvent->event_long=$request->event_long;
			$publishedEvent->save();
			return response()->json($publishedEvent);
		}
	}

	//При update админом предложенного события, событие становится опубликованным
	public function proposedAdminEventsUpdate(Request $request, $id) {
		$file = $request->file('event_image'); //?
		$extension = $file->getClientOriginalName();
		//$fileName = time().'_'.$extension;
		$fileName = $extension;
		$resizedImage = Image::make($file)->resize(640,480);
		$resizedImage->save('images/'.$fileName);
		$userId = Auth::user()->id;

		Event::where('event_id', $id)->update([
			'event_title' =>  $request->input('event_title'),
			'event_description' => $request->input('event_description'),
			'event_state' => 1,
			'event_user' => $userId,
			'event_image' =>$fileName,
			'event_date' => $request->input('event_date'),
			'event_time' => $request->input('event_time'),
			'event_location' => $request->input('event_location'),
		]);
		return redirect('/home');
	}

	//Добавление админом события без редактирования, сразу в просмотре всего списка
	public function proposedAdminEventsUpdateFromList(Request $request, $id) {
		$long = $request[0];
		$lat = $request[1];
		$userId = Auth::user()->id;

		Event::where('event_id', $id)->update([
			'event_state' => 1,
			'event_user' => $userId,
			'event_long' => $long,
			'event_lat' => $lat,
		]);
		return redirect('/home');
	}

	//удаление предложенных событий администратором
	public function proposedAdminEventsDelete($id){
		try{
			Event::destroy($id);
			return response([], 204);
		} catch(\Exception $e){
			return response(['Deleting error', 500]);
		}
	}
}