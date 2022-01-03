<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Reservation;
// use App\Guest;

use App\Traits\ApiResponser;

class TablesController extends Controller
{
    use ApiResponser;

    public function index($restaurant_id, $date)
    {
        $table_reservation = Reservation::with('guests.menu')->where([
            ['restaurant_id', '=', $restaurant_id],
            ['date', '>=', $date],
            ['status', '=', 'approved'],
        ])->latest('updated_at')->get();
        return $this->successResponse($table_reservation, Response::HTTP_OK);
    }

    public function show($restaurant_id, $table)
    {
        $table_reservation = Reservation::with('guests.menu')->where([
            ['restaurant_id', '=', $restaurant_id],
            ['table', '=', $table],
            ['status', '=', 'approved'],
        ])->latest('updated_at')->first();
        return $this->successResponse($table_reservation, Response::HTTP_OK);
    }

}
