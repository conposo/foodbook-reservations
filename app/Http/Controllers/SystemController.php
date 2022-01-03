<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Reservation;
use App\Menu;
use App\Guest;

use App\Traits\ApiResponser;

class SystemController extends Controller
{
    use ApiResponser;

    public function allReservations()
    {
        $reservation = Reservation::with('guests')->get();
        return $this->successResponse($reservation, Response::HTTP_OK);
    }

    public function allGuests()
    {
        $guests = Guest::all();
        return $this->successResponse($guests, Response::HTTP_OK);
    }

    public function guest($id)
    {
        $guest = Guest::findOrFail($id);
        return $this->successResponse($guest, Response::HTTP_OK);
    }

    public function allMenus()
    {
        $menus = Menu::all();
        return $this->successResponse($menus, Response::HTTP_OK);
    }

}
