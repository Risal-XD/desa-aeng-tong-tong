<?php

declare(strict_types=1);

namespace App\Http\Controllers\Admin\MasterData;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\MasterData\CategoryRequest;
use App\Models\GalleryCategory;
use App\Models\NewsCategory;
use App\Models\VideoCategory;
use App\Services\ActivityLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /** @var array<string, class-string> */
    private const MODELS = [
        'news' => NewsCategory::class,
        'gallery' => GalleryCategory::class,
        'video' => VideoCategory::class,
    ];

    public function __construct(
        private readonly ActivityLogService $activityLog,
    ) {}

    public function index(): View
    {
        $type = $this->currentType();
        $this->authorizeType($type);

        $categories = $this->model($type)::query()
            ->orderBy('id')
            ->paginate(15);

        return view('admin.master-data.categories.index', compact('type', 'categories'));
    }

    public function create(): View
    {
        $type = $this->currentType();
        $this->authorizeType($type);

        return view('admin.master-data.categories.create', compact('type'));
    }

    public function store(CategoryRequest $request): RedirectResponse
    {
        $type = $this->currentType();
        $this->authorizeType($type);

        $category = $this->model($type)::create($request->safe()->all());

        $this->activityLog->log('Menambahkan kategori', 'created', $category, ['name' => $category->name, 'type' => $type]);

        return redirect()->route('admin.master-data.categories.'.$type.'.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function edit(int $category): View
    {
        $type = $this->currentType();
        $this->authorizeType($type);

        $category = $this->model($type)::findOrFail($category);

        return view('admin.master-data.categories.edit', compact('type', 'category'));
    }

    public function update(CategoryRequest $request, int $category): RedirectResponse
    {
        $type = $this->currentType();
        $this->authorizeType($type);

        $category = $this->model($type)::findOrFail($category);
        $category->update($request->safe()->all());

        $this->activityLog->log('Memperbarui kategori', 'updated', $category, ['name' => $category->name, 'type' => $type]);

        return back()->with('success', 'Kategori berhasil diperbarui.');
    }

    public function destroy(int $category): RedirectResponse
    {
        $type = $this->currentType();
        $this->authorizeType($type);

        $category = $this->model($type)::findOrFail($category);
        $name = $category->name;

        $category->delete();

        $this->activityLog->log('Menghapus kategori', 'deleted', null, ['name' => $name, 'type' => $type]);

        return redirect()->route('admin.master-data.categories.'.$type.'.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }

    private function currentType(): string
    {
        $type = (string) request()->route('type');

        abort_unless(array_key_exists($type, self::MODELS), 404);

        return $type;
    }

    private function authorizeType(string $type): void
    {
        $this->authorize('viewAny', $this->model($type));
    }

    private function model(string $type): string
    {
        return self::MODELS[$type];
    }
}
