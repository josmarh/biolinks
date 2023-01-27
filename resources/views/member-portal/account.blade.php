@extends('member-portal.layout')

@section('content')
@if (\Session::has('success'))
    <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-100 dark:bg-gray-800 dark:text-green-400" role="alert">
        {!! \Session::get('success') !!}
    </div>
@elseif(\Session::has('error'))
    <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
        {!! \Session::get('error') !!}
    </div>
@endif
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
                        <div class="bg-white px-4 py-3 text-left sm:px-6">
                            <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">Save</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="dashboard" role="tabpanel" aria-labelledby="dashboard-tab">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 mb-4">
                    <thead class="text-sm text-gray-700 capitalize bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">product</th>
                            <th scope="col" class="px-6 py-3">order type</th>
                            <th scope="col" class="px-6 py-3">date</th>
                            <th scope="col" class="px-6 py-3">total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                        <tr v-for="item in data" :key="item.id"
                            class="bg-white border-b hover:bg-gray-50">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                                {{$order->description}}
                            </th>
                            <td class="px-6 py-4">
                                {{ $order->order_type }}
                            </td>
                            <td class="px-6 py-4">
                                {{ $order->created_at->format('Y-m-d') }}
                            </td>
                            <td class="px-6 py-4">
                                ${{ $order->total }}
                            </td>
                        </tr>
                        @empty
                            <p>No orders</p>
                        @endforelse
                    </tbody>
                </table>
                {{ $orders->links() }}
            </div>
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="settings" role="tabpanel" aria-labelledby="settings-tab">
                <form action="{{route('member-paymethod-update', $project->name)}}" method="post" class="mt-4">
                    @csrf
                    @method('put')
                    <h1 class="text-gray-600 font-medium text-lg">Update your payment method</h1>
                    <hr class="w-full">
                    <div class="mt-4 w-96">
                        <div class="flex rounded-md shadow-sm">
                            <input type="text" name="card_number"
                            class="block w-full flex-1 rounded-none rounded-l-md 
                            border-gray-300 focus:border-indigo-500 
                            focus:ring-indigo-500 sm:text-sm"
                            value="{{$paymentMethod->card_number}}" 
                            placeholder="Card number">
                            <span class="inline-flex items-center rounded-r-md border border-l-0 border-gray-300 bg-gray-50 px-3 text-sm text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 text-gray-500">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 8.25h19.5M2.25 9h19.5m-16.5 5.25h6m-6 2.25h3m-3.75 3h15a2.25 2.25 0 002.25-2.25V6.75A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25v10.5A2.25 2.25 0 004.5 19.5z" />
                                </svg>
                            </span>
                        </div>
                        <div class="md:flex gap-2 mt-3 w-96">
                            <div class="flex input-group w-full">
                                <select class="block w-full rounded-none rounded-l-md 
                                    border-gray-300 focus:border-indigo-500 
                                    focus:ring-indigo-500 sm:text-sm" name="card_month">
                                    <option value="">MM</option>
                                    @foreach(range(1, 12) as $month)
                                        <option value="{{$month}}" {{ $paymentMethod->card_month == $month ? "selected" : "" }}>{{$month}}</option>
                                    @endforeach
                                </select>
                                <select class="block w-full rounded-none rounded-r-md 
                                    border-gray-300 focus:border-indigo-500 
                                    focus:ring-indigo-500 sm:text-sm" name="card_year">
                                    <option value="">YYYY</option>
                                    @foreach(range(date('Y'), date('Y') + 10) as $year)
                                        <option value="{{$year}}" {{ $paymentMethod->card_year == $year ? "selected" : "" }}>{{$year}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-full">
                                <input type="text" name="card_cvv" 
                                class="block flex-1 rounded-md 
                                border-gray-300 focus:border-indigo-500 
                                focus:ring-indigo-500" 
                                value="{{$paymentMethod->card_cvv}}" 
                                placeholder="CVV">
                            </div>
                        </div>
                    </div>
                    <div class="bg-white px-4 py-3 text-left sm:px-6 mt-8">
                        <button type="submit" class="inline-flex justify-center rounded-md border border-transparent bg-indigo-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-0 focus:ring-indigo-500 focus:ring-offset-2">Save</button>
                    </div>
                </form>
            </div>
            <div class="hidden p-4 rounded-lg bg-gray-50 dark:bg-gray-800" id="contacts" role="tabpanel" aria-labelledby="contacts-tab">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 mb-4">
                    <thead class="text-sm text-gray-700 capitalize bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">product</th>
                            <th scope="col" class="px-6 py-3">date</th>
                            <th scope="col" class="px-6 py-3">total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($subscriptions as $order)
                        <tr v-for="item in data" :key="item.id"
                            class="bg-white border-b hover:bg-gray-50">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 dark:text-white whitespace-nowrap">
                            <span class="font-medium">Membership Plan:</span> {{$order->description}}
                            </th>
                            <td class="px-6 py-4">
                                {{ $order->created_at->format('Y-m-d') }}
                            </td>
                            <td class="px-6 py-4">
                                ${{ $order->total }}
                            </td>
                        </tr>
                        @empty
                            <p>No orders</p>
                        @endforelse
                    </tbody>
                </table>
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</div>
@endsection