<?php

namespace App\Http\Controllers;

use App\Http\Requests\MemberRequest;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Yajra\DataTables\DataTables;

class MemberController extends Controller
{
  public function index(Request $request)
  {
    $this->authorize('members.index');
    return view('content.member.index');
  }

  public function getData(Request $request)
  {
    $this->authorize('members.index');
    $query = Member::select(['id', 'string_id', 'phone', 'photo', 'sex', 'user_id', 'created_at'])->with('user');

    return DataTables::of($query)
      ->addColumn('pic_name', function ($row) {
        $imagePath = $row->photo && file_exists(storage_path('app/public/' . $row->photo))
          ? asset('storage/' . $row->photo)
          : asset('assets/img/branding/default-partner.webp'); // image par défaut

        return '
              <div class="justify-content-center">
                  <img alt="' . e($row->full_name) . '" src="' . $imagePath . '" width="50" class="mb-1">
                  <br>
                  <small class="text-muted">' . e($row->full_name) . '</small>
              </div>
          ';
      })
      ->addColumn('contacts', function ($row) {
        $contacts = '';
        if ($row->phone) {
          $contacts .= '<span> <i class="menu-icon icon-base ti tabler-phone"></i>' . $row->phone . '</span><br>';
        }
        if ($row->user?->email) {
          $contacts .= '<span> <i class="menu-icon icon-base ti tabler-inbox"></i>' . $row->user?->email . '</span><br>';
        }
        return $contacts;
      })
      ->addColumn('number', function ($row) {
        return $row->phone;
      })
      ->addColumn('mail', function ($row) {
        return $row->email;
      })
      ->addColumn('created_at', function ($row) {
        return formatDate($row->created_at);
      })
      ->addColumn('actions', function ($row) {
        $user = auth()->user();
        $editUrl = route('members.edit', $row->string_id);
        $deleteUrl = route('members.destroy', $row->string_id);

        $buttons = '
        <div class="dropdown text-center">
            <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                <i class="icon-base ti tabler-dots-vertical icon-25px"></i>
            </button>
            <div class="dropdown-menu">';

        if ($user->can('members.edit')) {
          $buttons .= '
                <a class="dropdown-item" href="' . $editUrl . '">
                    <i class="icon-base ti tabler-pencil me-1"></i> ' . __('Edit') . '
                </a>';
        }

        if ($user->can('members.destroy')) {
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
      ->rawColumns(['contacts', 'pic_name', 'actions', 'created_at'])
      ->make(true);
  }

  public function create()
  {
    $this->authorize('members.create');
    return view('content.member.create');
  }

  public function store(MemberRequest $request)
  {
    $this->authorize('members.create');

    DB::beginTransaction();
    try {
      $validatedData = $request->validated();

      // Creates User
      $user = User::create([
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
        'password' => Hash::make($validatedData['email']),
        'inscription_date' => today()
      ]);

      $user->assignRole('member');

      // Handle Photo
      $photoPath = $request->file('photo')->store('members', 'public');

      // Create Member
      $memberData = [
        'user_id' => $user->id,
        'organisation_id' => getCurrentOrganisation()->id,
        'phone' => $validatedData['phone'] ?? null,
        'job' => $validatedData['job'] ?? null,
        'birth' => $validatedData['birth'] ?? null,
        'sex' => $validatedData['sex'] ?? null,
        'photo' => $photoPath,
      ];

      Member::create($memberData);

      DB::commit();

      return response()->json([
        'status' => 'success',
        'message' => __('Member created successfully'),
        'errors' => []
      ], 200);
    } catch (ValidationException $e) {
      DB::rollBack();
      return response()->json([
        'status' => 'error',
        'message' => __('Member creation failed'),
        'errors' => $e->errors(),
      ], 422);
    } catch (\Throwable $th) {
      dd($th);
      DB::rollBack();
      return response()->json([
        'status' => 'error',
        'message' => __('Member creation failed'),
        'errors' => $th->getMessage()
      ], 500);
    }
  }

  public function edit(Member $member)
  {
    $this->authorize('members.edit');
    return view('content.member.edit', compact('member'));
  }

  public function update(MemberRequest $request, Member $member)
  {
    $this->authorize('members.edit');
    DB::beginTransaction();
    try {
      $validatedData = $request->validated();

      // Update User
      $member->user->update([
        'name' => $validatedData['name'],
        'email' => $validatedData['email'],
      ]);

      // Handle Photo
      if ($request->hasFile('photo')) {
        if ($member->photo && Storage::exists('public/' . $member->photo)) {
          Storage::delete('public/' . $member->photo);
        }
        $member->photo = $request->file('photo')->store('members', 'public');
      }

      // Update Member fields
      $member->phone = $validatedData['phone'] ?? $member->phone;
      $member->job = $validatedData['job'] ?? $member->job;
      $member->birth = $validatedData['birth'] ?? $member->birth;
      $member->sex = $validatedData['sex'] ?? $member->sex;

      $member->save();

      DB::commit();

      return response()->json([
        'status' => 'success',
        'message' => __('Member updated successfully'),
        'errors' => []
      ], 200);
    } catch (ValidationException $e) {
      DB::rollBack();
      return response()->json([
        'status' => 'error',
        'message' => __('Member update failed'),
        'errors' => $e->errors(),
      ], 422);
    } catch (\Throwable $th) {
      DB::rollBack();
      return response()->json([
        'status' => 'error',
        'message' => __('Member update failed'),
        'errors' => $th->getMessage()
      ], 500);
    }
  }

  public function destroy(Member $member)
  {
    $this->authorize('members.destroy');
    DB::beginTransaction();
    try {
      if ($member->photo && Storage::exists('public/' . $member->photo)) {
        Storage::delete('public/' . $member->photo);
      }

      $user = $member->user;
      $member->delete();

      if ($user) {
        $user->delete();
      }

      DB::commit();

      return response()->json([
        'status' => 'success',
        'message' => __('Member deleted successfully')
      ]);
    } catch (\Exception $e) {
      DB::rollBack();
      return response()->json([
        'status' => 'error',
        'message' => __('Member deletion failed'),
        'error' => $e->getMessage()
      ], 500);
    }
  }
}
