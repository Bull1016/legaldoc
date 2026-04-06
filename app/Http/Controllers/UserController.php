<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
  public function index(Request $request)
  {
    $this->authorize('users.index');
    $roles = Role::all();
    return view('content.users.index', compact('roles'));
  }

  public function getData(Request $request)
  {
    $this->authorize('users.index');
    $query = User::select(['id', 'string_id', 'name', 'email', 'created_at'])->with('roles');

    return DataTables::of($query)
      ->addColumn('name_role', function ($row) {
        return '
              <div class="justify-content-center">
                  <span>' . e($row->name) . '</span>
                  <br>
                  <small class="text-muted">' . e($row->roles->pluck('name')->implode(', ')) . '</small>
              </div>
          ';
      })
      ->addColumn('created_at', function ($row) {
        return formatDate($row->created_at);
      })
      ->addColumn('actions', function ($row) {
        $user = auth()->user();
        $editUrl = route('users.update', $row->string_id);
        $deleteUrl = route('users.destroy', $row->string_id);

        $buttons = '
        <div class="d-inline-block text-nowrap">
            <button type="button" class="btn btn-text-secondary rounded-pill waves-effect btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="icon-base ti tabler-dots-vertical icon-25px"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end m-0">';

        if ($user->can('users.edit')) {
          $buttons .= '
                <button type="button" class="dropdown-item edit-btn"
                        data-url="' . $editUrl . '"
                        data-id="' . $row->string_id . '"
                        data-email="' . $row->email . '"
                        data-role-id="' . ($row->roles->first() ? $row->roles->first()->id : '') . '"
                        data-name="' . $row->name . '">
                    <i class="icon-base ti tabler-pencil me-1"></i>' . __('Edit User') . '
                </button>';
        }

        if ($user->can('users.destroy')) {
          $buttons .= '
                <button type="button" class="dropdown-item btn-delete"
                        data-url="' . $deleteUrl . '"
                        data-id="' . $row->string_id . '">
                    <i class="icon-base ti tabler-trash me-1"></i>' . __('Delete User') . '
                </button>';
        }

        $buttons .= '
            </div>
        </div>
    ';
        return $buttons;
      })

      ->addIndexColumn()
      ->rawColumns(['name_role', 'actions', 'created_at'])
      ->make(true);
  }

  public function store(UserStoreRequest $request)
  {
    $this->authorize('users.create');
    DB::beginTransaction();
    try {
      $validatedData = $request->validated();
      $validatedData['inscription_date'] = today();
      $validatedData['password'] = Hash::make($request->password);

      $user = User::create($validatedData);

      $selectedRole = Role::find($request->role);
      $user->assignRole($selectedRole->name);

      DB::commit();
      return response()->json([
        'status' => 'success',
        'message' => __('User created successfully'),
        'errors' => []
      ], 200);
    } catch (ValidationException $e) {
      DB::rollBack();
      return response()->json([
        'status' => 'error',
        'message' => __('User creation failed'),
        'errors' => $e->errors(),
      ], 422);
    } catch (\Throwable $th) {
      DB::rollBack();
      return response()->json([
        'status' => 'error',
        'message' => __('User creation failed'),
        'errors' => $th->getMessage()
      ], 500);
    }
  }

  public function update(UserUpdateRequest $request, $user)
  {
    $this->authorize('users.edit');
    DB::beginTransaction();
    try {
      $user = User::where('string_id', $user)->first();
      $validatedData = $request->validated();

      if (empty($validatedData['password'])) {
        unset($validatedData['password']);
      } else {
        $validatedData['password'] = bcrypt($validatedData['password']);
      }

      $user->update($validatedData);

      $selectedRole = Role::find($request->role);
      $user->syncRoles($selectedRole->name);

      DB::commit();
      return response()->json([
        'status' => 'success',
        'message' => __('User updated successfully'),
        'errors' => []
      ], 200);
    } catch (ValidationException $e) {
      DB::rollBack();
      return response()->json([
        'status' => 'error',
        'message' => __('User update failed'),
        'errors' => $e->errors(),
      ], 422);
    } catch (\Throwable $th) {
      DB::rollBack();
      return response()->json([
        'status' => 'error',
        'message' => __('User update failed'),
        'errors' => $th->getMessage()
      ], 500);
    }
  }

  public function destroy($user)
  {
    $this->authorize('users.destroy');
    DB::beginTransaction();
    try {
      $user = User::where('string_id', $user)->first();

      $user->delete();

      DB::commit();
      return response()->json([
        'status' => 'success',
        'message' => __('User deleted successfully')
      ]);
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json([
        'status' => 'error',
        'message' => __('User deletion failed'),
        'error' => $e->getMessage()
      ], 500);
    }
  }
}
