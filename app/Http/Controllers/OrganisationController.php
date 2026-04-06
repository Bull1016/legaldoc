<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrganisationRequest;
use App\Models\Country;
use App\Models\Organisation;
use App\Models\Social;
use App\Models\Town;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class OrganisationController extends Controller
{
  public function index(Request $request)
  {
    $this->authorize('organisations.index');
    return view('content.organisation.index');
  }

  public function getData(Request $request)
  {
    $this->authorize('organisations.index');
    $query = Organisation::select(['id', 'string_id', 'nameOr', 'numberOr', 'picOr', 'mailOr', 'created_at'])->with('social', 'user');

    return DataTables::of($query)
      ->addColumn('pic_name', function ($row) {
        $imagePath = $row->picOr && file_exists(storage_path('app/public/' . $row->picOr))
          ? asset('storage/' . $row->picOr)
          : asset('assets/img/branding/default-partner.webp'); // image par défaut

        return '
              <div class="justify-content-center">
                  <img alt="' . e($row->nameOr) . '" src="' . $imagePath . '" width="50" class="mb-1">
                  <br>
                  <small class="text-muted">' . e($row->nameOr) . '</small>
              </div>
          ';
      })
      ->addColumn('contacts', function ($row) {
        $contacts = '';
        if ($row->numberOr) {
          $contacts .= '<span> <i class="menu-icon icon-base ti tabler-phone"></i>' . $row->numberOr . '</span><br>';
        }
        if ($row->mailOr) {
          $contacts .= '<span> <i class="menu-icon icon-base ti tabler-inbox"></i>' . $row->mailOr . '</span><br>';
        }
        if ($row->social?->whatsapp) {
          $contacts .= '<span> <a href="https://wa.me/' . $row->social?->whatsapp . '" target="_blank"><i class="menu-icon icon-base ti tabler-brand-whatsapp"></i>' . $row->social?->whatsapp . '</a></span>';
        }
        return $contacts;
      })
      ->addColumn('numberOr', function ($row) {
        return $row->numberOr;
      })
      ->addColumn('mailOr', function ($row) {
        return $row->mailOr;
      })
      ->addColumn('whatsapp', function ($row) {
        return $row->social?->whatsapp;
      })
      ->addColumn('created_at', function ($row) {
        return formatDate($row->created_at);
      })
      ->addColumn('actions', function ($row) {
        $user = auth()->user();
        $editUrl = route('organisations.edit', $row->string_id);
        $deleteUrl = route('organisations.destroy', $row->string_id);

        $buttons = '
        <div class="dropdown text-center">
            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="icon-base ti tabler-dots-vertical icon-25px"></i>
            </button>
            <div class="dropdown-menu">';

        if ($user->can('organisations.edit')) {
          $buttons .= '
                <a class="dropdown-item" href="' . $editUrl . '">
                    <i class="icon-base ti tabler-pencil me-1"></i> ' . __('Edit') . '
                </a>';
        }

        if ($user->can('organisations.destroy')) {
          $buttons .= '
                <button type="button" class="dropdown-item btn-delete"
                        data-url="' . $deleteUrl . '"
                        data-id="' . $row->string_id . '">
                    <i class="icon-base ti tabler-trash me-1"></i> ' . __('Delete') . '
                </button>';
        }

        $buttons .= '
            </div>
        </div>
    ';
        return $buttons;
      })

      ->addIndexColumn()
      ->rawColumns(['contacts', 'pic_name', 'actions', 'created_at', 'numberOr', 'mailOr', 'whatsapp'])
      ->make(true);
  }

  public function count()
  {
    return response()->json([
      'data' => Organisation::count()
    ]);
  }

  public function create()
  {
    $this->authorize('organisations.create');
    if (count(Organisation::all()) >= 1) {
      return redirect()->route('organisations.index')->with('error', __('An organisation already exists'));
    }
    $zones = Country::with('towns')->get();
    return view('content.organisation.create', compact('zones'));
  }

  public function store(OrganisationRequest $request)
  {
    $this->authorize('organisations.create');

    if (!$request->hasFile('picOr')) {
      return response()->json([
        'status' => 'error',
        'message' => __('Organisation creation failed'),
        'errors' => ['picOr' => __('Please upload an image')],
      ], 422);
    }

    try {
      $validatedData = $request->validated();
      $validatedData['user_id'] = FacadesAuth::user()->id;

      $validatedData['town_id'] = $validatedData['country_id'] = 0;

      $path = $request->file('picOr')->store('organisations', 'public');
      $validatedData['picOr'] = $path;

      $organisation = Organisation::create($validatedData);

      unset($validatedData['nameOr']);
      unset($validatedData['mailOr']);
      unset($validatedData['numberOr']);
      unset($validatedData['town_id']);
      unset($validatedData['stateOr']);
      unset($validatedData['latitude']);
      unset($validatedData['longitude']);
      unset($validatedData['descriptionOr']);
      unset($validatedData['user_id']);
      unset($validatedData['country_id']);

      $validatedData['organisation_id'] = $organisation->id;

      $social = Social::create($validatedData);

      unset($validatedData['whatsapp']);
      unset($validatedData['facebook']);

      $validatedData['social_id'] = $social->id;

      $organisation->update($validatedData);

      return response()->json([
        'status' => 'success',
        'message' => __('Organisation created successfully'),
        'errors' => []
      ], 200);
    } catch (ValidationException $e) {
      return response()->json([
        'status' => 'error',
        'message' => __('Organisation creation failed'),
        'errors' => $e->errors(),
      ], 422);
    } catch (\Throwable $th) {
      return response()->json([
        'status' => 'error',
        'message' => __('Organisation creation failed'),
        'errors' => $th->getMessage()
      ], 500);
    }
  }

  public function edit(Organisation $organisation)
  {
    $this->authorize('organisations.edit');
    $zones = Country::with('towns')->get();
    $social = $organisation->social;
    return view('content.organisation.edit', compact('organisation', 'zones', 'social'));
  }

  public function update(OrganisationRequest $request, Organisation $organisation)
  {
    $this->authorize('organisations.edit');
    try {
      $validatedData = $request->validated();

      $validatedData['town_id'] = $validatedData['country_id'] = 0;

      if ($request->hasFile('picOr')) {
        // Supprimer l'ancienne image si elle existe
        if ($organisation->picOr && Storage::exists('public/' . $organisation->picOr)) {
          Storage::delete('public/' . $organisation->picOr);
        }

        $path = $request->file('picOr')->store('organisations', 'public');
        $validatedData['picOr'] = $path;
      }

      $organisation->update($validatedData);

      unset($validatedData['nameOr']);
      unset($validatedData['mailOr']);
      unset($validatedData['numberOr']);
      unset($validatedData['town_id']);
      unset($validatedData['stateOr']);
      unset($validatedData['latitude']);
      unset($validatedData['longitude']);
      unset($validatedData['descriptionOr']);
      unset($validatedData['country_id']);

      Social::updateOrCreate(['organisation_id' => $organisation->id], $validatedData);

      return response()->json([
        'status' => 'success',
        'message' => __('Organisation updated successfully'),
        'errors' => []
      ], 200);
    } catch (ValidationException $e) {
      return response()->json([
        'status' => 'error',
        'message' => __('Organisation update failed'),
        'errors' => $e->errors(),
      ], 422);
    } catch (\Throwable $th) {
      return response()->json([
        'status' => 'error',
        'message' => __('Organisation update failed'),
        'errors' => $th->getMessage()
      ], 500);
    }
  }

  public function destroy(Organisation $organisation)
  {
    $this->authorize('organisations.destroy');
    try {
      $organisation->social()->delete();
      $organisation->delete();

      return response()->json([
        'status' => 'success',
        'message' => __('Organisation deleted successfully')
      ]);
    } catch (\Exception $e) {
      return response()->json([
        'status' => 'error',
        'message' => __('Organisation deletion failed'),
        'error' => $e->getMessage()
      ], 500);
    }
  }
}
