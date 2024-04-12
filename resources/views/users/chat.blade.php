<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Chat Now') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <h2 class="text-2xl font-bold mb-8">Chat With {{ $user->name }}</h2>

                <!-- Chat Messages -->
                <div id="chat-messages" class="mb-6">
                    <!-- Messages will be dynamically added here -->
                </div>

                <!-- Chat Form -->
                <form id="chat-form">
                    <div class="flex items-center">
                        <input type="text" name="message" id="message" class="w-full border-gray-300 rounded-md px-4 py-2 mr-2 focus:outline-none focus:border-blue-400" placeholder="Type your message...">
                        <button type="submit" class="bg-blue-500 text-white rounded-md px-4 py-2 focus:outline-none hover:bg-blue-600">Send</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>