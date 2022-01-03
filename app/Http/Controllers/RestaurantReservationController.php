<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Reservation;
use App\Guest;

use App\Traits\ApiResponser;

class RestaurantReservationController extends Controller
{
    use ApiResponser;

    public function show($id)
    {
        $reservation = Reservation::with('guests.menu')->findOrFail($id);
        return $this->successResponse($reservation, Response::HTTP_OK);
    }

    public function all($restaurant_id)
    {
        $restaurant_reservations = Reservation::where('restaurant_id', $restaurant_id)->with('guests')->get()->toArray();
        return $this->successResponse($restaurant_reservations, Response::HTTP_OK);

        return $this->successResponse($reservations);
    }

}
