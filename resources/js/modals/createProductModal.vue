<template>
    <div
    v-if="isVisible"
    class="fixed inset-0 z-30 flex items-end bg-black bg-opacity-50 sm:items-center sm:justify-center"
  >
    <div
      v-if="isVisible"
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
          Add Product
        </p>
        <!-- Modal description -->
        <label class="block text-sm">
          <span class="text-gray-700 dark:text-gray-400">Name</span>
          <input
            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
            placeholder="Apples"
            v-model="name"
          />
        </label>

        <label class="block text-sm">
          <span class="text-gray-700 dark:text-gray-400">SKU</span>
          <input
            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
            placeholder=" SKU "
            v-model="sku"
          />
        </label>

        <label class="block text-sm">
          <span class="text-gray-700 dark:text-gray-400">Description</span>
          <input
            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
            placeholder="Product..........."
            v-model="description"
          />
        </label>

      </div>
      <footer
        class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800"
      >
        <button
          class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
          @click="createProduct"
        >
        <span v-if="isLoading">
            <svg class="animate-spin h-5 w-5 mr-2 inline" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
              <path class="opacity-75" fill="white" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
          </span>
          <span v-else>Create Product</span>
        </button>
      </footer>
    </div>
  </div>
</template>

<script>
import Swal from 'sweetalert2';
import 'sweetalert2/src/sweetalert2.scss';
import { useCounterStore } from '../store';
import { mapActions } from 'pinia';


export default {
    props: {
    isVisible: {
      type: Boolean,
      default: false,
      Required: true
    },
    },
    data() {
        return {
            name: '',
            description: '',
            product: {},
            error: 'error',
            succcess: 'success',
            isLoading: false,
            sku: '',
        };

    },
    mounted () {
        //
    },
    methods: {
        ...mapActions(useCounterStore, ['addProduct']),

    closeModal() {
      this.$emit('close');
    },
    async createProduct() {
        try {
            this.isLoading = true;
            this.product.name = this.name;
            this.product.sku = this.sku;
            this.product.description = this.description;

            await this.addProduct(this.product); // Assuming addProduct is an async action

            this.$emit('create');
            this.closeModal();
            this.resetForm();
        } catch (error) {
            console.error('Error creating product:', error);
        } finally {
            this.isLoading = false;
        }
    },
    resetForm () {
        this.name = '';
        this.description = '';
        this.sku = '';
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
  watch: {
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

