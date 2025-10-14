<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Theme;

class ThemeController extends Controller
{
    public function index()
    {
        $themes = Theme::orderByDesc('is_active')
            ->orderBy('name')
            ->paginate(15);
        // Considera tema efetivamente ativo (ativo manualmente OU agendado dentro do intervalo)
        $activeTheme = Theme::effectiveActive()->first();
        return view('admin.temas.index', compact('themes', 'activeTheme'));
    }

    public function create()
    {
        return view('admin.temas.create');
    }

    public function store(Request $request)
    {
        $data = $this->validateData($request);
        // Normalizar checkboxes (quando desmarcados não vêm no payload)
        $data['ribbon_enabled'] = $request->boolean('ribbon_enabled');
        $data['mourning_enabled'] = $request->boolean('mourning_enabled');
        $data['ribbon_link_external'] = $request->boolean('ribbon_link_external');
        $data['ribbon_campaign_link_external'] = $request->boolean('ribbon_campaign_link_external');
        $data['ribbon_mourning_link_external'] = $request->boolean('ribbon_mourning_link_external');
        $data['slug'] = Str::slug($data['name']);

        // garantir slug único
        if (Theme::where('slug', $data['slug'])->exists()) {
            return back()->withErrors(['name' => 'Já existe um tema com esse nome.'])->withInput();
        }

        Theme::create($data);
        return redirect()->route('admin.temas.index')->with('success', 'Tema criado com sucesso.');
    }

    public function edit(Theme $theme)
    {
        return view('admin.temas.edit', compact('theme'));
    }

    public function update(Request $request, Theme $theme)
    {
        $data = $this->validateData($request, $theme->id);
        // Normalizar checkboxes (quando desmarcados não vêm no payload)
        $data['ribbon_enabled'] = $request->boolean('ribbon_enabled');
        $data['mourning_enabled'] = $request->boolean('mourning_enabled');
        $data['ribbon_link_external'] = $request->boolean('ribbon_link_external');
        $data['ribbon_campaign_link_external'] = $request->boolean('ribbon_campaign_link_external');
        $data['ribbon_mourning_link_external'] = $request->boolean('ribbon_mourning_link_external');

        // atualizar slug caso o nome mude
        if (isset($data['name']) && $data['name'] !== $theme->name) {
            $newSlug = Str::slug($data['name']);
            if (Theme::where('slug', $newSlug)->where('id', '!=', $theme->id)->exists()) {
                return back()->withErrors(['name' => 'Já existe um tema com esse nome.'])->withInput();
            }
            $data['slug'] = $newSlug;
        }

        $theme->update($data);
        return redirect()->route('admin.temas.index')->with('success', 'Tema atualizado com sucesso.');
    }

    public function destroy(Theme $theme)
    {
        if ($theme->is_active) {
            return back()->with('error', 'Não é possível excluir o tema ativo. Desative antes de excluir.');
        }
        $theme->delete();
        return redirect()->route('admin.temas.index')->with('success', 'Tema excluído com sucesso.');
    }

    public function activate(Theme $theme)
    {
        DB::transaction(function () use ($theme) {
            Theme::where('is_active', true)->update(['is_active' => false]);
            $theme->is_active = true;
            // quando ativado manualmente, remove agendamento (opcional)
            $theme->is_scheduled = false;
            $theme->start_date = now();
            $theme->end_date = $theme->end_date; // manter se houver
            $theme->save();
        });

        return redirect()->route('admin.temas.index')->with('success', 'Tema ativado com sucesso.');
    }

    public function schedule(Request $request, Theme $theme)
    {
        $validated = $request->validate([
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
        ]);

        $theme->update([
            'is_scheduled' => true,
            'start_date' => $validated['start_date'],
            'end_date' => $validated['end_date'] ?? null,
        ]);

        return redirect()->route('admin.temas.index')->with('success', 'Agendamento atualizado para o tema.');
    }

    public function preview(Theme $theme)
    {
        // Redireciona para a home com o parâmetro de preview
        $url = url('/').'?theme_preview='.$theme->slug;
        return redirect($url)->with('success', 'Pré-visualização aplicada. Você está vendo o site com o tema "'.$theme->name.'".');
    }

