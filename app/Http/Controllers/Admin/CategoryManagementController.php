<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WalletType;
use App\Models\Category;

class CategoryManagementController extends Controller
{
    protected array $walletTypeConfigs;
    protected array  $typeConfig;
    private const PER_PAGE = 10;

    public function __construct()
    {
        $this->middleware('can:manage-users');

        $this->walletTypeConfigs = config('wallet_types');
        $this->typeConfig = config('category_types');
    }

    public function index(Request $request)
    {
        $query = Category::query()
            ->with([
                'parent:id,name',
                'creator:id,name',
                'walletTypes:id,name'
            ]);

        if ($search = $request->input('search')) {
            $query->where('name', 'like', "%{$search}%");
        }

        if ($type = $request->input('type')) {
            $query->where('type', $type);
        }

        if ($walletType = $request->input('wallet_type')) {
            $query->whereHas('walletTypes', function ($q) use ($walletType) {
                $q->where('wallet_types.id', $walletType);
            });
        }

        $categories = tap($query->paginate(self::PER_PAGE))->withQueryString();

        $categories->getCollection()->transform(function ($category) {
            $wallets = $category->walletTypes ?? collect();

            $category->wallet_display = $wallets->map(function ($wallet) {
                $config = $this->walletTypeConfigs[$wallet->name] ?? [
                    'label' => $wallet->name,
                    'class' => 'text-gray-400'
                ];

                return [
                    'label' => $config['label'],
                    'class' => $config['class'],
                ];
            });

            return $category;
        });

        $typeConfig = collect($this->typeConfig);

        $walletTypes = WalletType::all(['id', 'name']);
        $walletConfig = collect($walletTypes)->mapWithKeys(function ($item) {
            $config = $this->walletTypeConfigs[$item->name] ?? ['label' => $item->name, 'class' => 'text-gray-400'];
            return [$item->id => array_merge($config, ['name' => $item->name])];
        });

        return view('admin.category-management.index', compact('categories', 'typeConfig', 'walletConfig'));
    }

    public function destroy(Category $category)
    {
        try {
            $category->delete();

            return redirect()->route('categories.index')
                ->with('success', __('category.deleted_success'));
        } catch (\Exception $e) {
            return redirect()->route('categories.index')
                ->with('error', __('category.deleted_error'));
        }
    }
}
