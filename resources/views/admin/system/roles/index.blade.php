@extends('admin.layouts.app')

@section('title', 'Role & Permission')

@section('content')
    <x-admin.page-header title="Role & Permission" description="Daftar peran dan jumlah izin yang dimiliki masing-masing role." />

    <x-admin.card>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-ink-200 text-sm">
                <thead>
                    <tr class="bg-ink-50 text-left text-xs font-semibold uppercase tracking-wide text-ink-500">
                        <th class="px-4 py-3">Role</th>
                        <th class="px-4 py-3">Slug</th>
                        <th class="px-4 py-3 text-center">Pengguna</th>
                        <th class="px-4 py-3 text-center">Jumlah Izin</th>
                        <th class="px-4 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-ink-100">
                    @forelse ($roles as $role)
                        <tr>
                            <td class="px-4 py-3">
                                <span class="flex h-8 w-8 items-center justify-center rounded-full bg-brand-100 text-xs font-bold text-brand-700">
                                    {{ mb_substr($role->name, 0, 1) }}
                                </span>
                                <span class="ml-2 font-medium text-ink-900">{{ $role->name }}</span>
                            </td>
                            <td class="px-4 py-3 text-ink-600">{{ $role->slug }}</td>
                            <td class="px-4 py-3 text-center text-ink-600">{{ $role->users_count }}</td>
                            <td class="px-4 py-3 text-center text-ink-600">{{ $role->permissions_count }}</td>
                            <td class="px-4 py-3 text-right">
                                <a href="{{ route('admin.system.roles.edit', $role) }}" class="rounded-md border border-ink-200 px-3 py-1.5 text-xs font-semibold text-ink-700 transition hover:bg-ink-50">
                                    Kelola Izin
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-4 py-10 text-center text-ink-500">
                                Belum ada role.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </x-admin.card>
@endsection
