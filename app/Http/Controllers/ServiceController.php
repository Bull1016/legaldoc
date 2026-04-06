<?php

namespace App\Http\Controllers;

use App\Http\Requests\ServiceStoreRequest;
use App\Http\Requests\ServiceUpdateRequest;
use App\Models\Service;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ServiceController extends Controller
{
  public function index(Request $request)
  {
    $this->authorize("services.index");
    return view('content.services.index');
  }

  public function getData(Request $request)
  {
    $this->authorize('services.index');
    $query = Service::select(['id', 'string_id', 'name', 'duration', 'created_at']);

    return DataTables::of($query)
      ->addColumn('created_at', function ($row) {
        return formatDate($row->created_at);
      })
      ->addColumn('actions', function ($row) {
        $user = auth()->user();
        $editUrl = route('services.update', $row->string_id);
        $deleteUrl = route('services.destroy', $row->string_id);

        $buttons = '
        <div class="d-inline-block text-nowrap">
            <button type="button" class="btn btn-text-secondary rounded-pill waves-effect btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="icon-base ti tabler-dots-vertical icon-25px"></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end m-0">';

        if ($user->can('services.edit')) {
          $buttons .= '
                <a class="dropdown-item" href="' . $editUrl . '">
                    <i class="icon-base ti tabler-pencil me-1"></i> ' . __('Edit') . '
                </a>';
        }

        // if ($user->can('partners.destroy')) {
        //   $buttons .= '
        //         <button type="button" class="dropdown-item btn-delete"
        //                 data-url="' . $deleteUrl . '"
        //                 data-id="' . $row->string_id . '">
        //             <i class="icon-base ti tabler-trash me-1"></i>' . __('Delete Partner') . '
        //         </button>';
        // }

        $buttons .= '
            </div>
        </div>
    ';
        return $buttons;
      })

      ->addIndexColumn()
      ->rawColumns(['actions'])
      ->make(true);
  }

  // public function store(PartnerStoreRequest $request)
  // {
  //   $this->authorize("partners.create");
  //   try {
  //     $validatedData = $request->validated();

  //     if ($request->hasFile('pic')) {
  //       $path = $request->file('pic')->store('partners', 'public');
  //       $validatedData['pic'] = $path;
  //     }

  //     Partner::create($validatedData);

  //     return response()->json([
  //       'status' => 'success',
  //       'message' => __('Partner created successfully'),
  //       'errors' => []
  //     ], 200);
  //   } catch (ValidationException $e) {
  //     return response()->json([
  //       'status' => 'error',
  //       'message' => __('Partner creation failed'),
  //       'errors' => $e->errors(),
  //     ], 422);
  //   } catch (\Throwable $th) {
  //     return response()->json([
  //       'status' => 'error',
  //       'message' => __('Partner creation failed'),
  //       'errors' => $th->getMessage()
  //     ], 500);
  //   }
  // }

  // public function update(PartnerUpdateRequest $request, $partner)
  // {
  //   $this->authorize('partners.edit');
  //   try {
  //     $partner = Partner::where('string_id', $partner)->first();
  //     $validatedData = $request->validated();

  //     if ($request->hasFile('pic')) {
  //       // Supprimer l'ancienne image si elle existe
  //       if ($partner->pic && Storage::exists('public/' . $partner->pic)) {
  //         Storage::delete('public/' . $partner->pic);
  //       }

  //       $path = $request->file('pic')->store('partners', 'public');
  //       $validatedData['pic'] = $path;
  //     }

  //     $partner->update($validatedData);

  //     return response()->json([
  //       'status' => 'success',
  //       'message' => __('Partner updated successfully'),
  //       'errors' => []
  //     ], 200);
  //   } catch (ValidationException $e) {
  //     return response()->json([
  //       'status' => 'error',
  //       'message' => __('Partner update failed'),
  //       'errors' => $e->errors(),
  //     ], 422);
  //   } catch (\Throwable $th) {
  //     return response()->json([
  //       'status' => 'error',
  //       'message' => __('Partner update failed'),
  //       'errors' => $th->getMessage()
  //     ], 500);
  //   }
  // }

  // public function destroy($partner)
  // {
  //   $this->authorize('partners.destroy');
  //   try {
  //     $partner = Partner::where('string_id', $partner)->first();

  //     if ($partner->pic && Storage::exists('public/' . $partner->pic)) {
  //       Storage::delete('public/' . $partner->pic);
  //     }
  //     $partner->delete();

  //     return response()->json([
  //       'status' => 'success',
  //       'message' => __('Partner deleted successfully')
  //     ]);
  //   } catch (\Exception $e) {
  //     return response()->json([
  //       'status' => 'error',
  //       'message' => __('Partner deletion failed'),
  //       'error' => $e->getMessage()
  //     ], 500);
  //   }
  // }
}
