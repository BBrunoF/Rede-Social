
<div>
  <div class="flex justify-between mb-4" style="padding-top: 20px;">
    <div class="flex-1 pr-4">
        &nbsp; <input wire:model.debounce.300ms="search" type="text" class="form-input w-30 rounded-lg border border-gray-300 focus:border-gray-500" placeholder="Search users by username...">
    </div>
  </div>
<div class="flex flex-col p-4">
  <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8 ">
    <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
      <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg rounded-xl shadow-sm">
        <table class="min-w-full divide-y divide-gray-200">
          <thead class="bg-gray-50">
            <tr>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Name
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Account
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Details
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Role
              </th>
              <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                Actions
              </th>
              
              <th scope="col" class="relative px-6 py-3">
                <span class="sr-only">Edit</span>
              </th>
            </tr>
          </thead>
          <tbody class="bg-white divide-y divide-gray-200">
          
          @foreach($users as $user)
            <tr>
              <td class="px-6 py-4 whitespace-nowrap">
               <a href="{{ route('profile', ['username' => $user->username]) }}">
                <div class="flex items-center">
                  <div class="flex-shrink-0 h-10 w-10">
                  
                    <img class="h-10 w-10 rounded-full" src="{{ $user->profile_photo_url }}" alt="">
                  </div>
                  <div class="ml-4">
                    <div class="text-sm font-medium text-gray-900">
                      {{ $user->name }}
                    </div>
                    <div class="text-sm text-gray-500">
                      {{ $user->email }}
                    </div>
                  </div>
                </div>
                </a>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
              <a href="{{ route('profile', ['username' => $user->username]) }}">
                <div class="text-sm text-gray-900">{{ '@'. $user->username }}</div>
               </a>
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
               <ul>
                <li class="text-sm text-gray-900">Followers : <span class="text-green-500"> {{ $user->followers_count }} </span></li>
                <li class="text-sm text-gray-900">Followings : <span class="text-red-500"> {{ $user->followings_count }} </span></li>
                <li class="text-sm text-gray-900">Posts : <span class="text-blue-500"> {{ $user->posts_count }} </span></li>
               </ul>
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                @if($user->role_id === 2)
	                Admin
                @elseif ($user->role_id === 1)
	                User
                @else
                  Banned
                @endif
              </td>
              <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                <a href="{{ route('users.edit', ['user' => $user->id ]) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
              </td>
            </tr>
            @endforeach
            
            <!-- More people... -->
          </tbody>
        </table>
        {{ $users->links() }}
      </div>
    </div>
  </div>
</div>

</div>
