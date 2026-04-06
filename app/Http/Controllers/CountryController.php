<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Http\Requests\CountryRequest;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class CountryController extends Controller
{
  public function index(Request $request)
  {
    $this->authorize("areas-region.index");
    return view('content.country.index');
  }

  public function getData(Request $request)
  {
    $this->authorize("areas-region.index");
    $query = Country::select(['id', 'string_id', 'nameCountry', 'created_at'])->with('towns');

    return DataTables::of($query)
      ->addColumn('regions_count', function ($row) {
        return $row->towns->count();
      })
      ->addColumn('created_at', function ($row) {
        return formatDate($row->created_at);
      })
      ->addColumn('actions', function ($row) {
        $user = auth()->user();
        $editUrl = route('areas-region.update', $row->string_id);
        $deleteUrl = route('areas-region.destroy', $row->string_id);
        $manageRegionsUrl = route('towns.data', $row->string_id);

        $buttons = '
        <div class="d-inline-block text-nowrap">';

        if ($user->can('areas-region.create')) {
          $buttons .= '
          <button type="button" class="btn btn-text-secondary rounded-pill waves-effect btn-icon manage-btn"
                        data-url="' . $manageRegionsUrl . '"
                        data-id="' . $row->string_id . '"
                        data-name="' . $row->nameCountry . '"
                        title="' . __('Manage Regions') . '">
                    <i class="icon-base ti tabler-map-cog icon-25px"></i>
                </button>';
        }

        $buttons .= '
            <button type="button" class="btn btn-text-secondary rounded-pill waves-effect btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="icon-base ti tabler-dots-vertical icon-25px"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end m-0">';

        if ($user->can('areas-region.edit')) {
          $buttons .= '
                <button type="button" class="dropdown-item edit-btn"
                        data-url="' . $editUrl . '"
                        data-id="' . $row->string_id . '"
                        data-name="' . $row->nameCountry . '">
                    <i class="icon-base ti tabler-pencil me-1"></i>' . __('Edit Area') . '
                </button>';
        }

        if ($user->can('areas-region.destroy')) {
          $buttons .= '
                <button type="button" class="dropdown-item btn-delete"
                        data-url="' . $deleteUrl . '"
                        data-id="' . $row->string_id . '">
                    <i class="icon-base ti tabler-trash me-1"></i>' . __('Delete Area') . '
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

  public function store(CountryRequest $request)
  {
    $this->authorize("areas-region.create");
    try {
      $validatedData = $request->validated();

      unset($validatedData['area_id']);

      Country::create($validatedData);

      return response()->json([
        'status' => 'success',
        'message' => __('Area created successfully'),
        'errors' => []
      ], 200);
    } catch (ValidationException $e) {
      return response()->json([
        'status' => 'error',
        'message' => __('Area creation failed'),
        'errors' => $e->errors(),
      ], 422);
    } catch (\Throwable $th) {
      return response()->json([
        'status' => 'error',
        'message' => __('Area creation failed'),
        'errors' => $th->getMessage()
      ], 500);
    }
  }

  public function update(CountryRequest $request, $country)
  {
    $this->authorize('areas-region.edit');
    try {
      $country = Country::where('string_id', $country)->first();
      $validatedData = $request->validated();

      $country->update($validatedData);

      return response()->json([
        'status' => 'success',
        'message' => __('Area updated successfully'),
        'errors' => []
      ], 200);
    } catch (ValidationException $e) {
      return response()->json([
        'status' => 'error',
        'message' => __('Area update failed'),
        'errors' => $e->errors(),
      ], 422);
    } catch (\Throwable $th) {
      return response()->json([
        'status' => 'error',
        'message' => __('Area update failed'),
        'errors' => $th->getMessage()
      ], 500);
    }
  }

  public function destroy($country)
  {
    $this->authorize('areas-region.destroy');
    try {
      $country = Country::where('string_id', $country)->first();

      $country->towns()->delete();
      $country->delete();

      return response()->json([
        'status' => 'success',
        'message' => __('Area deleted successfully')
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'status' => 'error',
        'message' => __('Area deletion failed'),
        'error' => $e->getMessage()
      ], 500);
    }
  }
}
