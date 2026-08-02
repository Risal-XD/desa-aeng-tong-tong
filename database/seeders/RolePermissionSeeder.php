<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Definisi modul dan aksi permission.
     *
     * @var array<string, array{label: string, actions: list<string>}>
     */
    private const MODULES = [
        'dashboard' => ['label' => 'Dashboard', 'actions' => ['view']],
        'village' => ['label' => 'Data Desa', 'actions' => ['view', 'edit']],
        'structure' => ['label' => 'Struktur Organisasi', 'actions' => ['view', 'create', 'edit', 'delete']],
        'official' => ['label' => 'Perangkat Desa', 'actions' => ['view', 'create', 'edit', 'delete']],
        'category' => ['label' => 'Kategori Konten', 'actions' => ['view', 'create', 'edit', 'delete']],
        'profile' => ['label' => 'Profil Desa', 'actions' => ['view', 'edit']],
        'history' => ['label' => 'Sejarah Desa', 'actions' => ['view', 'edit']],
        'vision-mission' => ['label' => 'Visi & Misi', 'actions' => ['view', 'edit']],
        'potential' => ['label' => 'Potensi Desa', 'actions' => ['view', 'create', 'edit', 'delete']],
        'news' => ['label' => 'Berita', 'actions' => ['view', 'create', 'edit', 'delete']],
        'announcement' => ['label' => 'Pengumuman', 'actions' => ['view', 'create', 'edit', 'delete']],
        'agenda' => ['label' => 'Agenda', 'actions' => ['view', 'create', 'edit', 'delete']],
        'faq' => ['label' => 'FAQ', 'actions' => ['view', 'create', 'edit', 'delete']],
        'gallery' => ['label' => 'Galeri Foto', 'actions' => ['view', 'create', 'edit', 'delete']],
        'video' => ['label' => 'Video', 'actions' => ['view', 'create', 'edit', 'delete']],
        'banner' => ['label' => 'Banner', 'actions' => ['view', 'create', 'edit', 'delete']],
        'tourism' => ['label' => 'Wisata', 'actions' => ['view', 'create', 'edit', 'delete']],
        'keris' => ['label' => 'Kerajinan Keris & Mpu', 'actions' => ['view', 'create', 'edit', 'delete']],
        'umkm' => ['label' => 'UMKM', 'actions' => ['view', 'create', 'edit', 'delete']],
        'statistic' => ['label' => 'Statistik Desa', 'actions' => ['view', 'create', 'edit', 'delete']],
        'apbdes' => ['label' => 'APBDes', 'actions' => ['view', 'create', 'edit', 'delete']],
        'document' => ['label' => 'Dokumen', 'actions' => ['view', 'create', 'edit', 'delete']],
        'message' => ['label' => 'Pesan Masuk', 'actions' => ['view', 'edit']],
        'contact' => ['label' => 'Kontak Desa', 'actions' => ['view', 'edit']],
        'user' => ['label' => 'Manajemen Pengguna', 'actions' => ['view', 'create', 'edit', 'delete']],
        'role' => ['label' => 'Role & Permission', 'actions' => ['view', 'create', 'edit', 'delete']],
        'setting' => ['label' => 'Pengaturan Website', 'actions' => ['view', 'edit']],
        'activity-log' => ['label' => 'Activity Log', 'actions' => ['view']],
    ];

    private const ACTION_LABELS = [
        'view' => 'Melihat',
        'create' => 'Membuat',
        'edit' => 'Mengubah',
        'delete' => 'Menghapus',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $allSlugs = $this->seedPermissions();

        $this->seedRole(Role::SUPER_ADMIN, 'Super Admin', $allSlugs);
        $this->seedRole(Role::ADMIN, 'Administrator', $this->adminPermissions($allSlugs));
        $this->seedRole(Role::EDITOR, 'Editor Konten', $this->editorPermissions($allSlugs));

        $this->seedUsers();
    }

    /**
     * @return list<string>
     */
    private function seedPermissions(): array
    {
        $slugs = [];

        foreach (self::MODULES as $module => $config) {
            foreach ($config['actions'] as $action) {
                $slug = "{$module}-{$action}";
                $name = self::ACTION_LABELS[$action].' '.$config['label'];

                Permission::updateOrCreate(
                    ['slug' => $slug],
                    ['name' => $name, 'group' => $config['label']],
                );

                $slugs[] = $slug;
            }
        }

        return $slugs;
    }

    private function seedRole(string $slug, string $name, array $permissionSlugs): void
    {
        $role = Role::updateOrCreate(
            ['slug' => $slug],
            ['name' => $name],
        );

        $permissionIds = Permission::whereIn('slug', $permissionSlugs)->pluck('id')->all();
        $role->permissions()->sync($permissionIds);
    }

    /**
     * @param  list<string>  $all
     * @return list<string>
     */
    private function adminPermissions(array $all): array
    {
        return array_values(array_filter(
            $all,
            fn (string $slug): bool => ! str_starts_with($slug, 'user-') && ! str_starts_with($slug, 'role-'),
        ));
    }

    /**
     * Editor: konten & ekonomi & data, tanpa hak hapus dan tanpa modul sistem/master/profil.
     *
     * @param  list<string>  $all
     * @return list<string>
     */
    private function editorPermissions(array $all): array
    {
        $modules = [
            'dashboard',
            'potential',
            'news',
            'announcement',
            'agenda',
            'faq',
            'gallery',
            'video',
            'banner',
            'tourism',
            'keris',
            'umkm',
            'statistic',
            'apbdes',
            'document',
        ];
        $allowedActions = ['view', 'create', 'edit'];

        return array_values(array_filter(
            $all,
            function (string $slug) use ($modules, $allowedActions): bool {
                [$module, $action] = explode('-', $slug, 2);

                return in_array($module, $modules, true) && in_array($action, $allowedActions, true);
            },
        ));
    }

    private function seedUsers(): void
    {
        $this->createUser(
            'superadmin@aengtongtong.desa.id',
            'Super Admin',
            Role::SUPER_ADMIN,
        );

        $this->createUser(
            'admin@aengtongtong.desa.id',
            'Admin Desa',
            Role::ADMIN,
        );

        $this->createUser(
            'editor@aengtongtong.desa.id',
            'Editor Konten',
            Role::EDITOR,
        );
    }

    private function createUser(string $email, string $name, string $roleSlug): void
    {
        $user = User::updateOrCreate(
            ['email' => $email],
            ['name' => $name, 'password' => 'password'],
        );

        $user->syncRoles([$roleSlug]);
    }
}
