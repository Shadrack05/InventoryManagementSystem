<template>
    <div id="app"
    class="flex h-screen bg-gray-50 dark:bg-gray-900"
    :class="{ 'overflow-hidden': isSideMenuOpen, 'theme-dark': dark }"
  >
    <!-- Desktop sidebar -->
    <aside
      class="z-20 hidden w-64 overflow-y-auto bg-white dark:bg-gray-800 md:block flex-shrink-0"
    >
      <div class="py-4 text-gray-500 dark:text-gray-400">
        <a
          class="ml-6 text-2xl font-bold text-gray-800 dark:text-gray-200"
          href="#"
        >
          Inventory360
        </a>
        <ul class="mt-6">
          <li v-if="Roles.includes('admin')" class="relative px-6 py-3">
            <span
            v-if="currentView === 'HomeComponent'"
              class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
              aria-hidden="true"
            ></span>
            <a
            :class="{ 'dark:text-gray-100': currentView ==='HomeComponent'}"
              class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
              href="#"
              @click="currentView = 'HomeComponent'"
            >
              <svg
                class="w-5 h-5"
                aria-hidden="true"
                fill="none"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                ></path>
              </svg>
              <span class="ml-4">Admin Dashboard</span>
            </a>
          </li>
          <li v-if="hasBranchRole" class="relative px-6 py-3">
            <span
            v-if="currentView === 'branchStatComponent'"
              class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
              aria-hidden="true"
            ></span>
            <a
            :class="{ 'dark:text-gray-100': currentView ==='HomeComponent'}"
              class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
              href="#"
              @click="currentView = 'branchStatComponent'"
            >
              <svg
                class="w-5 h-5"
                aria-hidden="true"
                fill="none"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                ></path>
              </svg>
              <span class="ml-4">Branch Dashboard</span>
            </a>
          </li>
          <li v-if="hasStoreRole" class="relative px-6 py-3">
            <span
            v-if="currentView === 'storeStatComponent'"
              class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
              aria-hidden="true"
            ></span>
            <a
            :class="{ 'dark:text-gray-100': currentView ==='HomeComponent'}"
              class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
              href="#"
              @click="currentView = 'storeStatComponent'"
            >
              <svg
                class="w-5 h-5"
                aria-hidden="true"
                fill="none"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                ></path>
              </svg>
              <span class="ml-4">Store Dashboard</span>
            </a>
          </li>
        </ul>
        <ul>
        <li v-if="Roles.includes('admin')" class="relative px-6 py-3">
            <span
            v-if="currentView === 'BranchCrud'"
              class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
              aria-hidden="true"
            ></span>
            <a
             :class="{ 'dark:text-gray-100': currentView ==='BranchCrud'}"
              class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
              href="#"
              @click="currentView = 'BranchCrud'"
            >
              <svg
                class="w-5 h-5"
                aria-hidden="true"
                fill="none"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"
                ></path>
              </svg>
              <span class="ml-4">Branch Management</span>
            </a>
          </li>
          <!-- <li v-if="Roles.includes('admin') || Roles.includes('messages')" class="relative px-6 py-3"> -->
        <li v-if="Roles.includes('admin') || hasBranchRole" class="relative px-6 py-3">
            <span
            v-if="currentView === 'StoreCrud'"
              class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
              aria-hidden="true"
            ></span>
            <a
             :class="{ 'dark:text-gray-100': currentView ==='MessageComponent'}"
              class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
              href="#"
              @click="currentView = 'StoreCrud'"
            >
              <svg
                class="w-5 h-5"
                aria-hidden="true"
                fill="none"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
                ></path>
              </svg>
              <span class="ml-4">Store Management</span>
            </a>
          </li>
        <li class="relative px-6 py-3">
            <a
              href="#"
              class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
              @click="toggleSettingsMenu"
              aria-haspopup="true"
            >
              <span class="inline-flex items-center">
                <svg
                  class="w-5 h-5"
                  aria-hidden="true"
                  fill="none"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"
                  ></path>
                </svg>
                <span class="ml-4">Branches</span>
              </span>
              <svg
                class="w-4 h-4"
                aria-hidden="true"
                fill="currentColor"
                viewBox="0 0 20 20"
              >
                <path
                  fill-rule="evenodd"
                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                  clip-rule="evenodd"
                ></path>
              </svg>
            </a>
            <template v-if="isSettingsMenuOpen">
              <ul
                class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                aria-label="submenu"
              >
            <li
                v-for="branch in filteredBranches"
                :key="branch.id"
                class="relative px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
              >
                <button
                  class="inline-flex items-center justify-between w-full text-sm transition-colors"
                  @click="toggleBranchMenu(branch.id)"
                >
                  <span>{{ branch.name }}</span>
                  <svg
                    class="w-4 h-4 transition-transform"
                    :class="{ 'rotate-180': openBranch === branch.id }"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                </button>

                <!-- Stores Dropdown -->
                <transition
                  enter-active-class="transition-all duration-200 ease-out"
                  leave-active-class="transition-all duration-150 ease-in"
                  enter-class="opacity-0 -translate-y-1"
                  enter-to-class="opacity-100 translate-y-0"
                  leave-class="opacity-100 translate-y-0"
                  leave-to-class="opacity-0 -translate-y-1"
                >
                  <ul v-if="openBranch === branch.id" class="pl-4 mt-2 space-y-1">
                    <li
                      v-for="store in filteredStores(branch.id)"
                      :key="store.id"
                      class="relative"
                    >
                      <button
                        class="inline-flex items-center justify-between w-full px-2 py-1 text-sm transition-colors rounded-md hover:bg-gray-100 dark:hover:bg-gray-800"
                        @click="toggleStoreMenu(store.id)"
                      >
                        <span>{{ store.name }}</span>
                        <svg
                          class="w-4 h-4 transition-transform"
                          :class="{ 'rotate-180': openStore === store.id }"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                        >
                          <path
                            fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                          ></path>
                        </svg>
                      </button>

                      <!-- Actions Dropdown -->
                      <transition
                        enter-active-class="transition-all duration-200 ease-out"
                        leave-active-class="transition-all duration-150 ease-in"
                        enter-class="opacity-0 -translate-y-1"
                        enter-to-class="opacity-100 translate-y-0"
                        leave-class="opacity-100 translate-y-0"
                        leave-to-class="opacity-0 -translate-y-1"
                      >
                        <ul v-if="openStore === store.id" class="pl-4 mt-1 space-y-1">
                          <li>
                            <a
                              href="#"
                              @click="viewInventory(store.id)"
                              class="block px-2 py-1 text-sm rounded-md hover:bg-gray-100 dark:hover:bg-gray-800"
                            >
                              Inventory
                            </a>
                          </li>
                          <li>
                            <a
                              href="#"
                              @click="viewSales(store.id)"
                              class="block px-2 py-1 text-sm rounded-md hover:bg-gray-100 dark:hover:bg-gray-800"
                            >
                              Sales
                            </a>
                          </li>
                          <li>
                            <a
                              href="#"
                              @click="viewTransfers(store.id)"
                              class="block px-2 py-1 text-sm rounded-md hover:bg-gray-100 dark:hover:bg-gray-800"
                            >
                              Transfers
                            </a>
                          </li>
                        </ul>
                      </transition>
                    </li>
                  </ul>
                </transition>
              </li>
              </ul>
            </template>
          </li>

        <li v-if="Roles.includes('admin')" class="relative px-6 py-3">
            <span
            v-if="currentView === 'AdminComponent'"
              class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
              aria-hidden="true"
            ></span>
            <a
             :class="{ 'dark:text-gray-100': currentView ==='MessageComponent'}"
              class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
              href="#"
              @click="currentView = 'AdminComponent'"
            >
              <svg
                class="w-5 h-5"
                aria-hidden="true"
                fill="none"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
                ></path>
              </svg>
              <span class="ml-4">Users</span>
            </a>
          </li>

        <li v-if="Roles.includes('admin')" class="relative px-6 py-3">
            <span
            v-if="currentView === 'RolesComponent'"
              class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
              aria-hidden="true"
            ></span>
            <a
             :class="{ 'dark:text-gray-100': currentView ==='MessageComponent'}"
              class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
              href="#"
              @click="currentView = 'RolesComponent'"
            >
              <svg
                class="w-5 h-5"
                aria-hidden="true"
                fill="none"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
                ></path>
              </svg>
              <span class="ml-4">Roles</span>
            </a>
          </li>
        <li class="relative px-6 py-3">
            <span
            v-if="currentView === 'ProductsComponent'"
              class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
              aria-hidden="true"
            ></span>
            <a
             :class="{ 'dark:text-gray-100': currentView ==='MessageComponent'}"
              class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
              href="#"
              @click="currentView = 'ProductsComponent'"
            >
              <svg
                class="w-5 h-5"
                aria-hidden="true"
                fill="none"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
                ></path>
              </svg>
              <span class="ml-4">Products</span>
            </a>
          </li>
        </ul>
        <div class="px-6 my-6">
        </div>
      </div>
    </aside>
    <!-- Mobile sidebar -->
    <!-- Backdrop -->
  <transition
    name="fade"
  >
    <div
      v-if="isSideMenuOpen"
      class="fixed inset-0 z-10 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
    ></div>
  </transition>
