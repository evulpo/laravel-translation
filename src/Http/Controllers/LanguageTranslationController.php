<?php

namespace JoeDixon\Translation\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use JoeDixon\Translation\Drivers\Translation;
use JoeDixon\Translation\Http\Requests\TranslationRequest;
use JoeDixon\Translation\Language;
use JoeDixon\Translation\Http\Requests\TranslationRequestAll;
use JoeDixon\Translation\Drivers;	

class LanguageTranslationController extends Controller
{
    private $translation;

    public function __construct(Translation $translation)
    {
        $this->translation = $translation;
    }

    public function index(Request $request, $language)
    {
        if ($request->has('language') && $request->get('language') !== $language) {
            return redirect()
                ->route('languages.translations.index', ['language' => $request->get('language'), 'group' => $request->get('group'), 'filter' => $request->get('filter')]);
        }

        $languages = $this->translation->allLanguages();
        $groups = $this->translation->getGroupsFor(config('app.locale'))->merge('single');
        $translations = $this->translation->filterTranslationsFor($language, $request->get('filter'));

        if ($request->has('group') && $request->get('group')) {
            if ($request->get('group') === 'single') {
                $translations = $translations->get('single');
                $translations = new Collection(['single' => $translations]);
            } else {
                $translations = $translations->get('group')->filter(function ($values, $group) use ($request) {
                    return $group === $request->get('group');
                });

                $translations = new Collection(['group' => $translations]);
            }
        }

        return view('translation::languages.translations.index', compact('language', 'languages', 'groups', 'translations'));
    }

    public function create(Request $request, $language)	
    {	
        $languages = Language::get();	
        	
        $arr = [];	
        foreach($languages as $i => $lang){	
            if($lang['name'] !== Null){	
                $arr[$i] = $lang['language'];	
            }	
        }	
        return view('translation::languages.translations.create', compact('language', 'arr'));	
    }

    public function updateTranslation(Request $request, $language, $group, $key) {
        $languages = Language::get();	
        $languageArr = [];
        $translations = [];	

        foreach($languages as $i => $lang){	
            if($lang['name'] !== Null){	
                $translationValue = Language::where('language', $lang['language'])
                ->first()
                ->translations()
                ->where('group', $group)
                ->where('key', $key)
                ->orderBy('status', 'asc')
                ->select('value')
                ->first()
                ->value;

                $translations[$i] = [
                    'language' => $lang['language'],
                    'value' => $translationValue
                ];

                $languageArr[$i] = $lang['language'];
            }
        }	
        return view('translation::languages.translations.update', compact('language', 'group', 'key', 'translations'));	
    }

    public function storeAll(TranslationRequestAll $request, $language){	
        	
        $languages = Language::get();
        if ($request->filled('group')) {	
            $namespace = $request->has('namespace') && $request->get('namespace') ? "{$request->get('namespace')}::" : '';	
            foreach($languages as $i => $lang){	
                $this->translation->addGroupTranslation($lang->name,("{$namespace}{$request->get('group')}"),($request->get('key')), $request['value'.$i]);	
            }
        } else {	
            foreach($languages as $i => $lang){	
                $this->translation->addSingleTranslation($lang->name, 'single',($request->get('key')), $request['value'.$i]);	
            }	
        }	
        return redirect()	
            ->route('languages.translations.index', $language)	
            ->with('success', __('New translations added successfull 🙌'));

    }

    public function update(Request $request, $language)
    {
        if (! Str::contains($request->get('group'), 'single')) {
            $this->translation->addGroupTranslation($language, $request->get('group'), $request->get('key'), $request->get('value') ?: '');
        } else {
            $this->translation->addSingleTranslation($language, $request->get('group'), $request->get('key'), $request->get('value') ?: '');
        }

        return ['success' => true];
    }
}
