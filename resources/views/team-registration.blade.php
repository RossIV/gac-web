@extends('layouts.app', ['title' => 'Team Registration'])
@section('content')
    <div>
        <form action="#" method="POST">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900">Team</h3>
                        <p class="mt-1 text-sm text-gray-600">What dost thou call thine selves?</p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <div class="shadow sm:rounded-md sm:overflow-hidden">
                        <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-3 sm:col-span-2">
                                    <label for="team_name" class="block text-sm font-medium text-gray-700"> Team
                                        Name </label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="text" name="team_name" id="team_name"
                                               class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300">
                                    </div>
                                </div>
                            </div>
                            <div class="grid grid-cols-3 gap-6">
                                <div class="col-span-3 sm:col-span-2">
                                    <label for="team_motto" class="block text-sm font-medium text-gray-700"> Team
                                        Motto </label>
                                    <div class="mt-1 flex rounded-md shadow-sm">
                                        <input type="text" name="team_motto" id="team_motto"
                                               class="focus:ring-indigo-500 focus:border-indigo-500 flex-1 block w-full rounded-none rounded-r-md sm:text-sm border-gray-300">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hidden sm:block" aria-hidden="true">
                <div class="py-3">
                    <div class="border-t border-gray-200"></div>
                </div>
            </div>
            <div class="mt-10 sm:mt-0">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px-0">
                            <h3 class="text-lg font-medium leading-6 text-gray-900">Team Members</h3>
                            <p class="mt-1 text-sm text-gray-600">Please provide information for all team members.</p>
                        </div>
                    </div>
                    <div class="mt-5 md:mt-0 md:col-span-2">
                        <div class="shadow overflow-hidden sm:rounded-md">
                            <div class="px-4 py-3 bg-white sm:px-6">
                                <button type="button" class="ml-5 bg-white py-2 px-3 border border-gray-300 rounded-md shadow-sm text-sm leading-4 font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">Add Team Member</button>
                            </div>
                            <div class="px-4 py-5 bg-white sm:p-6">
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="first-name" class="block text-sm font-medium text-gray-700">First name</label>
                                        <input type="text" name="first-name" id="first-name" autocomplete="given-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>

                                    <div class="col-span-6 sm:col-span-3">
                                        <label for="last-name" class="block text-sm font-medium text-gray-700">Last name</label>
                                        <input type="text" name="last-name" id="last-name" autocomplete="family-name" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
