<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentMenu;
use Illuminate\Http\Request;
use App\Models\DocumentGenrator;
use Illuminate\Support\Facades\Auth;

class DocumentMenuController extends Controller
{
    public function create($docmenuId)
    {
        $documents = DocumentGenrator::find($docmenuId);
        return view('admin.document-menu.create', compact('documents'));
    }

    public function store(Request $request)
    {
        request()->validate([
            'title'     => 'required|max:50',
        ]);
        $documentId             = $request->document_id;
        $docMenu                = new DocumentMenu();
        $docMenu->title         = $request->title;
        $docMenu->document_id   = $request->document_id;
        $docMenu->parent_id     = 0;
        $docMenu->tenant_id     = Auth::user()->tenant_id;
        $docMenu->save();
        return redirect()->route('document.design', $documentId)->with('success', __('Menu created successfully.'));
    }


    public function subMenuCreate($id, $docMenuId)
    {
        $documentMenu   = DocumentMenu::find($id);
        $document       = DocumentGenrator::find($docMenuId);
        return view('admin.document-menu.submenu-create', compact('documentMenu', 'document'));
    }

    public function subMenuStore(Request $request)
    {
        request()->validate([
            'title'     => 'required|max:50',
        ]);
        $documentId             = $request->document_id;
        $docMenu                = new DocumentMenu();
        $docMenu->title         = $request->title;
        $docMenu->document_id   = $request->document_id;
        $docMenu->parent_id     = $request->parent_id;
        $docMenu->tenant_id     = Auth::user()->tenant_id;
        $docMenu->save();
        return redirect()->route('document.design', $documentId)->with('success', __('Submenu created successfully.'));
    }

    public function destroy($id)
    {
        $documentMenu   = DocumentMenu::find($id);
        if ($documentMenu->parent_id == 0) {
            DocumentMenu::where('parent_id', $id)->delete();
        }
        $documentMenu->delete();
        return redirect()->route('document.index')->with('success', __('Documents deleted successfully.'));
    }

    public function subMenuDestroy($id)
    {
        $documentMenu   = DocumentMenu::find($id);
        $documentMenu->delete();
        return redirect()->route('document.index')->with('success', __('Documents deleted successfully.'));
    }
}