<transition
  name="slide-fade"
>
    <aside
      class="fixed inset-y-0 z-20 flex-shrink-0 w-64 mt-16 overflow-y-auto bg-white dark:bg-gray-800 md:hidden"
      v-if="isSideMenuOpen"
      @keydown.escape="closeSideMenu"
      tabindex="0"
    >
      <div
      class="py-4 text-gray-500 dark:text-gray-400">
        <a
          class="ml-6 text-2xl font-bold text-gray-800 dark:text-gray-200"
          href="#"
        >
          Inventory360
        </a>
        <ul class="mt-6">
          <li v-if="Roles.includes('admin')" class="relative px-6 py-3">
            <span
            v-if="currentView === 'HomeComponent'"
              class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
              aria-hidden="true"
            ></span>
            <a
            :class="{ 'dark:text-gray-100': currentView ==='HomeComponent'}"
              class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
              href="#"
              @click="currentView = 'HomeComponent'"
            >
              <svg
                class="w-5 h-5"
                aria-hidden="true"
                fill="none"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                ></path>
              </svg>
              <span class="ml-4">Admin Dashboard</span>
            </a>
          </li>
          <li v-if="hasBranchRole" class="relative px-6 py-3">
            <span
            v-if="currentView === 'branchStatComponent'"
              class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
              aria-hidden="true"
            ></span>
            <a
            :class="{ 'dark:text-gray-100': currentView ==='HomeComponent'}"
              class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
              href="#"
              @click="currentView = 'branchStatComponent'"
            >
              <svg
                class="w-5 h-5"
                aria-hidden="true"
                fill="none"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                ></path>
              </svg>
              <span class="ml-4">Branch Dashboard</span>
            </a>
          </li>
          <li v-if="hasStoreRole" class="relative px-6 py-3">
            <span
            v-if="currentView === 'storeStatComponent'"
              class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
              aria-hidden="true"
            ></span>
            <a
            :class="{ 'dark:text-gray-100': currentView ==='HomeComponent'}"
              class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
              href="#"
              @click="currentView = 'storeStatComponent'"
            >
              <svg
                class="w-5 h-5"
                aria-hidden="true"
                fill="none"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                ></path>
              </svg>
              <span class="ml-4">Store Dashboard</span>
            </a>
          </li>
        </ul>
        <ul>
          <li class="relative px-6 py-3">
            <a
              href="#"
              class="inline-flex items-center justify-between w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
              @click="toggleSettingsMenu"
              aria-haspopup="true"
            >
              <span class="inline-flex items-center">
                <svg
                  class="w-5 h-5"
                  aria-hidden="true"
                  fill="none"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  viewBox="0 0 24 24"
                  stroke="currentColor"
                >
                  <path
                    d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"
                  ></path>
                </svg>
                <span class="ml-4">Branches</span>
              </span>
              <svg
                class="w-4 h-4"
                aria-hidden="true"
                fill="currentColor"
                viewBox="0 0 20 20"
              >
                <path
                  fill-rule="evenodd"
                  d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                  clip-rule="evenodd"
                ></path>
              </svg>
            </a>
            <template v-if="isSettingsMenuOpen">
              <ul
                class="p-2 mt-2 space-y-2 overflow-hidden text-sm font-medium text-gray-500 rounded-md shadow-inner bg-gray-50 dark:text-gray-400 dark:bg-gray-900"
                aria-label="submenu"
              >
                <li
                v-for="branch in filteredBranches"
                :key="branch.id"
                class="relative px-2 py-1 transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
              >
                <button
                  class="inline-flex items-center justify-between w-full text-sm transition-colors"
                  @click="toggleBranchMenu(branch.id)"
                >
                  <span>{{ branch.name }}</span>
                  <svg
                    class="w-4 h-4 transition-transform"
                    :class="{ 'rotate-180': openBranch === branch.id }"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                </button>

                <!-- Stores Dropdown -->
                <transition
                  enter-active-class="transition-all duration-200 ease-out"
                  leave-active-class="transition-all duration-150 ease-in"
                  enter-class="opacity-0 -translate-y-1"
                  enter-to-class="opacity-100 translate-y-0"
                  leave-class="opacity-100 translate-y-0"
                  leave-to-class="opacity-0 -translate-y-1"
                >
                  <ul v-if="openBranch === branch.id" class="pl-4 mt-2 space-y-1">
                    <li
                      v-for="store in filteredStores(branch.id)"
                      :key="store.id"
                      class="relative"
                    >
                      <button
                        class="inline-flex items-center justify-between w-full px-2 py-1 text-sm transition-colors rounded-md hover:bg-gray-100 dark:hover:bg-gray-800"
                        @click="toggleStoreMenu(store.id)"
                      >
                        <span>{{ store.name }}</span>
                        <svg
                          class="w-4 h-4 transition-transform"
                          :class="{ 'rotate-180': openStore === store.id }"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                        >
                          <path
                            fill-rule="evenodd"
                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                            clip-rule="evenodd"
                          ></path>
                        </svg>
                      </button>

                      <!-- Actions Dropdown -->
                      <transition
                        enter-active-class="transition-all duration-200 ease-out"
                        leave-active-class="transition-all duration-150 ease-in"
                        enter-class="opacity-0 -translate-y-1"
                        enter-to-class="opacity-100 translate-y-0"
                        leave-class="opacity-100 translate-y-0"
                        leave-to-class="opacity-0 -translate-y-1"
                      >
                        <ul v-if="openStore === store.id" class="pl-4 mt-1 space-y-1">
                          <li>
                            <a
                              href="#"
                              @click="viewInventory(store.id)"
                              class="block px-2 py-1 text-sm rounded-md hover:bg-gray-100 dark:hover:bg-gray-800"
                            >
                              Inventory
                            </a>
                          </li>
                          <li>
                            <a
                              href="#"
                              @click="viewSales(store.id)"
                              class="block px-2 py-1 text-sm rounded-md hover:bg-gray-100 dark:hover:bg-gray-800"
                            >
                              Sales
                            </a>
                          </li>
                          <li>
                            <a
                              href="#"
                              @click="viewTransfers(store.id)"
                              class="block px-2 py-1 text-sm rounded-md hover:bg-gray-100 dark:hover:bg-gray-800"
                            >
                              Transfers
                            </a>
                          </li>
                        </ul>
                      </transition>
                    </li>
                  </ul>
                </transition>
              </li>
              </ul>
            </template>
          </li>
                  <li v-if="Roles.includes('admin')" class="relative px-6 py-3">
            <span
            v-if="currentView === 'AdminComponent'"
              class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
              aria-hidden="true"
            ></span>
            <a
             :class="{ 'dark:text-gray-100': currentView ==='MessageComponent'}"
              class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
              href="#"
              @click="currentView = 'AdminComponent'"
            >
              <svg
                class="w-5 h-5"
                aria-hidden="true"
                fill="none"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
                ></path>
              </svg>
              <span class="ml-4">Users</span>
            </a>
          </li>

        <li v-if="Roles.includes('admin')" class="relative px-6 py-3">
            <span
            v-if="currentView === 'RolesComponent'"
              class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
              aria-hidden="true"
            ></span>
            <a
             :class="{ 'dark:text-gray-100': currentView ==='MessageComponent'}"
              class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
              href="#"
              @click="currentView = 'RolesComponent'"
            >
              <svg
                class="w-5 h-5"
                aria-hidden="true"
                fill="none"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
                ></path>
              </svg>
              <span class="ml-4">Roles</span>
            </a>
          </li>
        <li class="relative px-6 py-3">
            <span
            v-if="currentView === 'ProductsComponent'"
              class="absolute inset-y-0 left-0 w-1 bg-purple-600 rounded-tr-lg rounded-br-lg"
              aria-hidden="true"
            ></span>
            <a
             :class="{ 'dark:text-gray-100': currentView ==='MessageComponent'}"
              class="inline-flex items-center w-full text-sm font-semibold transition-colors duration-150 hover:text-gray-800 dark:hover:text-gray-200"
              href="#"
              @click="currentView = 'ProductsComponent'"
            >
              <svg
                class="w-5 h-5"
                aria-hidden="true"
                fill="none"
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                viewBox="0 0 24 24"
                stroke="currentColor"
              >
                <path
                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
                ></path>
              </svg>
              <span class="ml-4">Products</span>
            </a>
          </li>
        </ul>
        <div class="px-6 my-6">
        </div>
      </div>
    </aside>
