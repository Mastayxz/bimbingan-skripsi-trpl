@extends('layouts.app')

@section('content')
    <div class="container mx-auto px-4 py-6">
        <a href="{{ route('admin.periode.create') }}" class="text-indigo-600 hover:text-indigo-800 mb-4 inline-block">
            <button
                class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:bg-indigo-700 dark:hover:bg-indigo-600">
                Tambah Periode
            </button>
        </a>
        <table class="min-w-full bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden">
            <thead>
                <tr class="bg-gray-100 dark:bg-gray-700 text-left text-sm font-medium text-gray-700 dark:text-gray-300">
                    <th class="px-6 py-3">Nama Periode</th>
                    <th class="px-6 py-3">Tanggal Mulai</th>
                    <th class="px-6 py-3">Tanggal Akhir</th>
                    <th class="px-6 py-3">Status</th>
                    <th class="px-6 py-3">Aksi</th>
                </tr>
            </thead>
            <tbody class="text-sm text-gray-700 dark:text-gray-300">
                @foreach ($periodes as $periode)
                    <tr class="border-t border-gray-200 dark:border-gray-600">
                        <td class="px-6 py-3">{{ $periode->nama_periode }}</td>
                        <td class="px-6 py-3">{{ $periode->tanggal_mulai }}</td>
                        <td class="px-6 py-3">{{ $periode->tanggal_akhir }}</td>
                        <td class="px-6 py-3">
                            @if ($periode->status == 'dibuka')
                                <span
                                    class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-xs font-semibold">Dibuka</span>
                            @else
                                <span
                                    class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-xs font-semibold">Ditutup</span>
                            @endif
                        </td>
                        <td class="px-6 py-3">
                            <form action="{{ route('admin.periode.status', $periode->id) }}" method="POST">
                                @csrf
                                @method('POST')
                                <select name="status" onchange="this.form.submit()"
                                    class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-white border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 dark:focus:ring-indigo-500 dark:focus:border-indigo-500">
                                    <option value="dibuka" {{ $periode->status == 'dibuka' ? 'selected' : '' }}>Dibuka
                                    </option>
                                    <option value="ditutup" {{ $periode->status == 'ditutup' ? 'selected' : '' }}>Ditutup
                                    </option>
                                </select>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
