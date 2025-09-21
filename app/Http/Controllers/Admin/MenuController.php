<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class MenuController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $menus = Menu::with(['parent', 'children'])
            ->orderBy('posicao')
            ->orderBy('ordem')
            ->paginate(20);

        return view('admin.menus.index', compact('menus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menusParent = Menu::whereNull('parent_id')
            ->where('tipo', '!=', 'divider')
            ->orderBy('titulo')
            ->get();

        $rotas = $this->getRotasDisponiveis();

        return view('admin.menus.create', compact('menusParent', 'rotas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:menus,slug',
            'url' => 'nullable|string|max:500',
            'rota' => 'nullable|string|max:255',
            'icone' => 'nullable|string|max:100',
            'posicao' => 'required|in:header,footer,ambos',
            'tipo' => 'required|in:link,dropdown,divider',
            'parent_id' => 'nullable|exists:menus,id',
            'ordem' => 'nullable|integer|min:0',
            'ativo' => 'boolean',
            'nova_aba' => 'boolean',
            'permissao' => 'nullable|string|max:100',
            'descricao' => 'nullable|string|max:1000'
        ], [
            'titulo.required' => 'O título é obrigatório.',
            'slug.unique' => 'Este slug já está em uso.',
            'posicao.required' => 'A posição é obrigatória.',
            'tipo.required' => 'O tipo é obrigatório.',
            'parent_id.exists' => 'Menu pai inválido.'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $data = $request->all();
            
            // Gerar slug se não fornecido
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['titulo']);
            }

            // Definir ordem se não fornecida
            if (empty($data['ordem'])) {
                $maxOrdem = Menu::where('posicao', $data['posicao'])
                    ->where('parent_id', $data['parent_id'])
                    ->max('ordem');
                $data['ordem'] = ($maxOrdem ?? 0) + 1;
            }

            // Validar URL ou rota
            if (empty($data['url']) && empty($data['rota']) && $data['tipo'] !== 'divider') {
                return back()->with('error', 'URL ou rota é obrigatória para itens que não são divisores.')->withInput();
            }

            Menu::create($data);

            return redirect()->route('admin.menus.index')
                ->with('success', 'Menu criado com sucesso!');

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao criar menu: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Menu $menu)
    {
        $menu->load(['parent', 'children']);
        return view('admin.menus.show', compact('menu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Menu $menu)
    {
        $menusParent = Menu::whereNull('parent_id')
            ->where('tipo', '!=', 'divider')
            ->where('id', '!=', $menu->id)
            ->orderBy('titulo')
            ->get();

        $rotas = $this->getRotasDisponiveis();

        return view('admin.menus.edit', compact('menu', 'menusParent', 'rotas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Menu $menu)
    {
        $validator = Validator::make($request->all(), [
            'titulo' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:menus,slug,' . $menu->id,
            'url' => 'nullable|string|max:500',
            'rota' => 'nullable|string|max:255',
            'icone' => 'nullable|string|max:100',
            'posicao' => 'required|in:header,footer,ambos',
            'tipo' => 'required|in:link,dropdown,divider',
            'parent_id' => 'nullable|exists:menus,id',
            'ordem' => 'nullable|integer|min:0',
            'ativo' => 'boolean',
            'nova_aba' => 'boolean',
            'permissao' => 'nullable|string|max:100',
            'descricao' => 'nullable|string|max:1000'
        ], [
            'titulo.required' => 'O título é obrigatório.',
            'slug.unique' => 'Este slug já está em uso.',
            'posicao.required' => 'A posição é obrigatória.',
            'tipo.required' => 'O tipo é obrigatório.',
            'parent_id.exists' => 'Menu pai inválido.'
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $data = $request->all();
            
            // Gerar slug se não fornecido
            if (empty($data['slug'])) {
                $data['slug'] = Str::slug($data['titulo']);
            }

            // Validar URL ou rota
            if (empty($data['url']) && empty($data['rota']) && $data['tipo'] !== 'divider') {
                return back()->with('error', 'URL ou rota é obrigatória para itens que não são divisores.')->withInput();
            }

            // Verificar se não está tentando ser pai de si mesmo
            if ($data['parent_id'] == $menu->id) {
                return back()->with('error', 'Um menu não pode ser pai de si mesmo.')->withInput();
            }

            $menu->update($data);

            return redirect()->route('admin.menus.index')
                ->with('success', 'Menu atualizado com sucesso!');

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao atualizar menu: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Menu $menu)
    {
        try {
            // Verificar se tem filhos
            if ($menu->children()->exists()) {
                return back()->with('error', 'Não é possível excluir um menu que possui submenus. Exclua os submenus primeiro.');
            }

            $menu->delete();

            return redirect()->route('admin.menus.index')
                ->with('success', 'Menu excluído com sucesso!');

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao excluir menu: ' . $e->getMessage());
        }
    }

    /**
     * Toggle status do menu
     */
    public function toggleStatus(Menu $menu)
    {
        try {
            $menu->update(['ativo' => !$menu->ativo]);

            $status = $menu->ativo ? 'ativado' : 'desativado';
            return response()->json([
                'success' => true,
                'message' => "Menu {$status} com sucesso!",
                'status' => $menu->ativo
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao alterar status: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Reordenar menus
     */
    public function reorder(Request $request)
    {
        try {
            $items = $request->input('items', []);

            foreach ($items as $index => $item) {
                Menu::where('id', $item['id'])->update([
                    'ordem' => $index + 1,
                    'parent_id' => $item['parent_id'] ?? null
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Ordem dos menus atualizada com sucesso!'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erro ao reordenar menus: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obter rotas disponíveis do sistema
     */
    private function getRotasDisponiveis(): array
    {
        $rotas = [];
        
        try {
            $routeCollection = \Route::getRoutes();
            
            foreach ($routeCollection as $route) {
                $name = $route->getName();
                if ($name && !str_contains($name, 'admin.') && !str_contains($name, 'debugbar')) {
                    $rotas[$name] = $name;
                }
            }
            
            ksort($rotas);
        } catch (\Exception $e) {
            // Em caso de erro, retornar rotas básicas
            $rotas = [
                'home' => 'home',
                'vereadores.index' => 'vereadores.index',
                'sessoes.index' => 'sessoes.index',
                'ouvidoria.index' => 'ouvidoria.index',
                'esic.index' => 'esic.index'
            ];
        }

        return $rotas;
    }
}
