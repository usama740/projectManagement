<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttributeValue extends Model
{
    // Define fillable fields for mass assignment
    protected $fillable = ['attribute_id', 'project_id', 'value'];

    // Define relationship with the Project model
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    // Define relationship with the Attribute model
    public function attribute(): BelongsTo
    {
        return $this->belongsTo(Attribute::class);
    }

    // Save or update attribute values for a project
    public function saveValues($projectId, $attributes)
    {
        foreach ($attributes as $attr) {
            // Use updateOrCreate to insert or update attribute values
            $this->updateOrCreate(
                ['attribute_id' => $attr['attribute_id'], 'project_id' => $projectId],
                ['value' => $attr['value']]
            );
        }
        return true;
    }

    // Update values for a project by deleting old values and saving new ones
    public function updateValues($projectId, $attributes)
    {
        // Delete old values for the given project
        $this->where('project_id', $projectId)->delete();
        // Save new attribute values
        return $this->saveValues($projectId, $attributes);
    }
}

