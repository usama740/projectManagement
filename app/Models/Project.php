<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Utils\CustomResponse;

class Project extends Model
{
    use HasFactory;

    // Define fillable fields for mass assignment
    protected $fillable = ['name', 'status'];

    // Many-to-Many Relationship: A project can have many users
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    // One-to-Many Relationship: A project can have many timesheets
    public function timesheets(): HasMany
    {
        return $this->hasMany(Timesheet::class);
    }

    // One-to-Many Relationship: A project can have many attribute values
    public function attributeValues(): HasMany
    {
        return $this->hasMany(AttributeValue::class, 'project_id');
    }

    // Filter projects based on an attribute and its value
    public function filterProjects($attributeId, $value)
    {
        $projects = $this->whereHas('attributes', function ($q) use ($attributeId, $value) {
            $q->where('attribute_id', $attributeId)->where('value', $value);
        })->get();

        return CustomResponse::send(200, "Project list fetched successfully", $projects);
    }

    // Get a list of projects with optional filters
    public function getProjects($filters = null)
    {
        $query = $this->query();

        if (!empty($filters)) {
            foreach ($filters as $key => $value) {
                if (in_array($key, ['name', 'status'])) {
                    // Apply filter on project table fields
                    $query->where($key, 'LIKE', '%' . $value . '%');
                } else {
                    // Apply filter on attributes via attribute_values table
                    $query->whereHas('attributeValues', function ($attrValQuery) use ($key, $value) {
                        $attrValQuery->whereHas('attribute', function ($attrQuery) use ($key) {
                            $attrQuery->where('name', $key);
                        })->where('value', 'LIKE', '%' . $value . '%');
                    });
                }
            }
        }

        $projects = $query->get();

        return CustomResponse::send(200, "Project list fetched successfully", $projects);
    }

    // Create and save a new project
    public function saveProject($data)
    {
        $project = $this->create($data);
        return CustomResponse::send(201, "Project created successfully", [$project]);
    }

    // Update an existing project by ID
    public function updateProject($id, $data)
    {
        $project = $this->find($id);
        if (!$project) {
            return CustomResponse::send(404, "Project not found.", [], false);
        }

        $project->update($data);
        return CustomResponse::send(200, "Project updated successfully.", [$project]);
    }

    // Get a list of projects with their associated attributes
    public function getProjectsWithAttributes()
    {
        $projects =  $this->with('attributes')->get();
        return CustomResponse::send(200, "Project list fetched successfully", $projects);
    }

    // Filter projects by multiple attribute-value pairs
    public function filterProjectsByAttributes(array $filters)
    {
        $projects = $this->whereHas('attributes', function ($query) use ($filters) {
            foreach ($filters as $attributeId => $value) {
                $query->where('attribute_id', $attributeId)
                      ->where('value', $value);
            }
        })->get();

        return CustomResponse::send(200, "Project list fetched successfully", $projects);
    }

    // Delete a project by ID
    public function deleteProject($id)
    {
        $project = $this->find($id);
        if (!$project) {
            return CustomResponse::send(404, "Project not found.", [], false);
        }

        $project->delete();
        return CustomResponse::send(200, "Project deleted successfully.", [], false);
    }
}

