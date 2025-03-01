<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AttributeRequest;
use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Project;


class ProjectAttributeController extends Controller
{
    private $attribute;
    private $attributeValue;
    private $project;

    // Constructor Injection for dependencies
    public function __construct(Attribute $attribute, AttributeValue $attributeValue, Project $project)
    {
        $this->attribute = $attribute;
        $this->attributeValue = $attributeValue;
        $this->project = $project;
    }

    // Create a new attribute
    public function createAttribute(AttributeRequest $request)
    {
        $response_data = $this->attribute->saveAttribute($request->validated());
        return response()->json($response_data, $response_data["status"]);
    }

    // Update an existing attribute
    public function updateAttribute(int $id, AttributeRequest $request)
    {
        $response_data = $this->attribute->updateAttribute($id, $request->validated());
        return response()->json($response_data, $response_data["status"]);
    }

    // Filter projects based on attribute and value
    public function filterProjects(Request $request)
    {
        $attributeId = $request->input('attribute_id');
        $value = $request->input('value');

        if (!$attributeId || !$value) {
            return response()->json(['error' => 'Invalid request parameters'], 400);
        }

        $response_data = $this->project->filterProjects($attributeId, $value);
        return response()->json($response_data, $response_data["status"]);
    }

    // Delete an attribute
    public function deleteAttribute(int $id)
    {
        $response_data = $this->attribute->deleteAttribute($id);
        return response()->json($response_data, $response_data["status"]);
    }

    // Fetch a list of attributes with optional filters
    public function fetchAttributeList(Request $request)
    {
        $filters = $request->query();
        $response_data = $this->attribute->fetchAttributeList($filters);
        return response()->json($response_data, $response_data["status"]);
    }

    // Fetch a specific attribute by ID
    public function fetchAttributeById(int $id)
    {
        $response_data = $this->attribute->getAttributeById($id);
        return response()->json($response_data, $response_data["status"]);
    }
}

