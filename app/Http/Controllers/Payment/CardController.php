<?php

namespace App\Http\Controllers\Payment;

use App\Http\Requests\Payment\UpdateCardRequest;
use App\Http\Resources\CardResource;
use App\Models\User;
use Illuminate\Contracts\Auth\Authenticatable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use Laravel\Cashier\Card;
use Stripe\Error\InvalidRequest;

class CardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param User $user
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Authenticatable $user)
    {
        $user->updateCardFromStripe();
        $cards = $user->cards()->map(function (Card $card) {
            return $card->asStripeCard();
        });
        return CardResource::collection($cards);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param User $user
     * @param UpdateCardRequest $request
     * @return void
     */
    public function store(Authenticatable $user, UpdateCardRequest $request)
    {
        try {
            $user->updateCard($request->input("stripeToken"));
        } catch (InvalidRequest $e) {
            return response()->json(["success" => false, "data" => ["Token doesn't exist"]]);
        }
        return response()->json(["success" => true, "data" => []]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param User $user
     * @param int $id
     * @return Response
     */
    public function update(Authenticatable $user, $id)
    {
        $stripeUser = $user->asStripeCustomer();
        try {
            $stripeUser->default_source = $id;
            $stripeUser->save();
        } catch (InvalidRequest $e) {
            return response()->json(["success" => false, "data" => ["Card doesn't exist"]]);
        }
        return response()->json(["success" => true, "data" => []]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Authenticatable $user, $id)
    {
        try {
            $card = $user->cards()->filter(function (Card $card) use ($id) {
                return $card->asStripeCard()->id == $id;
            })->first();
            if($card === null) {
                throw new \Exception("Card doesn't exist");
            }
            $card->delete();
        } catch (\Throwable $e) {
            return response()->json(["success" => false, "data" => [$e->getMessage()]]);
        }
        return response()->json(["success" => true, "data" => []]);
    }
}
