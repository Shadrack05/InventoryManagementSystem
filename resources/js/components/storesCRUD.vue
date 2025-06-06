<template>
    <div class="h-full pb-16 overflow-y-auto bg-white dark:bg-gray-800">
         <div class="container px-6 mx-auto grid">
            <p
            class="mt-2 mb-3 text-lg font-semibold text-gray-700 dark:text-gray-300"
          >
           Stores
          </p>

        <div class="flex items-center space-x-8 mt-2 mb-2">
            <button class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                @click="openCreatestore()"
                >
                    + Add Store
                </button>
        </div>

          <table class="w-full whitespace-no-wrap">
            <thead>
              <tr
                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
              >
                <th class="px-4 py-3">Id</th>
                <th class="px-4 py-3">Name</th>
                <th class="px-4 py-3">Parent Branch</th>
                <th class="px-4 py-3">Actions</th>
              </tr>
            </thead>
            <tbody
              class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
            >
              <tr class="text-gray-700 dark:text-gray-400"
              v-for="store in stores" :key="store.id">
              <td class="px-4 py-3">
                <div class="flex items-center text-sm">
                  <div>
                    <p class="font-semibold"> {{ store.id }}</p>
                  </div>
                </div>
              </td>
                <td class="px-4 py-3">
                  <div class="flex items-center text-sm">
                    <div>
                      <p class="font-semibold"> {{ store.name }}</p>
                    </div>
                  </div>
                </td>
                <td class="px-4 py-3">
                  <div class="flex items-center text-sm">
                    <div>
                      <p class="font-semibold"> {{ store.branch?.name || 'NA'  }}</p>
                    </div>
                  </div>
                </td>

                <td class="px-4 py-3">
                    <div class="flex items-center space-x-4 text-sm">
                      <button
                        class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                        aria-label="Edit"
                        @click="openModal(store)"
                      >
                        <svg
                          class="w-5 h-5"
                          aria-hidden="true"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                        >
                          <path
                            d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"
                          ></path>
                        </svg>
                      </button>
                      <button
                        class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                        aria-label="Delete"
                        @click="deletestore(store)"
                      >
                        <svg
                          class="w-5 h-5"
                          aria-hidden="true"
                          fill="currentColor"
                          viewBox="0 0 20 20"
                        >
                          <path
                            fill-rule="evenodd"
                            d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                            clip-rule="evenodd"
                          ></path>
                        </svg>
                      </button>
                    </div>
                  </td>
              </tr>
            </tbody>
          </table>
    </div>
</div>
    <EditStoreModal
    :editVisible="editModal"
    :storeData="selectedstore"
    @closeEdit="closeModal()"
    @edit="editstore()"
    />
    <CreateStoreModal
    :isVisible="isModalOpen"
    @close="closeModal()"
    @create="createstore()"
    />

</template>

<script>
import Swal from 'sweetalert2';
import 'sweetalert2/src/sweetalert2.scss';
import { mapActions, mapState } from 'pinia';
import CreateStoreModal from '../modals/createStoreModal.vue';
import EditStoreModal from '../modals/editStoreModal.vue';
import { useCounterStore } from '../store.js';



export default {
    props: {
        storeId: {
            type: Number,
            required: false
        }
    },
    data() {
        return {
            isModalOpen: false,
            selectedstore: {},
            editModal: false,
            alertMessage:'',
            alertType: ''
        };
    },
    mounted () {
        //
    },
    components: {
        CreateStoreModal,
        EditStoreModal
    },
    computed: {
        ...mapState(useCounterStore, ['stores', 'message', 'error']),
    },
    methods: {
        ...mapActions(useCounterStore, ['addStore','fetchStores', 'removeStore']),

        openModal(store) {
            this.selectedstore = { ...store };
            this.editModal = true;
        },
        openCreatestore() {
            this.isModalOpen = true;
        },
        editstore () {
            this.fetchStores();
        },
        async deletestore(store) {
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Delete it!"
                }).then((result) => {
                if (result.isConfirmed) {
                    let storeId = store.id;
                    try {
                      this.removeStore(storeId);
                      this.fetchStores();
                    } catch (error) {
                        console.error('error deleting store', error);
                    }
                }
                });
        },
        createstore () {
            this.fetchStores();
        },
        closeModal() {
            this.isModalOpen = false;
            this.editModal = false;
        }
    }

}
</script>

<style>
@import '../../css/tailwind.output.css';

.alert {
padding: 10px;
margin: 10px 0;
border-radius: 5px;
}
.alert-success {
background-color: #d4edda;
color: #155724;
}
.alert-error {
background-color: #f8d7da;
color: #721c24;
}
</style>
