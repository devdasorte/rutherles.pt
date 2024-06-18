<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\GoogleCalendar\Event as GoogleEvent;

class EventController extends Controller
{
    public static $colorCode = [
        1 => 'event-warning',
        2 => 'event-secondary',
        3 => 'event-info',
        4 => 'event-danger',
        5 => 'event-dark',
        6 => 'event-info',
        7 => 'event-success',
    ];

    public function index()
    {
        if (\Auth::user()->can('manage-event')) {
            $user   = Auth::user();
            $date   = Carbon::now();
            $events = Event::all();
            if ($user->type != 'Admin') {
                $events = Event::where('user', 'LIKE', '%,' . $user->id . ',%')
                    ->orWhere('user', 'LIKE', $user->id . ',%')
                    ->orWhere('user', 'LIKE', '%,' . $user->id)
                    ->orWhere('user', 'LIKE', '%' . $user->id . '%')
                    ->get();
            }
            $transdate              = $date->format('Y-m-d');
            $todayDate             = $date->format('m');
            $currentMonthEvents    = Event::select('id', 'start_date', 'end_date', 'title', 'created_at', 'color')
                ->whereRaw('MONTH(start_date)=' . $todayDate)->whereRaw('MONTH(end_date)=' . $todayDate)->get();
            $arrEvents  = [];
            foreach ($events as $event) {
                $arr['id']        = $event['id'];
                $arr['title']     = $event['title'];
                $arr['start']     = $event['start_date'];
                $arr['end']       = $event['end_date'];
                $arr['className'] = $event['color'];
                $arr['url']       = route('event.edit', $event['id']);
                $arrEvents[]      = $arr;
            }
            $arrEvents  = str_replace('"[', '[', str_replace(']"', ']', json_encode($arrEvents)));
            return view('admin.event.index', compact('arrEvents', 'transdate', 'events', 'currentMonthEvents'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function getEventData(Request $request)
    {
        $arrayJson  = [];
        $user       = Auth::user();
        if ($request->get('calenderType') == 'google_calender') {
            $data = GoogleEvent::get();
            $type = 1;
            foreach ($data as $val) {
                $endDate   = Carbon::parse($val->endDateTime)->addDay();
                if ($val->colorId == $type) {
                    $arrayJson[] = [
                        "id"        => $val->id,
                        "title"     => $val->summary,
                        "start"     => $val->startDateTime,
                        "end"       => $endDate->format('Y-m-d H:i:s'),
                        "className" => Self::$colorCode[$type],
                        "allDay"    => true,
                    ];
                }
            }
            return $arrayJson;
        } else {
            $data       = Event::all();
            if ($user->type != 'Admin') {
                $data   = Event::where('user', 'LIKE', '%,' . $user->id . ',%')
                    ->orWhere('user', 'LIKE', $user->id . ',%')
                    ->orWhere('user', 'LIKE', '%,' . $user->id)
                    ->orWhere('user', 'LIKE', '%' . $user->id . '%')
                    ->get();
            }
            foreach ($data as $val) {
                $endDate        = Carbon::parse($val->end_date)->addDay();
                $arrayJson[]    = [
                    "id"         => $val->id,
                    "title"      => $val->title,
                    "start"      => $val->start_date,
                    "end"        => $endDate->format('Y-m-d H:i:s'),
                    "className"  => $val->color,
                    'url'        => route('event.edit', $val['id']),
                    "allDay"     => true,
                ];
            }
        }
        return $arrayJson;
    }

    public function create(Request $request)
    {
        if (\Auth::user()->can('create-event')) {
            $startDate      = Carbon::now()->format('d/m/Y');
            $endDate        = Carbon::now()->format('d/m/Y');
            if ($request->start_date) {
                $startDate  = Carbon::parse($request->start_date)->format('d/m/Y');
            }
            if ($request->end_date) {
                $endDate    = Carbon::parse($request->end_date)->subDay()->format('d/m/Y');
            }
            $users  = User::where('type', '!=', 'Admin')->pluck('name', 'id');
            return view('admin.event.create', compact('users', 'startDate', 'endDate'));
        } else {
            return response()->json(['errors' => __('Permission denied.')]);
        }
    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('create-event')) {
            request()->validate([
                'title'         => 'required|max:50',
                'start_date'    => 'required',
                'end_date'      => 'required',
                'color'         => 'required',
                'user'          => 'required',
            ]);
            $event  = Event::create([
                'title'         => $request->title,
                'start_date'    => Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d'),
                'end_date'      => Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d'),
                'color'         => $request->color,
                'description'   => $request->description,
                'user'          => implode(',', $request->user),
            ]);
            //For Google Calendar
            if ($request->get('synchronize_type')  == 'google_calender') {
                $event                = new GoogleEvent();
                $event->name          = $request->title;
                $event->startDateTime = Carbon::createFromFormat('d/m/Y', $request->start_date)->setTime(0, 0, 0);
                $event->endDateTime   = Carbon::createFromFormat('d/m/Y', $request->end_date)->setTime(23, 59, 59);
                $event->colorId       = 1;
                $event->save();
            }
            return redirect()->route('event.index')->with('success', __('Event successfully created.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function edit($id)
    {
        if (\Auth::user()->can('edit-event')) {
            $event          = Event::find($id);
            $startDate      = Carbon::parse($event->start_date)->format('d/m/Y');
            $endDate        = Carbon::parse($event->end_date)->format('d/m/Y');
            $users          = User::where('type', '!=', 'Admin')->pluck('name', 'id');
            $selectedUsers  = explode(",", $event->user);
            return view('admin.event.edit', compact('event', 'startDate', 'endDate', 'users', 'selectedUsers'));
        } else {
            return response()->json(['errors' => __('Permission denied.')]);
        }
    }

    public function update(Request $request, Event $event)
    {
        if (\Auth::user()->can('edit-event')) {
            request()->validate([
                'title'         => 'required|max:50',
                'start_date'    => 'required',
                'end_date'      => 'required',
                'color'         => 'required',
                'user'          => 'required',
            ]);
            $event->title       = $request->title;
            $event->start_date  = Carbon::createFromFormat('d/m/Y', $request->start_date)->format('Y-m-d');
            $event->end_date    = Carbon::createFromFormat('d/m/Y', $request->end_date)->format('Y-m-d');
            $event->color       = $request->color;
            $event->user        = implode(',', $request->user);
            $event->description = $request->description;
            $event->save();
            return redirect()->route('event.index')->with('success', __('Event successfully updated.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function destroy(Event $event)
    {
        if (\Auth::user()->can('delete-event')) {
            $event->delete();
            return redirect()->route('event.index')->with('success', __('Event successfully deleted.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }
}
