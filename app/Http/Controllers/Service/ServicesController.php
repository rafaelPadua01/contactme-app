<?php

namespace App\Http\Controllers\Service;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\User;
use App\Models\AppointmentBook;

class ServicesController extends Controller {
    private $service;

    public function __construct(Service $services){ 
        $this->service = $services;
    }
    public function index($id){
        $service = Service::where('appointment_id', '=', $id)
        ->join('profile_images', 'profile_images.user_id', '=', 'services.client_id')
        ->join('chats', 'chats.sender_id', '=', 'services.client_id')
        ->get([
            'services.*',
            'profile_images.image_name',
            'chats.id as chat_id'
        ]);
        
        return \Response::json($service);
       
    }
    public function create(Request $request, $id){
        $appointment_book = AppointmentBook::where('id', "=", $request->appointment_id)->first();
        $marked_hour = $request->marked_hour;
        $client_id = \Auth::id();
        try{
            if($appointment_book->inital_hour <= $marked_hour && $appointment_book->close_hour >= $marked_hour){
                $insert_db = Service::create([
                    'client_name' => $request->client_name,
                    'marked_day' => $request->marked_day,
                    'marked_hour' => $request->marked_hour,
                    'marked_service' => $request->marked_service,
                    'note' => $request->note,
                    'user_id' => $id,
                    'client_id' => $client_id,
                    'appointment_id' => $request->appointment_id
                ]);
                return $insert_db;
            }
            
            return \Response::json($insert_db);
        }
        catch(Exception $e){
            return \Response::json($e);
        }
       
    }
    public function alterStatus($id){
        try{
            $client = Service::where('id', '=', $id)->update(['status' => true]);
            $response = 'Atendimento Confirmado.';
            return \Response::json($client);
        }
        catch(Exception $e){
            return \Response::json($e);
        }
    }
    public function dismatchStatus($id){
        try{
            $client = Service::where('id', '=', $id)->update(['status' => false]);
            $response = 'Atendimento negado.';
            return \Response::json($client);
        }
        catch(Exception $e){
            return \Response::json($e);
        }
    }
    public function remove($id){
        try{
            $client = Service::where('id', '=', $id)->delete();
            return \Response::json($client);
        }
        catch(Exception $e){
            return \Response::json($e);
        }
    }
}
