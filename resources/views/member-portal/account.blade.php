@extends('member-portal.layout')

@section('content')
    <!-- Title section -->
    <div>
        <h5 class="mb-2 text-4xl font-bold tracking-tight 
        text-gray-900 dark:text-white text-center">
            Account
        </h5>
        <div class="mt-16 px-20">
            <div class="mb-4 border-b border-gray-200 dark:border-gray-700">
                <ul class="flex flex-wrap -mb-px text-sm font-medium text-center" id="myTab" data-tabs-toggle="#myTabContent" role="tablist">
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 rounded-t-lg" 
                        id="profile-tab" 
                        data-tabs-target="#profile" 
                        type="button" 
                        role="tab" 
                        aria-controls="profile" 
                        aria-selected="false">
                            Account Details
                        </button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent 
                        rounded-t-lg hover:text-gray-600 hover:border-gray-300 
                        dark:hover:text-gray-300" 
                        id="dashboard-tab" 
                        data-tabs-target="#dashboard" 
                        type="button" 
                        role="tab" 
                        aria-controls="dashboard" 
                        aria-selected="false">
                            Past Orders
                        </button>
                    </li>
                    <li class="mr-2" role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent 
                        rounded-t-lg hover:text-gray-600 hover:border-gray-300 
                        dark:hover:text-gray-300" 
                        id="settings-tab" 
                        data-tabs-target="#settings" 
                        type="button" 
                        role="tab" 
                        aria-controls="settings" 
                        aria-selected="false">
                            Payment Method
                        </button>
                    </li>
                    <li role="presentation">
                        <button class="inline-block p-4 border-b-2 border-transparent 
                        rounded-t-lg hover:text-gray-600 hover:border-gray-300 
                        dark:hover:text-gray-300" 
                        id="contacts-tab" 
                        data-tabs-target="#contacts" 
                        type="button" 
                        role="tab" 
                        aria-controls="contacts" 
                        aria-selected="false">
                            Subscription
                        </button>
                    </li>
                </ul>
            </div>
            <div id="myTabContent">
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <!-- <p class="text-sm text-gray-500 dark:text-gray-400">
                        This is some placeholder content the 
                        <strong class="font-medium text-gray-800 dark:text-white">Profile tab's associated content</strong>. 
                        Clicking another tab will toggle the visibility of this one for the next. 
                        The tab JavaScript swaps classes to control the content visibility and styling.
                    </p> -->
                    <form action="{{route('member-account-update', $project->name)}}" method="post">
                        @csrf
                        @method('put')
                        <div class="overflow-hidden shadow sm:rounded-md">
                            <div class="bg-white px-4 py-5 sm:p-6">
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                                        <input type="text" name="name" id="name" value="{{$user->name}}" autocomplete="given-name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                        <input type="email" name="email" id="email" value="{{$user->email}}" autocomplete="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" required>
                                    </div>
                                </div>
                                <div class="grid grid-cols-6 gap-6 mt-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="password" class="block text-sm font-medium text-gray-700">New Password (Leave blank if no change)</label>
                                        <input type="password" name="password" id="new-password" autocomplete="new-password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    </div>
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="old-password" class="block text-sm font-medium text-gray-700">Current Password* (required to make changes)</label>
                                        <input type="password" name="old_password" id="old-password" autocomplete="old-password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                    </div>
                                </div>
                            </div>
                            <div class="bg-white px-4 py-3 text-right sm:px-6">
                                <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                    <!-- <p class="text-sm text-gray-500 dark:text-gray-400">
                        This is some placeholder content the 
                        <strong class="font-medium text-gray-800 dark:text-white">Dashboard tab's associated content</strong>. 
                        Clicking another tab will toggle the visibility of this one for the next. 
                        The tab JavaScript swaps classes to control the content visibility and styling.
                    </p> -->
                </div>
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                    <!-- <p class="text-sm text-gray-500 dark:text-gray-400">
                        This is some placeholder content the 
                        <strong class="font-medium text-gray-800 dark:text-white">Settings tab's associated content</strong>. 
                        Clicking another tab will toggle the visibility of this one for the next. 
                        The tab JavaScript swaps classes to control the content visibility and styling.
                    </p> -->
                </div>
                <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="contacts" role="tabpanel" aria-labelledby="contacts-tab">
                    <!-- <p class="text-sm text-gray-500 dark:text-gray-400">
                        This is some placeholder content the 
                        <strong class="font-medium text-gray-800 dark:text-white">Contacts tab's associated content</strong>. 
                        Clicking another tab will toggle the visibility of this one for the next. 
                        The tab JavaScript swaps classes to control the content visibility and styling.
                    </p> -->
                </div>
            </div>
        </div>
    </div>
@endsection