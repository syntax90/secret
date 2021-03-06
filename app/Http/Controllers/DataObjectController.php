<?php

namespace App\Http\Controllers;

use App\DataObject;
use App\DataObjectHistory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DataObjectController extends Controller
{
    public function index() {
        return response()->json(DataObject::all());
    }

    public function historyIndex() {
        return response()->json(DataObjectHistory::all());
    }

    public function show($key)
    {
        $timestamp = request()->input('timestamp');
        if ($timestamp) {
            $convertedTimestamp = Carbon::createFromTimestamp($timestamp);
            $record = DataObjectHistory::where('key', $key)->whereDate('created_at', '=', $convertedTimestamp)->first();
        } else {
            $record = DataObject::where('key', $key)->first();
        }
        if ($record) {
            return json_encode($record->value);
            // return response()->json($record->value)->setStatusCode(200);
        } else {
            return response()->json(['message' => 'Resource not found.'])->setStatusCode(404);
        }
    }

    public function post(Request $request)
    {
        $key = array_key_first($request->all());
        $value = $request->$key;

        // if key exists, update value
        $object = DataObject::where('key', $key)->first();
        if ($object) {
            $object->value = $value;
            $object->revision = $object->revision + 1;
            $object->save();
            $statusCode = 200;
        } else {
            // else create new record
            $object = DataObject::create([
                'key' => $key,
                'value' => $value,
            ]);
            $statusCode = 201;
        }
        $timestampNum = strtotime($object->created_at);
        return response()->json(['message' => 'Resource saved successfully.', 'timestamp' => $timestampNum])->setStatusCode($statusCode);
    }
}
