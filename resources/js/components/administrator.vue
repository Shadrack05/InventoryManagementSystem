<template>
    <div class="h-full pb-16 overflow-y-auto bg-white dark:bg-gray-800">
         <div class="container px-6 mx-auto grid">
            <p
            class="mt-2 mb-3 text-lg font-semibold text-gray-700 dark:text-gray-300"
          >
           Administrators
          </p>

        <div class="flex items-center space-x-8 mt-2 mb-2">
            <button class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                @click="openCreateAdmin()"
                >
                    + Add Admin
                </button>
        </div>

          <table class="w-full whitespace-no-wrap">
            <thead>
              <tr
                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
              >
                <th class="px-4 py-3">Name</th>
                <th class="px-4 py-3">Position</th>
                <th class="px-4 py-3">Actions</th>
              </tr>
            </thead>
            <tbody
              class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
            >
              <tr class="text-gray-700 dark:text-gray-400"
              v-for="admin in admins" :key="admin.id">
                <td class="px-4 py-3">
                  <div class="flex items-center text-sm">
                    <div>
                      <p class="font-semibold"> {{ admin.name }}</p>
                    </div>
                  </div>
                </td>
                <td class="px-4 py-3 text-sm">
                    <span>
                    {{ admin.roles.length ? admin.roles.map(role => role.name).join(', ') : 'No Role' }}
                </span>
                </td>
                <td class="px-4 py-3">
                    <div class="flex items-center space-x-4 text-sm">
                      <button
                        class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                        aria-label="Edit"
                        @click="openModal(admin)"
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
                    </div>
                  </td>
              </tr>
            </tbody>
          </table>
    </div>
</div>
    <EditAdminModal
    :editVisible="editModal"
    :adminData="selectedAdmin"
    @closeEdit="closeModal()"
    @edit="editAdmin()"
    />
    <CreateAdminModal
    :isVisible="isModalOpen"
    @close="closeModal()"
    @create="createAdmin()"
    />

</template>

<script>
import Swal from 'sweetalert2';
import 'sweetalert2/src/sweetalert2.scss';
import { mapActions, mapState } from 'pinia';
import CreateAdminModal from '../modals/createAdminModal.vue';
import EditAdminModal from '../modals/editAdminModal.vue';
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
            selectedAdmin: {},
            editModal: false,
        };
    },
    mounted () {
        this.fetchAdmins();
    },
    components: {
        CreateAdminModal,
        EditAdminModal
    },
    computed: {
        ...mapState(useCounterStore, ['admins', 'roles']),
    },
    methods: {
        ...mapActions(useCounterStore, ['addAdmin','fetchAdmins', 'removeAdmin']),

        openModal(admin) {
            this.selectedAdmin = {
                ...admin,
                role: admin.roles && admin.roles.length ? admin.roles[0].name : null
            };
            this.editModal = true;
        },
        openCreateAdmin() {
            this.isModalOpen = true;
        },
        editAdmin () {
            this.fetchAdmins();
        },
        async deleteAdmin(admin) {
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
                    let adminId = admin.id;
                    try {
                      this.removeAdmin(adminId);
                      this.fetchAdmins();
                    } catch (error) {
                        console.error('error deleting admin', error);
                    }
                }
                });
        },
        createAdmin () {
            this.fetchAdmins();
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