</transition>
    <div class="flex flex-col flex-1 w-full">
      <header class="z-10 py-4 bg-white shadow-md dark:bg-gray-800">
        <div
          class="container flex items-center justify-between h-full px-6 mx-auto text-purple-600 dark:text-purple-300"
        >
          <!-- Mobile hamburger -->
          <button
            class="p-1 mr-5 -ml-1 rounded-md md:hidden focus:outline-none focus:shadow-outline-purple"
            @click="toggleSideMenu"
            aria-label="Menu"
          >
            <svg
              class="w-6 h-6"
              aria-hidden="true"
              fill="currentColor"
              viewBox="0 0 20 20"
            >
              <path
                fill-rule="evenodd"
                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                clip-rule="evenodd"
              ></path>
            </svg>
          </button>
          <!-- Search input -->
          <div class="flex justify-center flex-1 lg:mr-32">
          </div>
          <ul class="flex items-center flex-shrink-0 space-x-6">
            <!-- Theme toggler -->
            <li class="flex">
              <button
                class="rounded-md focus:outline-none focus:shadow-outline-purple"
                @click="toggleTheme"
                aria-label="Toggle color mode"
              >
                <template v-if="!dark">
                  <svg
                    class="w-5 h-5"
                    aria-hidden="true"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                    <path
                      d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"
                    ></path>
                  </svg>
                </template>
                <template v-if="dark">
                  <svg
                    class="w-5 h-5"
                    aria-hidden="true"
                    fill="currentColor"
                    viewBox="0 0 20 20"
                  >
                    <path
                      fill-rule="evenodd"
                      d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z"
                      clip-rule="evenodd"
                    ></path>
                  </svg>
                </template>
              </button>
            </li>
            <!-- Notifications menu -->
            <!-- Profile menu -->
            <li class="relative">
              <button
                class="align-middle rounded-full focus:shadow-outline-purple focus:outline-none"
                @click="toggleProfileMenu"
                @keydown.escape="closeProfileMenu"
                v-click-outside="closeProfileMenu"
                aria-label="Account"
                aria-haspopup="true"
              >
                <img
                  class="object-cover w-8 h-8 rounded-full"
                  src="/public/images/profile-photo.png"
                  alt=""
                  aria-hidden="true"
                />
              </button>
              <template v-if="isProfileMenuOpen">
              <transition
                  name="fade"
                >
                <ul
                  @keydown.escape="closeProfileMenu"
                  class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700"
                  aria-label="submenu"
                >
                  <li class="flex">
                    <button
                      class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                      @click="profile"
                    >
                      <svg
                        class="w-4 h-4 mr-3"
                        aria-hidden="true"
                        fill="none"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                      >
                        <path
                          d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"
                        ></path>
                      </svg>
                      <span>Profile</span>
                    </button>
                  </li>
                  <li class="flex">
                    <button
                      class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                      @click="logOut"
                    >
                      <svg
                        class="w-4 h-4 mr-3"
                        aria-hidden="true"
                        fill="none"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                      >
                        <path
                          d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"
                        ></path>
                      </svg>
                      <span>Log out</span>
                    </button>
                  </li>
                </ul>
                </transition>
              </template>
            </li>
          </ul>
        </div>
      </header>
      <main class="h-full overflow-y-auto bg-white dark:bg-gray-800">
          <component
          :is="currentView"
          :storeId="selectedStoreId"
          ></component>
      </main>
    </div>
  </div>

