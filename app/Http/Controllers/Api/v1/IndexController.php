<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller
{
    private function moveElement(&$array, $a, $b) {
        $out = array_splice($array, $a, 1);
        array_splice($array, $b, 0, $out);
    }

    public function getPosition(Subscriber $theSubscriber) {
        $subscribers = Subscriber::all()->sortBy('created_at');

        foreach ($subscribers as $subscriber) {
            $subscriber->modifier = $subscribers
                ->where('referrer_id', $subscriber->id)
                ->count();
        }

        $subscribers = $subscribers->toArray();

        foreach ($subscribers as $key => $subscriber) {
            $this->moveElement($subscribers, $key, $key - $subscriber['modifier']);
        }

        dd(collect($subscribers)->where('id', 7));

        return collect($subscribers)->firstWhere('id', $theSubscriber->id);
    }

    public function index(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email|unique:subscribers,email',
            'referrer' => 'string|exists:subscribers,id',
        ]);

        $subscriber = new Subscriber();
        $subscriber->email = $data['email'];


        dd($this->getPosition($subscriber));

        $subscriber->save();

        if (isset($data['referrer'])) {
//            $referrer = $flight = Subscriber::find($data['referrer']);
//            $referrer->position = $referrer->position + 10;
//            $referrer->save();
            $subscriber->referrer = $data['referrer'];
        }

        return response()->json([
            'id' => $subscriber->id,
            'position' => Subscriber::count(),
        ], Response::HTTP_CREATED);
    }
}
