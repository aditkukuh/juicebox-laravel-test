<?php
namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Controllers\API\BaseController;
use Exception; // Import Exception class

class UserController extends BaseController
{
    /**
     * Get user by ID.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getUserById($id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return $this->sendError('User not found');
            }

            return $this->sendResponse(new UserResource($user), 'Get user by ID successfully.');
        } catch (Exception $e) {
            return $this->sendError('Failed to retrieve user', ['error' => $e->getMessage()]);
        }
    }

    /**
     * Get all users.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        try {
            $users = User::paginate(5);

            if (!$users) {
                return $this->sendError('User not found');
            }

            return $result = UserResource::collection($users)->additional([
                'status' => true,
                'message' => 'users retrieved successfully.',
            ]);
        } catch (\Exception $e) {
            return $this->sendError('Failed to retrieve users', ['error' => $e->getMessage()]);
        }
    }
}