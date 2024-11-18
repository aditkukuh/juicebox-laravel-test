<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Controllers\API\BaseController;

class UserController extends BaseController
{
    public function getUserById($id)
    {
        $user = User::find($id);

        if (!$user) {
            return $this->sendError('User not found');
        }

        return $this->sendResponse(new UserResource($user), 'Get user by ID successfully.');
    }

    public function getAll()
    {
        $users = User::paginate(5);

        if (!$users) {
            return $this->sendError('User not found');
        }

        return $result = UserResource::collection($users)->additional([
            'status' => true,
            'message' => 'users retrieved successfully.',
        ]);;
    }
}
