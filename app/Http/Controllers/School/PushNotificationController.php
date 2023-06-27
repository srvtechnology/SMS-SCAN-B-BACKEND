<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\PushNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PushNotificationController extends Controller
{
    public function index()
    {
        $push_notifications = PushNotification::all();
        return view('school.push-notifications.index', compact('push_notifications'));
    }
    public function create()
    {
        return view('school.push-notifications.create');
    }
    public function edit($id)
    {
        $push_notification = PushNotification::where('id', $id)->first();
        $types = json_decode($push_notification->type);
        return view('school.push-notifications.edit', compact('push_notification','types'));
    }
    public function view($id)
    {
        $push_notification = PushNotification::where('id', $id)->first();
        return view('school.push-notifications.view', compact('push_notification'));
    }
    public function save(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nofication_type' => 'required',
            'title' => 'required',
            'message' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->with(['errors' => $validator->errors()]);
        } else {
            $type = json_encode($request->nofication_type);
            $notification = new PushNotification();
            $notification->type = $type;
            $notification->title = $request->title;
            $notification->message = $request->message;
            $notification->save();
            if ($notification) {
                return to_route("school.notification-index")->with('success', 'Notification Added Successfully!');
            } else {
                return back()->with('error', 'Something went Wrong!');
            }
        }
    }
    public function destroy(Request $request)
    {
        $push_notification = PushNotification::find($request->id);
        $push_notification->delete();

        return redirect()->route('school.notification-index')->with('success', 'Notification Deleted Successfully!');
    }
    public function update(Request $request)
    {
        $type = json_encode($request->nofication_type);
        $notification = PushNotification::find($request->id);
        $notification->type = $type;
        $notification->title = $request->title;
        $notification->message = $request->message;
        $notification->save();

        if ($notification) {
            return redirect()->route('school.notification-index')->with('success', 'Notification Updated Successfully!');
        } else {
            return back()->with('message', 'Something went wrong!');
        }
    }
}
