<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

use App\Guest;
use App\Reservation;

use App\Traits\ApiResponser;

class GuestController extends Controller
{
    use ApiResponser;

    public function index($reservation_id, $id)
    {
        $guest = Guest::where('reservation_id', $reservation_id)->with('menu')->findOrFail($id)->toArray();

        return $this->successResponse($guest, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $guest_id = $request->guest_id;
        $reservation_id = $request->reservation_id;

        // check if user_id is added
        if($request->user_id)
        {
            $guest = Guest::where([
                ['user_id', '=', $request->user_id],
                ['reservation_id', '=', $reservation_id]
            ])->first();
            if($guest)
                return $this->successResponse(['message' => 'Guest already exist!'], Response::HTTP_OK);
        }

        // check if guest is not added
        $guest = Guest::where([
            ['guest_order`', '=', $guest_id],
            ['reservation_id', '=', $reservation_id]
        ])->first();

        if( is_null($guest) )
        {
            $guest = Guest::create($request->all());
            // Todo update total guests
            return $this->successResponse($guest, Response::HTTP_CREATED);
        }
        else
        {
            return $this->successResponse(['message' => 'Guest already exist!'], Response::HTTP_OK);
        }
    }

    public function update(Request $request, $id)
    {
        $guest = Guest::findOrFail($id);
        $guest->fill($request->all());

        if($guest->isClean())
        {
            return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $guest->save();

        return $this->successResponse($guest);
    }

    public function destroy($id)
    {
        $guest = Guest::findOrFail($id);
        $guest->delete();
        // Todo update total guests
        $reservation = Reservation::findOrFail($guest->reservation_id);
        $reservation->update(['total_guests' => ($reservation->total_guests -1)]);
        return $this->successResponse($guest);
    }

}
