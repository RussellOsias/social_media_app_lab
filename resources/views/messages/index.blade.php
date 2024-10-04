@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6 bg-black text-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-semibold mb-4">Messages</h2>

    <div class="space-y-4">
        @if($messages->isEmpty())
            <div class="bg-gray-800 p-4 rounded-lg shadow-md">
                <p class="text-gray-400">You have no messages.</p>
            </div>
        @else
            @foreach($messages as $message)
                <div class="bg-gray-800 p-4 rounded-lg shadow-md">
                    <h3 class="text-lg font-medium">{{ $message->sender_name }}</h3>
                    <p class="text-gray-300">{{ Str::limit($message->content, 100) }}</p>
                    <small class="text-gray-500">{{ $message->created_at->diffForHumans() }}</small>
                    <a href="{{ route('messages.show', $message->id) }}" class="text-red-600 hover:underline">View Message</a>
                </div>
            @endforeach
        @endif
    </div>
</div>
@endsection
