<template>
    <transition
    name="fade"
  >
    <div
    v-if="editVisible"
    class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
  >
    <!-- Modal -->
    <transition
    name="fade"
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
          Edit Store
        </p>
        <!-- Modal description -->
        <label class="block text-sm">
          <span class="text-gray-700 dark:text-gray-400">Name</span>
          <input
            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
            placeholder="Store Name"
            v-model="store.name"
          />
        </label>

        <label class="block mt-4 text-sm mb-3">
            <span class="text-gray-700 dark:text-gray-400">
              Branch
            </span>
            <select
              class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
              v-model="branchId"
            >
            <option disabled value="">Branch Name</option>
              <option
              v-for="option in branches" :value="option.id" :key="option.id"
              >{{ option.name }}</option>
            </select>
          </label>

      </div>
      <footer
        class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800"
      >
        <button
          class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
          @click="updateStore"
        >
          Edit Store
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
        storeData: {
            type: Object,
            required: true
        }
    },
    data() {
        return {
            store: { ...this.storeData },
        };
    },
    computed: {
        ...mapState(useCounterStore, ['branches']),
        branchId: {
            get() {
                return this.store.branch ? this.store.branch.id : null;
            },
            set(value) {
                if (!this.store.branch) {
                    this.store.branch = {};
                }
                this.store.branch.id = value;
            }
        }
    },
    mounted () {
        //
    },
    created () {
        //
    },
    watch: {
        storeData: {
            handler(newStore) {
            this.store = { ...newStore };
            },
            deep: true,
            immediate: true
        }
    },
    methods: {
        ...mapActions(useCounterStore, ['editStore']),

    closeModal() {
      this.$emit('closeEdit');
    },
    async updateStore() {
        Swal.fire({
        title: "Are you sure?",
        text: "Do you want to edit store",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, update it!"
        }).then((result) => {
        if (result.isConfirmed) {
            let storeId = this.store.id;
            this.store.branch_id = this.branchId;

            try {
                this.editStore(storeId, this.store);
            } catch (error) {
                console.error('Error editing store', error);
            } finally {
                this.$emit('edit');
                this.closeModal();
            }
        }
        });
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

