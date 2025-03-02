<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Utils\CustomResponse;
use Symfony\Component\HttpFoundation\Response;


class User extends Authenticatable
{
    use HasFactory, HasApiTokens;

    // Define fillable fields for mass assignment
    protected $fillable = ['first_name', 'last_name', 'email', 'password'];

    // Hide sensitive data like password when converting model to array or JSON
    protected $hidden = ['password'];

    // One-to-Many Relationship: A user can log multiple timesheets
    public function timesheets(): HasMany
    {
        return $this->hasMany(Timesheet::class);
    }

    // Many-to-Many Relationship: A user can be part of many projects
    public function projects(): BelongsToMany
    {
        return $this->belongsToMany(Project::class)->withTimestamps();
    }

    // Get the payload for the user's access token (used for API authentication)
    public function getAccessTokenPayload()
    {
        return [
            'user_id' => $this->id,
            'email' => $this->email
        ];
    }

    // Register a new user with encrypted password
    public function saveUser($data)
    {
        // Encrypt the password before saving
        $data["password"] = Hash::make($data["password"]);
        $user = $this->create($data);
        return CustomResponse::send(Response::HTTP_CREATED, "User registered successfully", [$user]);
    }

    // Fetch users with optional filters (first_name, last_name, email)
    public function getUsers($filter = null)
    {
        $query = $this->query();

        // Apply dynamic filters based on provided criteria
        if (!empty($filter)) {
            foreach ($filter as $key => $value) {
                if (in_array($key, ['first_name', 'last_name', 'email'])) {
                    $query->where($key, 'LIKE', "%$value%");
                }
            }
        }

        $users = $query->get();
        return CustomResponse::send(Response::HTTP_OK, "User list fetched successfully", $users);
    }

    // Fetch a user by their ID
    public function getUserById($id)
    {
        $user = $this->find($id);

        // Check if user exists
        if (!$user) {
            return CustomResponse::send(Response::HTTP_NOT_FOUND, "User not found", [], false);
        }

        return CustomResponse::send(Response::HTTP_OK, "User fetched successfully", [$user]);
    }

    // Update user details for the authenticated user
    public function updateUser($data)
    {
        $user = Auth::guard('api')->user();

        // Ensure the email stays the same during updates
        $data['email'] = $user->email;
        $user->update($data);

        return CustomResponse::send(Response::HTTP_OK, "User updated successfully", [$user]);
    }
}

