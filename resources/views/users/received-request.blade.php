<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pending Request') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-8xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
               @if (session('success'))
               <div style="background-color:hsl(110.77deg 100% 85.69%);" class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Success!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
            @endif
            @if (session('error'))
            <div style="background-color: hsl(348.77deg 100% 82.88%);" class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Error!</strong>
                <span class="block sm:inline">{{ session('error') }}</span>
            </div>
            @endif
            <div class="p-6 sm:px-20 bg-white border-b border-gray-200" style="overflow: scroll;">
                <div class="flex justify-between items-center">
                    <h2 class="text-2xl font-bold mb-8">List of Pending Request</h2>
                </div>
                <br>

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width:20%;">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width:30%;">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width:20%;">Phone Number</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width:30%;">Action</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($requests as $index => $request)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $request->user->name }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $request->user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $request->user->phone_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($request->status == 'pending')
                                <form action="{{ route('friend-requests.accept', $request) }}" method="POST" class="inline">
                                    @csrf
                                    <button style="background-color: lightgreen;" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Accept</button>
                                </form>
                                &nbsp;&nbsp;&nbsp;
                                <form action="{{ route('friend-requests.reject', $request) }}" method="POST" class="inline">
                                    @csrf
                                    <button style="background-color: lightpink;" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Reject</button>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center">No Request Available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $requests->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>