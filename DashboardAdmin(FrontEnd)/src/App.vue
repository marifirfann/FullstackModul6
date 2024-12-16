<template>
  <div class="flex flex-col h-screen">
    <!-- Header -->
    <header class="sticky top-0 inset-x-0 flex flex-wrap justify-between bg-white border-b text-sm py-2.5 z-50">
      <nav class="flex w-full items-center px-4 sm:px-6">
  <!-- Logo -->
<div class="flex">
  <router-link to="/" class="block py-2 text-gray-800 hover:bg-gray-100">
    <div class="flex items-center">
      <img class="w-[50px]" src="/img/kamsa/KAMSA KOGO 1.png" alt="Logo" />
      <p class="ml-[0px]">DASHBOARD</p>
    </div>
  </router-link>
</div>



        <!-- Search and Profile -->
        <div class="w-full flex items-center justify-end gap-x-3">
          <div class=" md:block">
            <div class="relative">
              <div class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                  viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                  stroke-linejoin="round">
                  <circle cx="11" cy="11" r="8" />
                  <path d="M21 21l-4.3-4.3" />
                </svg>
              </div>
              <input type="text" placeholder="Search"
                class="block w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md text-sm focus:outline-none" />
            </div>
          </div>

          <!-- Profile Dropdown -->
          <ul class="flex items-center gap-3 font-bold text-[15px] md:flex">
            <li class="relative">
              <button id="profile-button"
                class="w-[40px] h-[40px] rounded-full text-white flex items-center justify-center overflow-hidden">
                <img src="/img/icon/user.png" alt="Profile" class="w-full h-full object-cover" />
              </button>
              <div id="profile-dropdown" class="absolute hidden bg-white shadow-lg rounded-md right-0 top-10 w-[150px]">
                <ul class="space-y-2 p-2 text-gray-500">
                  <li><a href="Account.html" class="block px-4 py-2 text-sm">Account</a></li>
                  <li><a href="Logout.html" class="block px-4 py-2 text-sm">Log Out</a></li>
                </ul>
              </div>
            </li>
          </ul>
        </div>
      </nav>
    </header>

    <!-- Main Content Area -->
    <div class="flex h-full">
      <!-- Sidebar -->
      <div class="bg-white border-e w-[260px] hidden lg:block">
        <nav class="p-3">
          <ul class="space-y-2">
    <li>
        <router-link to="/" class="block py-2 text-gray-800 hover:bg-gray-100">
            <!-- Home Icon -->
            <svg class="shrink-0 w-5 h-5 inline-block mr-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z" />
                <polyline points="9 22 9 12 15 12 15 22" />
            </svg>
            Home
        </router-link>
    </li>
    <li>
        <router-link to="/pembeli" class="block py-2 text-gray-800 hover:bg-gray-100">
            <!-- Pembeli Icon -->
            <svg class="shrink-0 w-5 h-5 inline-block mr-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2" />
                <circle cx="9" cy="7" r="4" />
                <path d="M22 21v-2a4 4 0 0 0-3-3.87" />
                <path d="M16 3.13a4 4 0 0 1 0 7.75" />
            </svg>
            Pembeli
        </router-link>
    </li>
    <li>
        <router-link to="/product" class="block py-2 text-gray-800 hover:bg-gray-100">
            <!-- Product Icon -->
            <svg class="shrink-0 w-5 h-5 inline-block mr-2" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <rect x="3" y="4" width="18" height="16" rx="2" ry="2"></rect>
                <path d="M8 2v4"></path>
                <path d="M16 2v4"></path>
                <path d="M3 10h18"></path>
            </svg>
            Product
        </router-link>
    </li>
</ul>


        </nav>
      </div>

      <!-- Content -->
      <div class="flex-grow mt-4 overflow-y-auto">
        <router-view /> <!-- Dynamic content will be rendered here -->
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'App',
};
</script>

<style scoped>
/* Navbar Styling */
.navbar {
  background-color: #ffffff;
  border-bottom: 1px solid #ddd;
}

.navbar-brand {
  font-size: 1.25rem;
}

.nav-link {
  color: #333;
}

.nav-link:hover {
  color: #17a2b8;
}

/* Sidebar Styling */
.bg-dark {
  background-color: #343a40 !important;
}

.nav-link.text-white {
  color: white;
}

.nav-link.text-white:hover {
  color: #17a2b8 !important;
}

/* Main Layout Styling */
body {
  font-family: 'Arial', sans-serif;
  background-color: #f8f9fa;
  display: flex;
  flex-direction: column;
  height: 100vh;
}

.container {
  flex-grow: 1;
}

/* Profile Dropdown */
#profile-button {
  cursor: pointer;
}

#profile-dropdown {
  display: none;
}

#profile-button:focus+#profile-dropdown {
  display: block;
}
</style>
