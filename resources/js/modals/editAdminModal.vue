<template>
    <transition
    name="fade"
    @before-enter="beforeEnter"
    @enter="enter"
    @leave="leave"
  >
    <div
    v-if="editVisible"
    class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
  >
    <!-- Modal -->
    <transition
    name="fade"
    @before-enter="beforeEnter"
    @enter="enter"
    @leave="leave"
  >
    <div
      v-if="editVisible"
      @keydown.escape="closeModal"
      class="w-full px-6 py-4 overflow-hidden bg-white rounded-t-lg dark:bg-gray-800 sm:rounded-lg sm:m-4 sm:max-w-xl"
      role="dialog"
      id="modal"
    >
      <!-- Remove header if you don't want a close icon. Use modal body to place modal tile. -->
      <header class="flex justify-end">
        <button
          class="inline-flex items-center justify-center w-6 h-6 text-gray-400 transition-colors duration-150 rounded dark:hover:text-gray-200 hover: hover:text-gray-700"
          aria-label="close"
          @click="closeModal"
        >
          <svg
            class="w-4 h-4"
            fill="currentColor"
            viewBox="0 0 20 20"
            role="img"
            aria-hidden="true"
          >
            <path
              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
              clip-rule="evenodd"
              fill-rule="evenodd"
            ></path>
          </svg>
        </button>
      </header>
      <!-- Modal body -->
      <div class="mt-4 mb-6">
        <!-- Modal title -->
        <p
          class="mb-2 text-lg font-semibold text-gray-700 dark:text-gray-300"
        >
          Assign Role to {{ admin.name }}
        </p>
        <!-- Modal description -->
        <label class="block mt-4 text-sm mb-3">
            <span class="text-gray-700 dark:text-gray-400">
                Roles
            </span>
            <select
                multiple
                class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-multiselect focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                v-model="rolesArray"
            >
                <option
                    v-for="option in roles"
                    :value="option.name"
                    :key="option.id"
                >
                    {{ option.name }}
                </option>
            </select>
            <p class="mt-1 text-xs text-gray-500">
                Hold Ctrl/Cmd to select multiple roles
            </p>
        </label>

      </div>
      <footer
        class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800"
      >
        <!-- <button
          @click="closeModal"
          class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
        >
          Close
        </button> -->
        <button
          class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
          @click="updateAdmin"
        >
        <span v-if="isLoading">
            <svg class="animate-spin h-5 w-5 mr-2 inline" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
              <path class="opacity-75" fill="white" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
          </span>
          <span v-else>Assign Role</span>
        </button>
      </footer>
    </div>
    </transition>
  </div>
    </transition>
</template>

<script>
import Swal from 'sweetalert2';
import 'sweetalert2/src/sweetalert2.scss';
import { mapState, mapActions } from 'pinia';
import { useCounterStore } from '../store';

export default {
    props: {
    editVisible: {
      type: Boolean,
      default: false
    },
    adminData: {
      type: Object,
      required: true
    }
    },
    data() {
        return {
            admin: { ...this.adminData },
            isLoading: false,
            rolesArray: [],
        };
    },
    computed: {
        ...mapState(useCounterStore, ['roles']),
    },
    mounted () {
        //

    },
    created () {
        //
        console.log(this.adminData);
    },
    watch: {
        adminData: {
            handler(newAdmin) {
                this.admin = { ...newAdmin };
                this.rolesArray = newAdmin.roles?.map(role => role.name) || [];
            },
            deep: true,
            immediate: true
        }
    },
    methods: {
        ...mapActions(useCounterStore, ['editAdmin']),

    closeModal() {
      this.$emit('closeEdit');
    },
    async updateAdmin() {
        Swal.fire({
        title: "Are you sure?",
        text: "Do you want to edit admin",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, update it!"
        }).then((result) => {
        if (result.isConfirmed) {
            let adminId = this.admin.id;
            this.admin.rolesArray = this.rolesArray;
            try {
                this.isLoading = true;
                this.editAdmin(adminId, this.admin);
            } catch (error) {
                console.error('Error editing admin', error);
            } finally {
                this.$emit('edit');
                this.closeModal();
                this.isLoading = false;
            }
        }
        });
    },
    beforeLeave(el) {
        el.style.opacity = 1;
    },
    leave(el, done) {
        el.style.transition = 'opacity 150ms ease-in-out';
        el.style.opacity = 0;
    done();
    },
    closeNotificationsMenu() {
        this.isNotificationsMenuOpen = false;
    },
    beforeEnter(el) {
        el.style.opacity = 0;
        el.style.transform = 'translateX(-20px)';
    },
    enter(el, done) {
         el.offsetHeight; // Trigger reflow to apply transition
        el.style.transition = 'opacity 150ms ease-in-out, transform 150ms ease-in-out';
        el.style.opacity = 1;
        el.style.transform = 'translateX(0)';
            done();
    },
        focusTrap(element) {
          // Implement your focusTrap logic here or use a library like tabbable or focus-trap
        },
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
}
</script>

<style>
@import '../../css/tailwind.output.css';
</style>

