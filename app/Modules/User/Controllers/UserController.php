<?php

namespace App\Modules\User\Controllers;

use App\Modules\User\Actions\StoreUserAction;
use App\Modules\User\Actions\DeleteUserAction;
use App\Modules\User\Actions\UpdateUserAction;
use App\Modules\User\DTO\UserDTO;
use App\Modules\User\Models\User;
use App\Modules\User\Requests\StoreUserRequest;
use App\Modules\User\Requests\UpdateUserRequest;
use App\Modules\User\ViewModels\UserIndexVM;
use App\Http\Controllers\Controller;
use App\Helpers\Helper;
use App\Modules\User\ViewModels\UserShowVM;

class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\JsonResponse
   */
  public function index()
  {
    $response = Helper::createSuccessResponse(UserIndexVM::toArray());
    return response()->json($response, 200);
  }

  /**
   * Store a newly created resource in storage.
   *
   * //     * @param StoreUserRequest $createUserRequest
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(StoreUserRequest $createUserRequest)
  {
    //
    $UserDTO = UserDTO::fromRequest($createUserRequest);
    $response = Helper::createSuccessResponse(StoreUserAction::execute($UserDTO));
    return response()->json($response, 200);
  }

  /**
   * Display the specified resource.
   *
   * @param User $User
   * @return \Illuminate\Http\JsonResponse
   */
  public function show(User $user)
  {
    //
    $response = Helper::createSuccessResponse(UserShowVM::toArray($user));
    return response()->json($response, 200);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param UpdateUserRequest $updateUserRequest
   * @param User $User
   * @return \Illuminate\Http\JsonResponse
   */
  public function update(UpdateUserRequest $updateUserRequest, User $user)
  {
    //
    $userDTO = UserDTO::fromRequestForUpdate($updateUserRequest, $user);
    $response = Helper::createSuccessResponse(UserShowVM::toArray(UpdateUserAction::execute($user, $userDTO)));
    return response()->json($response, 200);
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param User $User
   * @return \Illuminate\Http\JsonResponse
   */
  public function destroy(User $user)
  {
    //
    DeleteUserAction::execute($user);
    return response()->json(['O_Msg' => 'Item Deleted'], 200);
  }
}
