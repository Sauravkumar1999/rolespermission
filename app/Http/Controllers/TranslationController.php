<?php

namespace App\Http\Controllers;

use App\DataTables\Editor\TranslationDatatableEditor;
use App\DataTables\TableView\TranslationDataTable;
use App\DataTables\TableView\TranslationLanguageDataTable;
use App\DataTables\Editor\TranslationLanguageDataTableEditor;
use App\Models\TranslationLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class TranslationController extends Controller
{
    public function index(TranslationLanguageDataTable $datatable)
    {
        return $datatable->render('dashboard.translation.language',['pageTitle'=> __('translation.translation')]);
    }

    public function process(Request $request ,TranslationLanguageDataTableEditor $editor)
    {
        return $editor->process($request);
    }

    public function language(TranslationDataTable $datatable, $slug)
    {
        if (TranslationLanguage::where('slug', $slug)->doesntExist()) return redirect()->back();
        return $datatable->render('dashboard.translation.index',['pageTitle'=>  __('translation.translation').' '.$slug]);
    }

    public function languageProcess(Request $request, TranslationDatatableEditor $editor)
    {
        return $editor->process($request);
    }

    public function change($slug)
    {
        Session::put('locale', $slug);
        return redirect()->back();
    }
}
