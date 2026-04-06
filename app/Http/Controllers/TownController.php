<?php

namespace App\Http\Controllers;

use App\Models\Town;
use App\Models\Country;
use App\Http\Requests\TownRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class TownController extends Controller
{
  public function getData(Request $request, $country)
  {
    $this->authorize("areas-region.index");
    $country = Country::where('string_id', $country)->first();

    $query = $country->towns()->select(['id', 'string_id', 'nameTown', 'country_id', 'created_at']);

    return DataTables::of($query)
      ->addColumn('created_at', function ($row) {
        return formatDate($row->created_at);
      })
      ->addColumn('actions', function ($row) {
        $user = auth()->user();
        $editUrl = route('towns.update', ['area' => $row->country_id, 'region' => $row->string_id]);
        $deleteUrl = route('towns.destroy', ['area' => $row->country_id, 'region' => $row->string_id]);

        $buttons = '
        <div class="d-inline-block text-nowrap">
            <button type="button" class="btn btn-text-secondary rounded-pill waves-effect btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="icon-base ti tabler-dots-vertical icon-25px"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end m-0">';

        if ($user->can('areas-region.edit')) {
          $buttons .= '
                <button type="button" class="dropdown-item edit-region-btn"
                        data-url="' . $editUrl . '"
                        data-id="' . $row->string_id . '"
                        data-area="' . $row->country_id . '"
                        data-name="' . $row->nameTown . '">
                    <i class="icon-base ti tabler-pencil me-1"></i>' . __('Edit Region') . '
                </button>';
        }

        if ($user->can('areas-region.destroy')) {
          $buttons .= '
                <button type="button" class="dropdown-item btn-region-delete"
                        data-url="' . $deleteUrl . '"
                        data-area="' . $row->country_id . '"
                        data-id="' . $row->string_id . '">
                    <i class="icon-base ti tabler-trash me-1"></i>' . __('Delete Region') . '
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

  public function store(TownRequest $request, $area)
  {
    $this->authorize("areas-region.create");
    try {
      $country = Country::where('string_id', $area)->first();
      $validatedData = $request->validated();

      $validatedData['vpn_id'] = 0; // Default value for vpn_id

      $country->towns()->create($validatedData);

      return response()->json([
        'status' => 'success',
        'message' => __('Region created successfully'),
        'errors' => []
      ], 200);
    } catch (ValidationException $e) {
      return response()->json([
        'status' => 'error',
        'message' => __('Region creation failed'),
        'errors' => $e->errors(),
      ], 422);
    } catch (\Throwable $th) {
      return response()->json([
        'status' => 'error',
        'message' => __('Region creation failed'),
        'errors' => $th->getMessage()
      ], 500);
    }
  }

  public function update(TownRequest $request, $area, $region)
  {
    $this->authorize("areas-region.edit");
    try {
      $region = Town::where('string_id', $region)->first();
      $validatedData = $request->validated();

      $region->update($validatedData);

      return response()->json([
        'status' => 'success',
        'message' => __('Region updated successfully'),
        'errors' => []
      ], 200);
    } catch (ValidationException $e) {
      return response()->json([
        'status' => 'error',
        'message' => __('Region update failed'),
        'errors' => $e->errors(),
      ], 422);
    } catch (\Throwable $th) {
      return response()->json([
        'status' => 'error',
        'message' => __('Region update failed'),
        'errors' => $th->getMessage()
      ], 500);
    }
  }

  public function destroy($area, $region)
  {
    $this->authorize('areas-region.destroy');
    try {
      $region = Town::where('string_id', $region)->first();

      $region->delete();

      return response()->json([
        'status' => 'success',
        'message' => __('Region deleted successfully')
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'status' => 'error',
        'message' => __('Region deletion failed'),
        'error' => $e->getMessage()
      ], 500);
    }
  }
}
