<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Utils\CustomResponse;
use Symfony\Component\HttpFoundation\Response;



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
        return CustomResponse::send(Response::HTTP_CREATED, "Attribute created successfully", [$attribute]);
    }

    // Update an existing attribute by ID
    public function updateAttribute($id, $data)
    {
        $attribute = $this->find($id);
        if (!$attribute) {
            return CustomResponse::send(Response::HTTP_NOT_FOUND, "Attribute not found.", [], false);
        }

        $attribute->update($data);
        return CustomResponse::send(Response::HTTP_OK, "Attribute updated successfully.", [$attribute]);
    }

    // Delete an attribute by ID (Note: missing actual delete logic)
    public function deleteAttribute($id)
    {
        $attribute = $this->find($id);
        if (!$attribute) {
            return CustomResponse::send(Response::HTTP_NOT_FOUND, "Attribute not found.", [], false);
        }

        $attribute->delete();
        return CustomResponse::send(Response::HTTP_OK, "Attribute deleted successfully.", [], false);
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

        return CustomResponse::send(Response::HTTP_OK, "Attribute list fetched successfully", $query->get());
    }

    // Fetch a single attribute by ID
    public function getAttributeById($id)
    {
        $attribute = $this->find($id);
        if (!$attribute) {
            return CustomResponse::send(Response::HTTP_NOT_FOUND, "Attribute not found", [], false);
        }

        return CustomResponse::send(Response::HTTP_OK, "Attribute fetched successfully", [$attribute]);
    }
}

