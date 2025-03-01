<?php

namespace App\Http\Controllers;

use App\Http\Requests\TimesheetRequest;
use App\Models\Timesheet;
use Illuminate\Http\Request;



class TimesheetController extends Controller
{
    private $timesheet;

    // Inject the Timesheet model into the controller
    public function __construct(Timesheet $timesheet)
    {
        $this->timesheet = $timesheet;
    }

    // Method to save a new timesheet
    public function saveTimesheet(TimesheetRequest $request)
    {
        // Call the saveTimesheet method from the Timesheet model
        $response_data = $this->timesheet->saveTimesheet($request->all());

        // Return the response data as JSON with the corresponding status code
        return response()->json($response_data, $response_data["status"]);
    }

    // Method to update an existing timesheet
    public function updateTimesheet(int $id, TimesheetRequest $request)
    {
        // Call the updateTimesheet method from the Timesheet model
        $response_data = $this->timesheet->updateTimesheet($id, $request->all());

        // Return the response data as JSON with the corresponding status code
        return response()->json($response_data, $response_data["status"]);
    }

    // Method to fetch a list of timesheets with an optional name filter
    public function getTimesheetList(Request $request)
    {
        // Call the fetchTimesheetList method from the Timesheet model
        $response_data = $this->timesheet->fetchTimesheetList($request->query('name'));

        // Return the response data as JSON with the corresponding status code
        return response()->json($response_data, $response_data["status"]);
    }

    // Method to fetch a specific timesheet by its ID
    public function fetchTimesheetById(int $id)
    {
        // Call the getTimesheetById method from the Timesheet model
        $response_data = $this->timesheet->getTimesheetById($id);

        // Return the response data as JSON with the corresponding status code
        return response()->json($response_data, $response_data["status"]);
    }

    // Method to delete a timesheet by its ID
    public function deleteTimesheetById(int $id)
    {
        // Call the deleteTimesheet method from the Timesheet model
        $response_data = $this->timesheet->deleteTimesheet($id);

        // Return the response data as JSON with the corresponding status code
        return response()->json($response_data, $response_data["status"]);
    }
}

