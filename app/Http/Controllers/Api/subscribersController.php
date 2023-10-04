<?php

namespace App\Http\Controllers\Api;

use App\Models\Blog;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SubscriberRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class subscribersController extends Controller
{
    public function displayAllSubscribers() {
    $users = User::all();
    return response()->json([
        'message' => 'Users List',
        'data' => $users
    ], 200);
    }

    public function updateSubscriber(SubscriberRequest $request,$id) {

    $subscriber = User::find($id);

    if (!$subscriber) {
        return response()->json(['message' =>'No subscriber found'],
         404);
    }

    if ($request->input('email') !== $subscriber->email) {
        $request->validate([
            'email' => 'required|string|unique:users',
        ]);
    }
    $subscriber->update($request->all());

    return response()->json(['message' => 'The subscriber has been updated successfully'],
     200);
    }



    public function deleteSubscriber($id) {
    $subscriber = User::find($id);

    if (!$subscriber) {
        return response()->json(['message' => 'No subscriber found'], 404);
    }

    $subscriber->delete();

    return response()->json(['message' => 'The subscriber has been soft-deleted successfully'],
     200);
    }


   public function trash() {
    $Subscribers = User::onlyTrashed()->paginate();
    return response()->json(['Subscribers' => $Subscribers]);
    }


    public function restore($id) {
     try {
        $subscriber = User::onlyTrashed()->findOrFail($id);
        $subscriber->restore();
        return response()->json(['message' => 'Subscriber restored!']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Subscriber not found'], 404);
        }
    }

    public function forceDelete($id) {
     try {
        $subscriber = User::onlyTrashed()->findOrFail($id);
        $subscriber->forceDelete();
        return response()->json(['message' => 'Subscriber deleted!']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Subscriber not found'], 404);
        }
    }

    public function filter() {
       try {
        // $data = User::where('name', $request->input('name'))->firstOrFail();
        $request = request();
        $data = User::
        filter($request->query())
       ->firstOrFail();
        return response()->json([
            'data' => $data
        ], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'User not found'], 404);
        }
    }

}
