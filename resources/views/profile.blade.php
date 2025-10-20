<x-app-layout>
	
	<livewire:profile.profile-page :user="$user"  />
	@if(session()->has('success'))
		<div class="bg-green-100 border my-3 border-green-400 text-green-700 dark:bg-green-700 dark:border-green-600 dark:text-green-100 px-4 py-3 rounded relative" role="alert">
			<span class="block sm:inline text-center">{{ session()->get('success') }}</span>
		</div>
	@endif
	<livewire:posts.view :type="'me'" :user="$user" />
	
</x-app-layout>