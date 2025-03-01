<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Utils\CustomResponse;


class Attribute extends Model
{
    // Define fillable fields to allow mass assignment
    protected $fillable = ['name', 'type'];

    // Define a one-to-many relationship with AttributeValue
    public function attributeValues(): HasMany
    {
        return $this->hasMany(AttributeValue::class, 'attribute_id');
    }

    // Create and save a new attribute
    public function saveAttribute($data)
    {
        $attribute = $this->create($data);
        return CustomResponse::send(201, "Attribute created successfully", [$attribute]);
    }

    // Update an existing attribute by ID
    public function updateAttribute($id, $data)
    {
        $attribute = $this->find($id);
        if (!$attribute) {
            return CustomResponse::send(404, "Attribute not found.", [], false);
        }

        $attribute->update($data);
        return CustomResponse::send(200, "Attribute updated successfully.", [$attribute]);
    }

    // Delete an attribute by ID (Note: missing actual delete logic)
    public function deleteAttribute($id)
    {
        $attribute = $this->find($id);
        if (!$attribute) {
            return CustomResponse::send(404, "Attribute not found.", [], false);
        }

        $attribute->delete();
        return CustomResponse::send(200, "Attribute deleted successfully.", [], false);
    }

    // Fetch a list of attributes with optional filters
    public function fetchAttributeList($filters = null)
    {
        $query = $this->query();

        if (!empty($filters)) {
            foreach ($filters as $key => $value) {
                if (in_array($key, ['name', 'type'])) {
                    $query->where($key, 'LIKE', '%' . $value . '%');
                }
            }
        }

        return CustomResponse::send(200, "Attribute list fetched successfully", $query->get());
    }

    // Fetch a single attribute by ID
    public function getAttributeById($id)
    {
        $attribute = $this->find($id);
        if (!$attribute) {
            return CustomResponse::send(404, "Attribute not found", [], false);
        }

        return CustomResponse::send(200, "Attribute fetched successfully", [$attribute]);
    }
}

