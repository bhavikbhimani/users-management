<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Users') }}
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
                    <h2 class="text-2xl font-bold mb-8">List of Users</h2>
                </div>
                <br>

                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width:15%;">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width:25%;">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width:15%;">Phone Number</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width:25%;">Friend Request</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider" style="width:20%;">Chat With User</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users as $index => $user)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $index + 1 }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div style="display: flex; align-items: center;">
                                    <div style="flex-shrink: 0; height: 40px; width: 40px; border-radius: 9999px; overflow: hidden;">
                                        <img style="height: 100%; width: 100%; object-fit: cover;" src="{{ $user->profile_photo_path ? $user->profile_photo_path : asset('default.png')  }}" alt="{{ $user->name }}">
                                    </div>
                                    <div style="margin-left: 10px;">
                                        <div style="font-size: 14px; font-weight: 500; color: #374151;">{{ $user->name }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->phone_number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($user->is_send_friend_request == 'not_send')
                                <form action="{{ route('users.send-request', $user) }}" method="POST" class="inline">
                                    @csrf
                                    <button style="background-color: lightcoral;" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Send Friend Request</button>
                                </form>
                                @endif
                                @if ($user->is_send_friend_request == 'pending')
                                <span style="color:#ffcc00;"><b>Pending</b></span>
                                @endif
                                @if ($user->is_send_friend_request == 'accepted')
                                <span style="color:green;"><b>Accepted</b></span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if ($user->is_send_friend_request == 'accepted')
                                <form action="{{ route('users.chat', $user) }}" method="POST" class="inline">
                                    @csrf
                                    <button style="background-color: lightblue;" class="bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">Chat Now</button>
                                </form>
                                @else
                                <button disabled style="background-color: lightblue;" class="bg-gray-300 text-gray-500 font-bold py-2 px-4 rounded cursor-not-allowed">Chat Now</button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 whitespace-nowrap text-center">No Users Available</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>