<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Http\Requests\FilterProjectRequest;
use App\Models\AttributeValue;
use Illuminate\Http\Request;
use App\Models\Project;


class ProjectController extends Controller
{
    private $project;
    private $attributeValue;

    // Injecting dependencies via constructor
    public function __construct(Project $project, AttributeValue $attributeValue)
    {
        $this->project = $project;
        $this->attributeValue = $attributeValue;
    }

    // Method to create a new project
    public function createProject(ProjectRequest $request)
    {
        $data = $request->all();

        // Extract attribute values and remove them from main data
        $attribute_value_data = $data['attribute_values'] ?? [];
        unset($data['attribute_values']);

        // Save project data
        $response_data = $this->project->saveProject($data);

        // If project is successfully created, save attribute values
        if (isset($response_data['entity']) && isset($response_data["entity"][0]["id"])) {
            $this->attributeValue->saveValues($response_data["entity"][0]["id"], $attribute_value_data);
        }

        return response()->json($response_data, $response_data["status"]);
    }

    // Method to update an existing project
    public function updateProject(int $id, ProjectRequest $request)
    {
        $data = $request->all();

        // Extract attribute values and remove them from main data
        $attribute_value_data = $data['attribute_values'] ?? [];
        unset($data['attribute_values']);

        // Update project details
        $response_data = $this->project->updateProject($id, $data);

        // If update is successful, update attribute values
        if (isset($response_data["entity"]["id"])) {
            $this->attributeValue->updateValues($response_data["entity"]["id"], $attribute_value_data);
        }

        return response()->json($response_data, $response_data["status"]);
    }

    // Method to fetch all projects with query filters
    public function getProjects(Request $request)
    {
        $response_data = $this->project->getProjects($request->query());
        return response()->json($response_data, $response_data["status"]);
    }

    // Method to fetch projects along with their attributes
    public function fetchProjectsWithAttributes()
    {
        $response_data = $this->project->getProjectsWithAttributes();
        return response()->json($response_data, $response_data["status"]);
    }

    // Method to delete a project by ID
    public function deleteProject(int $id)
    {
        $response_data = $this->project->deleteProject($id);
        return response()->json($response_data, $response_data["status"]);
    }


     // Method to delete a project by ID
     public function fetchProjectById(int $id)
     {
         $response_data = $this->project->fetchProjectById($id);
         return response()->json($response_data, $response_data["status"]);
     }
}
