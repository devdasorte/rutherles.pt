<?php

namespace App\Http\Controllers\Admin;

use App\Models\DocumentGenrator;
use Illuminate\Http\Request;
use App\DataTables\Admin\DocumentGenratorDataTable;
use App\Facades\UtilityFacades;
use App\Http\Controllers\Controller;
use App\Models\DocumentMenu;
use App\Models\Plan;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class DocumentGenratorController extends Controller
{
    public function index(DocumentGenratorDataTable $dataTable)
    {
        if (\Auth::user()->can('manage-document')) {
            return $dataTable->render('admin.document.index');
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function create()
    {
        $settingData    = UtilityFacades::getsettings('plan_setting');
        $plans          = json_decode($settingData, true);
        $document       = DocumentGenrator::all()->count();
        if ($document < $plans['max_documents']) {
            if (\Auth::user()->can('create-document')) {
                $colors     = [
                    ''          => __('Select Color'),
                    'info'      => 'info',
                    'primary'   => 'primary',
                    'success'   => 'success',
                    'danger'    => 'danger',
                    'warning'   => 'warning',
                    'light'     => 'light',
                ];
                $planId = Auth::user()->plan_id;
                $plan   = tenancy()->central(function ($tenant) use ($planId) {
                    return Plan::where('id', $planId)->first();
                });
                if ($plan->documentation == 'limited') {
                    $documents  = DocumentGenrator::all()->count();
                    if ($plan->limited > $documents) {
                        return view('admin.document.create', compact('colors'));
                    } else {
                        return redirect()->back()->with('failed', __('Document limit low.'));
                    }
                } else {
                    return view('admin.document.create', compact('colors'));
                }
            } else {
                return redirect()->back()->with('failed', __('Permission denied.'));
            }
        } else {
            return redirect()->back()->with('failed', __('Please update your plan because documents limit low.'));
        }
    }

    public function store(Request $request)
    {
        if (\Auth::user()->can('create-document')) {
            request()->validate([
                'title'         => 'required|max:191',
                'document_logo' => 'required|mimes:png,jpg,jpeg,image',
                'theme'         => 'required',
            ]);
            $fileName   = '';
            if (request()->file('document_logo')) {
                $allowedfileExtension   = ['jpeg', 'jpg', 'png'];
                $file                   = $request->file('document_logo');
                $extension              = $file->getClientOriginalExtension();
                $check                  = in_array($extension, $allowedfileExtension);
                if ($check) {
                    $fileName           = $file->store('document-logo');
                } else {
                    return redirect()->route('admin.document.index')->with('failed', __('File type not valid.'));
                }
            }
            $document           = new DocumentGenrator();
            $document->title                = $request->title;
            $document->tenant_id            = Auth::user()->tenant_id;
            $document->logo                 = $fileName;
            $document->theme                = $request->theme;
            $document->change_log_status    = ($request->change_log_status) ? 'on' : 'off';
            $document->change_log_json      = ($request->change_log_status && $request->change_log_json) ? json_encode($request->change_log_json) : null;
            $document->save();
            return redirect()->route('document.index')->with('success', __('Documents created successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function edit($id)
    {
        if (\Auth::user()->can('edit-document')) {
            $colors     = [
                ''          => __('Select Color'),
                'info'      => 'info',
                'primary'   => 'primary',
                'success'   => 'success',
                'danger'    => 'danger',
                'warning'   => 'warning',
                'light'     => 'light',
            ];
            $document = DocumentGenrator::find($id);
            return view('admin.document.edit', compact('document', 'colors'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function update(Request $request, DocumentGenrator $document)
    {
        if (\Auth::user()->can('edit-document')) {
            request()->validate([
                'title' => 'required|max:191',
                'theme' => 'required',
                'slug'  => 'required|unique:document_genrators,slug,' . $document->id,
            ]);
            $fileName   = $document->logo;
            if (request()->file('document_logo')) {
                $allowedfileExtension   = ['jpeg', 'jpg', 'png'];
                $file                   = $request->file('document_logo');
                $extension              = $file->getClientOriginalExtension();
                $check                  = in_array($extension, $allowedfileExtension);
                if ($check) {
                    $fileName           = $file->store('document_logo');
                } else {
                    return redirect()->route('admin.document.index')->with('failed', __('File type not valid.'));
                }
            }
            $document->title                = $request->title;
            $document->slug                 = $request->slug;
            $document->logo                 = $fileName;
            $document->change_log_status    = ($request->change_log_status) ? 'on' : 'off';
            $document->change_log_json      = ($request->change_log_status && $request->change_log_json) ? json_encode($request->change_log_json) : null;
            $document->theme                = $request->theme;
            $document->tenant_id            = Auth::user()->tenant_id;
            $document->save();
            return redirect()->route('document.index')
                ->with('success',  __('Documents updated successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function destroy($id)
    {
        if (\Auth::user()->can('delete-document')) {
            $document   = DocumentGenrator::find($id);
            $document->delete();
            return redirect()->route('document.index')->with('success', __('Documents deleted successfully.'));
        } else {
            return redirect()->back()->with('failed', __('Permission denied.'));
        }
    }

    public function documentStatus($id)
    {
        $document   = DocumentGenrator::find($id);
        if ($document->status == 1) {
            $document->status   = 0;
            $document->save();
            return redirect()->back()->with('success', __('Documents deactiveted successfully.'));
        } else {
            $document->status   = 1;
            $document->save();
            return redirect()->back()->with('success', __('Documents activeted successfully.'));
        }
    }

    public function updateDesign(Request $request)
    {
        $documentMenu   = $request->all();
        foreach ($documentMenu['position'] as $key => $item) {
            $documentMenu           = DocumentMenu::where('id', '=', $item)->first();
            $documentMenu->position = $key;
            $documentMenu->save();
        }
    }

    public function design($id)
    {
        $document   = DocumentGenrator::find($id);
        $docmenu    = DocumentMenu::where('document_id', $id)->orderBy('position')->get();
        $menus      = DocumentMenu::find($id);
        return view('admin.document.design', compact('document', 'docmenu', 'menus'));
    }

    public function documentDesignMenu(Request $request, $id)
    {
        $data = '';
        $documentMenu = DocumentMenu::orderBy('position')->find($id);
        $data .= '<div id="editorjs" data-json=' . $documentMenu->json . ' data-id=' . $documentMenu->id . '> </div>';
        $id = $documentMenu->id;
        if ($request->html) {
            $documentMenu->html = $request->html;
        } else {
            $documentMenu->html = $data;
        }
        if ($documentMenu) {
            if ($request->value) {
                $documentMenu->json = $request->value;
            }
            $val = $request->value;
            $arr = [];
            if (isset($val)) {
                foreach ($val as $k => $fields) {
                    if ($fields['type'] == "heading" || $fields['type'] == "paragraph") {
                        $arr[$k] = $fields['type'];
                    } else {
                        $arr[$k] = $fields['type'];
                    }
                }
            }
            $documentMenu->save();
            Session::flash('success', __('Documents updated successfully.'));
        } else {
            Session::flash('failed', __('Documents not found.'));
        }
        return response()->json([
            'is_success'    => true,
            'title'         => $documentMenu->title,
            'json'          => $documentMenu->json,
            'html'          => $documentMenu->html,
            'id'            => $id
        ], 200);
    }

    public function documentPublic($slug)
    {
        if ($slug) {
            $menus          = DocumentMenu::where('slug', $slug)->first();
            $document       = DocumentGenrator::where('id', $menus->document_id)->first();
            $changeLogJsons = json_decode($document->change_log_json, true);
            $docMenu        = DocumentMenu::where('document_id', $document->id)->orderBy('position')->get();
            $documentValue  = null;
            if ($document->status == 1) {
                foreach ($docMenu as $key => $value) {
                    $parentArray[] = $value->parent_id;
                }
                if ($document) {
                    $array  = $document->getFormArray();
                    if (isset($parentArray)) {
                        return view("admin.document.front.$document->theme.index", compact('document', 'documentValue', 'docMenu', 'changeLogJsons', 'array', 'menus', 'parentArray'));
                    } else {
                        return view("admin.document.front.$document->theme.index", compact('document', 'documentValue', 'docMenu', 'array', 'menus'));
                    }
                } else {
                    return redirect()->back()->with('failed', __('Form not found.'));
                }
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    public function documentPublicMenu(Request $request, $slug, $changeLog = '')
    {
        $documentMenu   = DocumentMenu::where('slug', $slug)->first();
        $id             = $documentMenu->id;
        $docMenu        = DocumentMenu::where('document_id', $documentMenu->document_id)->orderBy('position')->get();
        $document       = DocumentGenrator::find($documentMenu->document_id);
        $changeLogJsons = json_decode($document->change_log_json, true);
        $menus          = DocumentMenu::find($id);
        foreach ($docMenu as $key => $value) {
            $parentArray[] = $value->parent_id;
        }
        return view("admin.document.front.$document->theme.index", compact('documentMenu', 'id', 'docMenu', 'document', 'menus', 'changeLogJsons', 'parentArray', 'changeLog'));
    }

    public function documentPublicSubmenu(Request $request, $slug, $slugmenu, $changeLog = '')
    {
        $documentMenu   = DocumentMenu::where('slug', $slugmenu)->first();
        $id             = $documentMenu->id;
        $docMenu        = DocumentMenu::where('document_id', $documentMenu->document_id)->orderBy('position')->get();
        $document       = DocumentGenrator::find($documentMenu->document_id);
        $changeLogJsons = json_decode($document->change_log_json, true);
        $menus          = DocumentMenu::where('slug', $slug)->first();
        foreach ($docMenu as $key => $value) {
            $parentArray[] = $value->parent_id;
        }
        return view("admin.document.front.$document->theme.index", compact('documentMenu', 'id', 'docMenu', 'document', 'changeLogJsons', 'menus', 'parentArray'));
    }
}
