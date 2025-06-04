<template>
    <div class="container px-6 mx-auto grid bg-white dark:bg-gray-800"
    >
      <h2
        class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200"
      >
        Dashboard
      </h2>
      <!-- Cards -->
      <div v-if="hasBranchRole" class="grid gap-6 mb-8 md:grid-cols-4 xl:grid-cols-4">
        <!-- Card -->
        <div
          class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
        >
          <div
            class="p-3 mr-4 text-orange-500 bg-orange-100 rounded-full dark:text-orange-100 dark:bg-orange-500"
          >
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path
                d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z"
              ></path>
            </svg>
          </div>
          <div>
            <p
              class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
            >
              Total Sales Today
            </p>
            <p
              class="text-lg font-semibold text-gray-700 dark:text-gray-200"
            >
              {{ branch.totalSalesToday }}
            </p>
          </div>
        </div>
        <!-- Card -->
        <div
          class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
        >
          <div
            class="p-3 mr-4 text-green-500 bg-green-100 rounded-full dark:text-green-100 dark:bg-green-500"
          >
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path
                fill-rule="evenodd"
                d="M12 2a2 2 0 100 4 2 2 0 000-4zM10 6a2 2 0 012-2 2 2 0 012 2v4a2 2 0 002 2h1a1 1 0 011 1v7a1 1 0 01-1 1h-2a1 1 0 01-1-1v-4h-2v4a1 1 0 01-1 1H8a1 1 0 01-1-1v-7a1 1 0 011-1h1a2 2 0 002-2V6z"
                clip-rule="evenodd"
              ></path>
            </svg>
          </div>
          <div>
            <p
              class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
            >
              Top Selling Product
            </p>
            <p
              class="text-lg font-semibold text-gray-700 dark:text-gray-200"
            >
              {{ branch.topProduct }}
            </p>
          </div>
        </div>
        <!-- Card -->
        <div
          class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
        >
          <div
            class="p-3 mr-4 text-blue-500 bg-blue-100 rounded-full dark:text-blue-100 dark:bg-blue-500"
          >
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path
                d="M12 2a2 2 0 100 4 2 2 0 000-4zM9 7a1 1 0 011-1h4a1 1 0 011 1v2h1a1 1 0 011 1v5a1 1 0 01-1 1h-1v3a1 1 0 01-1 1h-2a1 1 0 01-1-1v-3H9v3a1 1 0 01-1 1H6a1 1 0 01-1-1v-5a1 1 0 011-1h1V8a1 1 0 011-1z"
              ></path>
            </svg>
          </div>
          <div>
            <p
              class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
            >
            Least Selling Product
            </p>
            <p
              class="text-lg font-semibold text-gray-700 dark:text-gray-200"
            >
              {{ branch.leastProduct }}
            </p>
          </div>
        </div>
        <!-- Card -->
        <div
          class="flex items-center p-4 bg-white rounded-lg shadow-xs dark:bg-gray-800"
        >
          <div
            class="p-3 mr-4 text-teal-500 bg-teal-100 rounded-full dark:text-teal-100 dark:bg-teal-500"
          >
            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
              <path
                fill-rule="evenodd"
                d="M12 2a2 2 0 100 4 2 2 0 000-4zM9 7a1 1 0 011-1h4a1 1 0 011 1v3h1a1 1 0 011 1v3a1 1 0 01-1 1h-1v4a1 1 0 01-1 1h-2a1 1 0 01-1-1v-4H9a1 1 0 01-1-1v-3a1 1 0 011-1h1V7z"
                clip-rule="evenodd"
              ></path>
            </svg>
          </div>
          <div>
            <p
              class="mb-2 text-sm font-medium text-gray-600 dark:text-gray-400"
            >
              Transfers Today
            </p>
            <p
              class="text-lg font-semibold text-gray-700 dark:text-gray-200"
            >
              {{ branch.totalTransfers }}
            </p>
          </div>
        </div>
      </div>

    <!-- <ChartComponent
    /> -->
    </div>
  </template>

<script>
  import axios from 'axios';
  import Swal from 'sweetalert2';
  import 'sweetalert2/src/sweetalert2.scss';
  import { useCounterStore } from '../store.js';
  import { mapState, mapWritableState } from 'pinia';
  import { mapActions } from 'pinia';
//   import ChartComponent from './chartComponent.vue';

  export default {
    inject: ['darkMode'],
    data () {
        return {
            totalSalesToday: null,
            topProduct: null,
            leastProduct: null,
            totalTransfers: null,
        };
    },
    computed: {
        ...mapWritableState(useCounterStore, ['Roles', 'branch']),

    hasBranchRole() {
        return this.Roles.some(role => /^branch\d+$/.test(role));
    },

    hasStoreRole() {
        return this.Roles.some(role => /^store\d+$/.test(role));
    },

    },
    components: {
        // ChartComponent,
    },
    mounted() {
    },
    methods: {

    },
  };
</script>

<style>
@import '../../css/tailwind.output.css';

</style>