</template>

<script>
import axios from 'axios';
import { useCounterStore } from '../store.js';
import { mapActions, mapState, mapWritableState } from 'pinia';

// Import components
import HomeComponent from './home.vue';
import BranchStatComponent from './branchHome.vue';
import StoreStatComponent from './storeHome.vue';
import BranchCrud from './branchCRUD.vue';
import StoreCrud from './storesCRUD.vue';
import ProductsComponent from './products.vue';
import InventoryComponent from './Inventory.vue';
import SalesComponent from './sales.vue';
import TransferComponent from './transfers.vue';
import AdminComponent from './administrator.vue';
import RolesComponent from './roles.vue';

export default {
  name: 'Dashboard',

  components: {
    HomeComponent,
    BranchStatComponent,
    StoreStatComponent,
    BranchCrud,
    StoreCrud,
    ProductsComponent,
    InventoryComponent,
    SalesComponent,
    TransferComponent,
    AdminComponent,
    RolesComponent,
  },

  directives: {
    'click-outside': {
      mounted(el, binding) {
        el.clickOutsideEvent = function(event) {
          if (!(el === event.target || el.contains(event.target))) {
            binding.value(event);
          }
        };
        document.addEventListener('click', el.clickOutsideEvent);
      },
      unmounted(el) {
        document.removeEventListener('click', el.clickOutsideEvent);
      }
    }
  },

  props: {
    csrfToken: String
  },


  data() {
    return {
      dark: false,
      allInventories: [],
      allSales: [],
      allTransfers: [],
      selectedStoreId: null,
      isSideMenuOpen: false,
      isNotificationsMenuOpen: false,
      isProfileMenuOpen: false,
      isPagesMenuOpen: false,
      isModalOpen: false,
      isSettingsMenuOpen: false,
      isFinanceMenuOpen: false,
      openBranch: null,
      openStore: null,
    };
  },

  computed: {
    ...mapState(useCounterStore, ['Roles', 'branches', 'stores']),
    ...mapWritableState(useCounterStore, ['inventories', 'sales', 'transfers', 'currentView']),

    hasBranchRole() {
        return this.Roles.some(role => /^branch\d+$/.test(role));
    },

    hasStoreRole() {
        return this.Roles.some(role => /^store\d+$/.test(role));
    },

    filteredBranches() {
        if (this.Roles.includes('admin')) {
            return this.branches;
        }
        if (this.hasBranchRole) {
            const branchRole = this.Roles.find(role => /^branch\d+$/.test(role));
            const branchId = branchRole ? parseInt(branchRole.match(/\d+$/)[0]) : null;
            return this.branches.filter(branch => branch.id === branchId);
        }
        if (this.hasStoreRole) {
            const storeIds = this.Roles
                .filter(role => /^store\d+$/.test(role))
                .map(role => parseInt(role.match(/\d+$/)[0]));

            // Step 2: From all stores, pick those where the ID is in the extracted list
            const storeBranchIds = this.stores
                .filter(store => storeIds.includes(store.id))
                .map(store => store.branch_id);

            // Step 3: Return branches that are in the storeBranchIds list
            return this.branches.filter(branch => storeBranchIds.includes(branch.id));

        }
        return [];
  }


  },

  mounted() {
    this.fetchAdminRoles();
    this.fetchBranches();
    this.fetchStores();
    this.fetchProducts();
    this.fetchInventories();
    this.fetchSales();
    this.fetchTransfers();
    this.fetchRoles();
  },

  methods: {
    ...mapActions(useCounterStore, [
      'fetchAdminRoles',
      'fetchBranches',
      'fetchStores',
      'fetchProducts',
      'fetchInventories',
      'fetchSales',
      'fetchTransfers',
      'fetchRoles'
    ]),

    // Store and Branch Methods
    toggleBranchMenu(branchId) {
      this.openBranch = this.openBranch === branchId ? null : branchId;
      this.openStore = null;
    },

    toggleStoreMenu(storeId) {
      this.openStore = this.openStore === storeId ? null : storeId;
    },

    filteredStores(branchId) {
      return this.stores.filter(store => store.branch_id === branchId);
    },

    // View Methods
    async viewInventory(storeId) {
        this.selectedStoreId = storeId;
        this.currentView = 'InventoryComponent';
    },

    async viewSales(storeId) {
        this.selectedStoreId = storeId;
        this.currentView = 'SalesComponent';
    },

    async viewTransfers(storeId) {
        this.selectedStoreId = storeId;
        this.currentView = 'TransferComponent';
    },

    // Menu Toggle Methods
    toggleTheme() {
      this.dark = !this.dark;
    },

    toggleSettingsMenu() {
      this.isSettingsMenuOpen = !this.isSettingsMenuOpen;
    },
    profile() {
        try {
            window.location.href = '/profile';
        } catch(error) {
            console.error('Error getting to profile', error);
        }
    },
    async logOut() {
      try {
        await axios.post('/logout');
        window.location.href = '/login';
      } catch(error) {
        console.error('Error logging out', error);
      }
    },
    toggleSideMenu() {
        this.isSideMenuOpen = !this.isSideMenuOpen;
    },
    closeSideMenu() {
        this.isSideMenuOpen = false;
    },
    toggleProfileMenu() {
        this.isProfileMenuOpen = !this.isProfileMenuOpen;
    },
    closeProfileMenu() {
        this.isProfileMenuOpen = false;
    },
    openModal() {
        this.isModalOpen = true;
    },
    closeModal() {
        this.isModalOpen = false;
    },
  },

  provide() {
    return {
      darkMode: this.dark,
    };
  },
};
</script>

<style>
@import '../../css/app.css';
@import '../../css/tailwind.output.css';

.fade-enter-active,
.fade-leave-active {
  transition: opacity 150ms ease-in;
}

.fade-enter,
.fade-leave-to {
  opacity: 0;
}

.slide-fade-enter-active,
.slide-fade-leave-active {
  transition: opacity 150ms ease-in-out, transform 150ms ease-in-out;
}

.slide-fade-enter,
.slide-fade-leave-to {
  opacity: 0;
  transform: translateX(-20px);
}
</style>
