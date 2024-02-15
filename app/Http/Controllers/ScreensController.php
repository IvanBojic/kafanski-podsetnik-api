<?php

namespace App\Http\Controllers;

use App\Models\Screens;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class ScreensController extends Controller
{

    public function list(Request $request)
    {
        $return = [
            'code' => 200,
            'message' => 'Nema unetih događaja.',
            'payload' => (object) array(),
            'success' => true,
        ];

        $fields = [
            'id',
            'title'
        ];

        $rows = Screens::select($fields)
            ->where("status", 'on')
            ->where("active", 1);

        $rows = $rows->get();

        if($rows->count()) {
            $return['code'] = 200;
            $return['message'] = '';
            $return['payload'] = $rows->toArray();
            $return['success'] = true;
        }

        return Response::json($return)->setStatusCode($return['code']);
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function insertOrUpdate(Request $request)
    {
        $return = [
            'code' => 200,
            'message' => '',
            'payload' => (object) array(),
            'success' => true,
        ];

        $save_data = [
            'title'  =>  $request->title,
            'status'  =>  $request->status,
        ];
        $rows = Screens::updateOrCreate(['id'  =>  $request->id],$save_data);

        if($request->id){
            $return = [
                'code' => 200,
                'message' => 'Uspešno ste izmenili screen.',
                'payload' => $rows,
                'success' => true,
            ];
        } else {
            $return = [
                'code' => 200,
                'message' => 'Uspešno ste kreirali novi screen.',
                'payload' => $rows,
                'success' => true,
            ];
        }

        return Response::json($return)->setStatusCode($return['code']);

    }


    /**
     * Show the form for delete a resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request)
    {
        $return = [
            'code' => 200,
            'message' => '',
            'payload' => (object) array(),
            'success' => true,
        ];

        $save_data = [
            'status'  =>  'off',
        ];
        $rows = Screens::find($request->id);

        if ($rows){
            $rows->updateOrFail($save_data);
            $return = [
                'code' => 200,
                'message' => 'Uspešno ste uklonili screen.',
                'payload' => $rows,
                'success' => true,
            ];
        } else {
            $return = [
                'code' => 422,
                'message' => 'Trazeni screen ne postoji.',
                'payload' => (object) array(),
                'success' => false,
            ];
        }

        return Response::json($return)->setStatusCode($return['code']);

    }

}
