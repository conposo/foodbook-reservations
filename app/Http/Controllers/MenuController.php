<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Menu;

use App\Traits\ApiResponser;

class MenuController extends Controller
{
    use ApiResponser;

    public function store(Request $request)
    {
        // dd(($request->all()));
        $rules = [
            'dish_id' => 'required|integer|min:1',
        ];
        $this->validate($request, $rules);

        // check if dish_id is not added
        $guest_menu_dish = Menu::where([
            ['guest_id', '=', $request['guest_id']],
            ['dish_id', '=', $request['dish_id']],
            ['status', '<>', 'done'],
        ])->first();
        // dd($guest_menu_dish);
        if(is_null($guest_menu_dish))
        {
            $new_menu = Menu::create([
                'guest_id' => $request['guest_id'],
                'dish_id' => $request['dish_id'],
                'status' => 'pending',
            ]);
            return $this->successResponse($new_menu, Response::HTTP_CREATED);
        }
        else
        {
            // maybe update dish quantity
        }
        return $this->successResponse($guest_menu_dish, Response::HTTP_OK);
        // $menu = Menu::create($request->all());
        // return $this->successResponse($menu, Response::HTTP_OK);
    }

    public function update(Request $request)
    {
        $guest_menu_dish = Menu::where([
            ['id', '=', $request['id']],
        ])->first();

        if($guest_menu_dish)
        {
            $guest_menu_dish->fill($request->except('id'));
            if($guest_menu_dish->isClean())
            {
                return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
            }
            $guest_menu_dish->save();
        }
        return $this->successResponse($guest_menu_dish, Response::HTTP_OK);
    }

    public function destroy(Request $request)
    {
        $guest_menu_dish = Menu::where([
            ['guest_id', '=', $request['guest_id']],
            ['dish_id', '=', $request['dish_id']],
            ['status', '<>', 'done'],
        ])->first();
        if($guest_menu_dish)
        {
            $guest_menu_dish->delete();
        }
        return $this->successResponse($guest_menu_dish, Response::HTTP_OK);
    }
}
