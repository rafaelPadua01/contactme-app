<?php
namespace App\Http\Controllers\AppointmentBook;

use App\Http\Controllers\Controller;
use App\Models\AppointmentBook;
use Illuminate\Http\Request;

class AppointmentBookController extends Controller {
    private $appointment;

    public function __construct(AppointmentBook $appointment){
        $this->appointments = $appointment;
    }
    public function index($id){
        try{
            $appointments = AppointmentBook::where('user_id', '=', $id)
            ->orderBy('id', 'asc')
            ->get();
            return \Response::json($appointments);
        }
        catch(Exception $e){
            return \Response::json($e);
        }
    }
    public function save(Request $request, $id){
        $day_work = $request->day_work;
        try{
            $insert_db = AppointmentBook::create([
                'initial_hour' => $request->initial_hour,
                'close_hour' => $request->close_hour,
                'days_work' => $day_work,
                'user_id' => $id
            ]);
            return \Response::json($insert_db);
        }
        catch(Exception $e){
            return \Response::json($e);
        }
        
    }
    public function update(Request $request, $id){
        try{
            $appointment = AppointmentBook::where('id', '=', $id)->update([
                'days_work' => $request->days_work,
                'initial_hour' => $request->initial_hour,
                'close_hour' => $request->close_hour,
            ]);
            
            return \Response::json($appointment);
        }
        catch(Exception $e){
            return \Response::json($e);
        }
    }
    public function delete($id){
        try{
            $delete = AppointmentBook::findOrFail($id)->delete();
            return \Response::json($delete);
        }
        catch(Exception $e){
            return \Response::json($e);
        }
    }
}