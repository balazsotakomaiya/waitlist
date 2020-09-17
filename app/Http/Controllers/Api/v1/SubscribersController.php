<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SubscribersController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|unique:subscribers,email',
            'referrer' => 'string|exists:subscribers,id',
        ]);

        $subscriber = new Subscriber();
        $subscriber->email = $data['email'];
        $subscriber->save();

        if (isset($data['referrer'])) {
            $subscriber->referrer = $data['referrer'];
        }

        return response()->json([
            'position' => $subscriber->getPosition(),
        ], Response::HTTP_CREATED);
    }

    public function show(Subscriber $subscriber) {
        return response()->json([
            'id' => $subscriber->id,
            'position' => $subscriber->getPosition(),
            'total_subscribers_count' => Subscriber::count(),
        ]);
    }
}
