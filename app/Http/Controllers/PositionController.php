<?php

namespace App\Http\Controllers;

use App\Http\Requests\PositionRequest;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class PositionController extends Controller
{
  public function index(Request $request)
  {
    $this->authorize('positions.index');
    $permissions = Permission::all();
    return view('content.positions.index', compact('permissions'));
  }

  public function getData(Request $request)
  {
    $this->authorize('positions.index');
    $query = Role::select(['id', 'string_id', 'name', 'created_at']);

    return DataTables::of($query)
      ->addColumn('created_at', function ($row) {
        return formatDate($row->created_at);
      })
      ->addColumn('actions', function ($row) {
        $user = auth()->user();
        $editUrl = route('positions.update', $row->string_id);
        $deleteUrl = route('positions.destroy', $row->string_id);

        $buttons = '
        <div class="d-inline-block text-nowrap">
            <button type="button" class="btn btn-text-secondary rounded-pill waves-effect btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="icon-base ti tabler-dots-vertical icon-25px"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end m-0">';

        if ($user->can('positions.edit')) {
          $buttons .= '
                <button type="button" class="dropdown-item manage-btn"
                        data-id="' . $row->string_id . '"
                        data-name="' . $row->name . '">
                    <i class="icon-base ti tabler-eye-cog me-1"></i>' . __('Manage Permissions') . '
                </button>

                <button type="button" class="dropdown-item edit-btn"
                        data-url="' . $editUrl . '"
                        data-id="' . $row->string_id . '"
                        data-name="' . $row->name . '">
                    <i class="icon-base ti tabler-pencil me-1"></i>' . __('Edit Position') . '
                </button>';
        }

        if ($user->can('positions.destroy')) {
          $buttons .= '
                <button type="button" class="dropdown-item btn-delete"
                        data-url="' . $deleteUrl . '"
                        data-id="' . $row->string_id . '">
                    <i class="icon-base ti tabler-trash me-1"></i>' . __('Delete Position') . '
                </button>';
        }

        $buttons .= '
            </div>
        </div>
    ';
        return $buttons;
      })

      ->addIndexColumn()
      ->rawColumns(['actions', 'created_at'])
      ->make(true);
  }

  public function store(PositionRequest $request)
  {
    $this->authorize('positions.create');
    try {
      $validatedData = $request->validated();
      $validatedData['guard_name'] = 'web';
      $validatedData['string_id'] = Str::uuid();

      Role::create($validatedData);

      return response()->json([
        'status' => 'success',
        'message' => __('Position created successfully'),
        'errors' => []
      ], 200);
    } catch (ValidationException $e) {
      return response()->json([
        'status' => 'error',
        'message' => __('Position creation failed'),
        'errors' => $e->errors(),
      ], 422);
    } catch (\Throwable $th) {
      return response()->json([
        'status' => 'error',
        'message' => __('Position creation failed'),
        'errors' => $th->getMessage()
      ], 500);
    }
  }

  public function update(PositionRequest $request, $position)
  {
    $this->authorize('positions.edit');
    try {
      $position = Role::where('string_id', $position)->first();
      $validatedData = $request->validated();

      $position->update($validatedData);

      return response()->json([
        'status' => 'success',
        'message' => __('Position updated successfully'),
        'errors' => []
      ], 200);
    } catch (ValidationException $e) {
      return response()->json([
        'status' => 'error',
        'message' => __('Position update failed'),
        'errors' => $e->errors(),
      ], 422);
    } catch (\Throwable $th) {
      return response()->json([
        'status' => 'error',
        'message' => __('Position update failed'),
        'errors' => $th->getMessage()
      ], 500);
    }
  }

  public function destroy($position)
  {
    $this->authorize('positions.destroy');
    try {
      $position = Role::where('string_id', $position)->first();

      $position->delete();

      return response()->json([
        'status' => 'success',
        'message' => __('Position deleted successfully')
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'status' => 'error',
        'message' => __('Position deletion failed'),
        'error' => $e->getMessage()
      ], 500);
    }
  }

  public function getPositionPermissions($position)
  {
    $this->authorize('positions.index');
    try {
      $position = Role::where('string_id', $position)->first();
      if (!$position) {
        return response()->json([
          'status' => 'error',
          'message' => __('Position not found')
        ], 404);
      }

      $permissionIds = $position->permissions()->pluck('id')->toArray();

      return response()->json([
        'status' => 'success',
        'permissions' => $permissionIds
      ], 200);
    } catch (\Throwable $th) {
      return response()->json([
        'status' => 'error',
        'message' => __('Failed to fetch permissions'),
        'errors' => $th->getMessage()
      ], 500);
    }
  }

  public function updatePermission(Request $request, $position)
  {
    $this->authorize('positions.edit');
    try {
      $position = Role::where('string_id', $position)->first();

      if (!$position) {
        return response()->json([
          'status' => 'error',
          'message' => __('Position not found')
        ], 404);
      }

      // Get permission IDs from request
      $permissionIds = $request->permissions ?? [];

      // Fetch Permission objects by IDs
      $permissions = Permission::whereIn('id', $permissionIds)->get();

      // Sync permissions with Permission objects - if empty collection, removes all permissions
      $position->syncPermissions($permissions);

      return response()->json([
        'status' => 'success',
        'message' => __('Position Permissions updated successfully'),
        'errors' => []
      ], 200);
    } catch (\Throwable $th) {
      return response()->json([
        'status' => 'error',
        'message' => __('Position Permissions update failed'),
        'errors' => $th->getMessage()
      ], 500);
    }
  }
}
