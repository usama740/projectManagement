<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Http\Request;




class UserController extends Controller
{
    private $user;

    // Inject the User model into the controller
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    // Method to save a new user
    public function saveUser(UserRequest $request)
    {
        // Use the saveUser method from the User model to create a new user
        $response_data = $this->user->saveUser($request->all());

        // Return the response data as JSON with the corresponding status code
        return response()->json($response_data, $response_data["status"]);
    }

    // Method to update an existing user
    public function updateUser(UserUpdateRequest $request)
    {
        // Use the updateUser method from the User model to update user details
        $response_data = $this->user->updateUser($request->only(["first_name", "last_name"]));

        // Return the response data as JSON with the corresponding status code
        return response()->json($response_data, $response_data["status"]);
    }

    // Method to fetch a list of users, with optional filters
    public function getUsers(Request $request)
    {
        // Use the getUsers method from the User model to fetch the list of users
        $response_data = $this->user->getUsers($request->query());

        // Return the response data as JSON with the corresponding status code
        return response()->json($response_data, $response_data["status"]);
    }

    // Method to fetch a user by their ID
    public function getUserById(int $id)
    {
        // Use the getUserById method from the User model to fetch the user details
        $response_data = $this->user->getUserById($id);

        // Return the response data as JSON with the corresponding status code
        return response()->json($response_data, $response_data["status"]);
    }
}

