<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use App\Utils\CustomResponse;
use Symfony\Component\HttpFoundation\Response;


class Timesheet extends Model
{
    use HasFactory;

    // Define fillable fields for mass assignment
    protected $fillable = ['task_name', 'date', 'hours', 'user_id', 'project_id'];

    // A timesheet belongs to one user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // A timesheet belongs to one project
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    // Create and save a new timesheet for the authenticated user
    public function saveTimesheet($data)
    {
        $user = Auth::guard('api')->user();
        $data["user_id"] = $user->id;

        $timeSheet = $this->create($data);
        return CustomResponse::send(Response::HTTP_CREATED, "Timesheet created successfully", [$timeSheet]);
    }

    // Update an existing timesheet by ID (ensuring ownership)
    public function updateTimesheet($id, $data)
    {
        $timeSheet = $this->find($id);
        $user = Auth::guard('api')->user();

        // Check if timesheet exists and if the user is authorized
        if (!$timeSheet || $user->id != $timeSheet->user_id) {
            return CustomResponse::send(Response::HTTP_NOT_FOUND, "Timesheet not found", [], false);
        }

        $timeSheet->update($data);
        return CustomResponse::send(Response::HTTP_OK, "Timesheet updated successfully", [$timeSheet]);
    }

    // Fetch a list of timesheets for the authenticated user, optionally filtered by task name
    public function fetchTimesheetList($name = null)
    {
        $user = Auth::guard('api')->user();
        $timeSheetsQuery = $this->where('user_id', $user->id);

        if (isset($name)) {
            $timeSheetsQuery->where('task_name', 'LIKE', "%$name%");
        }

        $timeSheets = $timeSheetsQuery->get();
        return CustomResponse::send(Response::HTTP_OK, "Timesheet list fetched successfully", $timeSheets);
    }

    // Get a single timesheet by ID (ensuring ownership)
    public function getTimesheetById($id)
    {
        $timeSheet = $this->find($id);
        $user = Auth::guard('api')->user();

        if (!$timeSheet || $user->id != $timeSheet->user_id) {
            return CustomResponse::send(Response::HTTP_NOT_FOUND, "Timesheet not found", [], false);
        }

        return CustomResponse::send(Response::HTTP_OK, "Timesheet fetched successfully", [$timeSheet]);
    }

    // Delete a timesheet by ID (ensuring ownership)
    public function deleteTimesheet($id)
    {
        $timeSheet = $this->find($id);
        $user = Auth::guard('api')->user();

        if ($user->id != $timeSheet->user_id) {
            return CustomResponse::send(Response::HTTP_NOT_FOUND, "Timesheet not found", [], false);
        }

        $timeSheet->delete();
        return CustomResponse::send(Response::HTTP_OK, "Timesheet deleted successfully", [], false);
    }
}
