<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Delegate;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $companies = Company::with('owner')->where("owner_id", Auth::id())->limit(10)->get()->toArray();
        return view('companies.list', compact('companies'));
    }

    public function add()
    {
        $users = User::whereNot('id', Auth::id())->get()->toArray();
        return view('companies.add', compact('users'));
    }

    public function getCompanies(Request $request)
    {
        try {
            $companies = Company::with('owner')->where("owner_id", Auth::id())->get()->toArray();
            return response()->json(['success' => true, 'title' => 'Success', 'type' => 'success', 'message' => "Received Companies", 'data' => $companies]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'title' => 'Error', 'type' => 'error', 'message' => $th->getMessage()]);
        }
    }

    public function store(Request $request)
    {
        try {

            $request->validate([
                'company.owner_id' => 'bail|required',
                'delegates.id' => 'bail|required',
                'company.name' => 'required',
                'company.contact' => 'required|max:5000',
                'company.email' => 'required|max:255',
            ]);

            $company = Company::create($request->get('company'));
            (new Delegate())->storeDelegates($request->get('delegates'), $company->id);
            if ($company) {
                return response()->json(['success' => true, 'title' => 'success', 'type' => 'success', 'message' => 'Company added Successfully.']);
            }

            return response()->json(['success' => false, 'title' => 'success', 'type' => 'error', 'message' => 'Something went Wrong.']);

        } catch (\Throwable $ex) {
            return response()->json(['success' => false, 'message' => $ex->getMessage() . ' on line ' . $ex->getLine() . ' on file ' . $ex->getFile()]);
        }
    }

    public function deleteCompanies(Request $request)
    {
        try {
            $id = $request->get('id');
            Delegate::where('company_id', $id)->delete();

            if (Company::where('id', $id)->delete()) {
                return response()->json(['success' => true, 'message' => 'Company Deleted Successfully!', 'type' => 'success', 'title' => 'Success!']);
            }

            return response()->json(['success' => false, 'message' => 'Unable to Delete Company!', 'type' => 'danger', 'title' => 'Error!']);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'Something went wrong in deleting Company', 'type' => 'danger', 'title' => 'Error!']);
        }
    }

    public function deleteDelegates(Request $request)
    {
        try {
            $id = $request['id'];
            $delete = Delegate::where('id', $id)->delete();
            if ($delete) {
                $delete = Delegate::where('company_id', $id)->delete();
                return response()->json(['success' => true, 'message' => 'Delegate Deleted Successfully!', 'type' => 'success', 'title' => 'Success!']);
            }

            return response()->json(['success' => false, 'message' => 'Unable to Delete Delegate!', 'type' => 'danger', 'title' => 'Error!']);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => 'Something went wrong in deleting Delegate', 'type' => 'danger', 'title' => 'Error!']);
        }
    }

    public function storePermissions(Request $request)
    {
        try {
            $input = $request->except('_token');
            $delete = Permission::where(['delegates_id' => $input['delegates_id'], 'owner_id' => $input['owner_id']])->delete();

            $permissions = Permission::create([
                "owner_id" => $input['owner_id'],
                "delegates_id" => $input['delegates_id'],
                "create_permission" => $input['create_permission'] ?? 0,
                "update_permission" => $input['update_permission'] ?? 0,
                "delete_permission" => $input['delete_permission'] ?? 0,
            ]);
            if ($permissions) {
                return response()->json(['success' => true, 'title' => 'success', 'type' => 'success', 'message' => 'Permissions added Successfully.']);
            } else {
                return response()->json(['success' => false, 'title' => 'success', 'type' => 'error', 'message' => 'Something went Wrong.']);
            }
        } catch (\Throwable $ex) {
            return response()->json(['success' => false, 'message' => $ex->getMessage() . ' on line ' . $ex->getLine() . ' on file ' . $ex->getFile()]);
        }
    }

    public function storeDelegates(Request $request)
    {
        try {
            $input = $request->except('_token');
            $check = Delegate::where(['user_id' => $input['user_id'], 'company_id' => $input['company_id']])->first();
            if (empty($check)) {
                $delegates = Delegate::create($input);
            } else {
                return response()->json(['success' => false, 'title' => 'success', 'type' => 'error', 'message' => 'Delegate Already Exist.']);
            }
            if ($delegates) {
                return response()->json(['success' => true, 'title' => 'success', 'type' => 'success', 'message' => 'Delegates added Successfully.']);
            } else {
                return response()->json(['success' => false, 'title' => 'success', 'type' => 'error', 'message' => 'Something went Wrong.']);
            }
        } catch (\Throwable $ex) {
            return response()->json(['success' => false, 'message' => $ex->getMessage() . ' on line ' . $ex->getLine() . ' on file ' . $ex->getFile()]);
        }
    }

    public function switchCompany(Request $request)
    {
        $company = Company::findOrFail($request->input('company_id'));
        session()->put('current_company', $company);
        return redirect()->back();
    }

    public function switchUser(Request $request)
    {
        $request->session()->forget('current_company');
        return redirect()->back();
    }
}
