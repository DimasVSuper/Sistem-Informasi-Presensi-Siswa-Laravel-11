@extends('app')

@section('title', 'Admin Login - PresensiGo')

@section('content')
<div class="flex items-center justify-center min-h-[80vh]">
    <div class="bg-white p-8 lg:p-10 rounded-3xl shadow-xl border border-gray-100 w-full max-w-md animate-fade-in-up">
        <div class="text-center mb-8">
            <div class="w-16 h-16 bg-indigo-50 text-indigo-600 rounded-2xl mx-auto flex items-center justify-center mb-4">
                <i data-feather="lock" class="w-8 h-8"></i>
            </div>
            <h1 class="text-2xl font-bold text-gray-900 tracking-tight">Admin Login</h1>
            <p class="text-sm text-gray-500 mt-2">Gunakan kredensial admin untuk masuk.</p>
        </div>

        @if($errors->any())
            <div class="bg-red-50 text-red-600 p-4 rounded-xl text-sm mb-6 border border-red-100 flex items-start">
                <i data-feather="x-circle" class="w-5 h-5 mr-2 mt-0.5 animate-pulse"></i>
                <span class="font-medium">{{ $errors->first() }}</span>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            
            <div class="mb-5">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Email Address</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i data-feather="mail" class="w-5 h-5 text-gray-400"></i>
                    </div>
                    <input type="email" name="email" value="{{ old('email') }}" required 
                        class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all text-sm font-medium text-gray-800"
                        placeholder="admin@admin.com">
                </div>
            </div>

            <div class="mb-8">
                <div class="flex justify-between items-center mb-2">
                    <label class="block text-sm font-semibold text-gray-700">Password</label>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                        <i data-feather="key" class="w-5 h-5 text-gray-400"></i>
                    </div>
                    <input type="password" name="password" required 
                        class="w-full pl-11 pr-4 py-3 bg-gray-50 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-all text-sm font-medium text-gray-800"
                        placeholder="••••••••">
                </div>
            </div>

            <button type="submit" class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white font-bold py-3.5 rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all shadow-lg hover:shadow-indigo-500/30 flex justify-center items-center">
                Masuk ke Dashboard <i data-feather="arrow-right" class="w-4 h-4 ml-2"></i>
            </button>
        </form>
    </div>
</div>
@endsection