    private function validateData(Request $request, ?int $themeId = null): array
    {
        // Permitir hex para cores e strings livres para backgrounds (hex ou gradient CSS)
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'primary_color' => ['required', 'regex:/^#?[0-9a-fA-F]{6}$/'],
            'secondary_color' => ['nullable', 'regex:/^#?[0-9a-fA-F]{6}$/'],
            'accent_color' => ['nullable', 'regex:/^#?[0-9a-fA-F]{6}$/'],
            // Novas variáveis de tema (opcionais)
            'primary_dark' => ['nullable', 'regex:/^#?[0-9a-fA-F]{6}$/'],
            'light' => ['nullable', 'regex:/^#?[0-9a-fA-F]{6}$/'],
            'border' => ['nullable', 'regex:/^#?[0-9a-fA-F]{6}$/'],
            'text_muted' => ['nullable', 'regex:/^#?[0-9a-fA-F]{6}$/'],

            'success_bg' => ['nullable', 'regex:/^#?[0-9a-fA-F]{6}$/'],
            'success_text' => ['nullable', 'regex:/^#?[0-9a-fA-F]{6}$/'],
            'info_bg' => ['nullable', 'regex:/^#?[0-9a-fA-F]{6}$/'],
            'info_text' => ['nullable', 'regex:/^#?[0-9a-fA-F]{6}$/'],
            'warning_bg' => ['nullable', 'regex:/^#?[0-9a-fA-F]{6}$/'],
            'warning_text' => ['nullable', 'regex:/^#?[0-9a-fA-F]{6}$/'],
            'danger_bg' => ['nullable', 'regex:/^#?[0-9a-fA-F]{6}$/'],
            'danger_text' => ['nullable', 'regex:/^#?[0-9a-fA-F]{6}$/'],
            'secondary_bg' => ['nullable', 'regex:/^#?[0-9a-fA-F]{6}$/'],
            'secondary_text' => ['nullable', 'regex:/^#?[0-9a-fA-F]{6}$/'],
            'menu_bg' => ['nullable', 'string', 'max:255'],
            'footer_bg' => ['nullable', 'string', 'max:255'],
            'section_bg' => ['nullable', 'string', 'max:255'],
            // Controles do lacinho
            'ribbon_enabled' => ['nullable', 'boolean'],
            'ribbon_variant' => ['nullable', 'in:october_pink,september_yellow,november_blue,mourning_black'],
            'ribbon_primary' => ['nullable', 'regex:/^#?[0-9a-fA-F]{6}$/'],
            'ribbon_base' => ['nullable', 'regex:/^#?[0-9a-fA-F]{6}$/'],
            'ribbon_stroke' => ['nullable', 'regex:/^#?[0-9a-fA-F]{6}$/'],
            'mourning_enabled' => ['nullable', 'boolean'],
            'ribbon_label' => ['nullable', 'string', 'max:255'],
            'ribbon_link_url' => ['nullable', 'string', 'max:255'],
            'ribbon_link_external' => ['nullable', 'boolean'],
            // Campos específicos por lacinho
            'ribbon_campaign_label' => ['nullable', 'string', 'max:255'],
            'ribbon_campaign_link_url' => ['nullable', 'string', 'max:255'],
            'ribbon_campaign_link_external' => ['nullable', 'boolean'],
            'ribbon_mourning_label' => ['nullable', 'string', 'max:255'],
            'ribbon_mourning_link_url' => ['nullable', 'string', 'max:255'],
            'ribbon_mourning_link_external' => ['nullable', 'boolean'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'is_scheduled' => ['nullable', 'boolean'],
        ], [
            'primary_color.regex' => 'Informe uma cor válida em hexadecimal (ex: #FF0000).',
            'secondary_color.regex' => 'Informe uma cor válida em hexadecimal (ex: #00FF00).',
            'accent_color.regex' => 'Informe uma cor válida em hexadecimal (ex: #0000FF).',
            'primary_dark.regex' => 'Informe uma cor válida em hexadecimal.',
            'light.regex' => 'Informe uma cor válida em hexadecimal.',
            'border.regex' => 'Informe uma cor válida em hexadecimal.',
            'text_muted.regex' => 'Informe uma cor válida em hexadecimal.',
            'success_bg.regex' => 'Informe uma cor válida em hexadecimal.',
            'success_text.regex' => 'Informe uma cor válida em hexadecimal.',
            'info_bg.regex' => 'Informe uma cor válida em hexadecimal.',
            'info_text.regex' => 'Informe uma cor válida em hexadecimal.',
            'warning_bg.regex' => 'Informe uma cor válida em hexadecimal.',
            'warning_text.regex' => 'Informe uma cor válida em hexadecimal.',
            'danger_bg.regex' => 'Informe uma cor válida em hexadecimal.',
            'danger_text.regex' => 'Informe uma cor válida em hexadecimal.',
            'secondary_bg.regex' => 'Informe uma cor válida em hexadecimal.',
            'secondary_text.regex' => 'Informe uma cor válida em hexadecimal.',
            'ribbon_primary.regex' => 'Informe uma cor válida em hexadecimal.',
            'ribbon_base.regex' => 'Informe uma cor válida em hexadecimal.',
            'ribbon_stroke.regex' => 'Informe uma cor válida em hexadecimal.',
        ]);

        return $data;
    }
}