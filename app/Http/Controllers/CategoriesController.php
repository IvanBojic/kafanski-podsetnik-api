<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;

class CategoriesController extends Controller
{

    public function list(Request $request)
    {
        $return = [
            'code' => 200,
            'message' => 'Nema unetih kategorija.',
            'payload' => (object) array(),
            'success' => true,
        ];

        $fields = [
            'categories.id',
            'categories.id_screen',
            'categories.title as categories_title',
            'screens.title as screen_title'
        ];

        $id_screen = $request->id_screen;

        $rows = Categories::select($fields)
            ->where("status", 'on')
            ->where("active", 1);

        if($id_screen) {
            $rows = Categories::select($fields)
                ->rightJoin('screens', 'categories.id_screen', '=', 'screens.id')
                ->where('categories.id_screen', $id_screen)
                ->where('categories.status', 'on')
                ->where('categories.active', 1);
        }

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
            'id_screen'  =>  $request->id_screen,
            'title'  =>  $request->title,
            'status'  =>  $request->status,
        ];
        $rows = Categories::updateOrCreate(['id'  =>  $request->id],$save_data);

        if($request->id){
            $return = [
                'code' => 200,
                'message' => 'Uspešno ste izmenili kategoriju.',
                'payload' => $rows,
                'success' => true,
            ];
        } else {
            $return = [
                'code' => 200,
                'message' => 'Uspešno ste kreirali novi kategoriju.',
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
        $rows = Categories::find($request->id);

        if ($rows){
            $rows->updateOrFail($save_data);
            $return = [
                'code' => 200,
                'message' => 'Uspešno ste uklonili kategoriju.',
                'payload' => $rows,
                'success' => true,
            ];
        } else {
            $return = [
                'code' => 422,
                'message' => 'Trazena kategorija ne postoji.',
                'payload' => (object) array(),
                'success' => false,
            ];
        }

        return Response::json($return)->setStatusCode($return['code']);

    }

}
