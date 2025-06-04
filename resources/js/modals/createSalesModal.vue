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
          Add Sale
        </p>
        <!-- Modal description -->
        <label class="block mt-4 text-sm mb-3">
            <span class="text-gray-700 dark:text-gray-400">
              Product
            </span>
            <select
              class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
              v-model="productId"
            >
            <option disabled value="">Product</option>
              <option
              v-for="option in products" :value="option.id" :key="option.id"
              >{{ option.name }} - {{ option.sku }}</option>
            </select>
          </label>

        <label class="block mt-4 text-sm mb-3">
            <span class="text-gray-700 dark:text-gray-400">
              Store
            </span>
            <select
              class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
              v-model="storeId"
            >
            <option disabled value="">Store</option>
              <option
              v-for="option in stores" :value="option.id" :key="option.id"
              >{{ option.name }} - {{ option.branch?.name || 'NA'}}</option>
            </select>
          </label>

        <label class="block text-sm">
          <span class="text-gray-700 dark:text-gray-400">Quantity</span>
          <input
            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
            placeholder="quantity"
            type="number"
            v-model="quantity"
          />
        </label>

        <label class="block text-sm">
          <span class="text-gray-700 dark:text-gray-400">Price</span>
          <input
            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
            placeholder="0.00"
            type="number"
            v-model="soldAt"
          />
        </label>

      </div>
      <footer
        class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800"
      >
        <button
          class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
          @click="createSale"
        >
        <span v-if="isLoading">
            <svg class="animate-spin h-5 w-5 mr-2 inline" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
              <path class="opacity-75" fill="white" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
          </span>
          <span v-else>Create Sale</span>
        </button>
      </footer>
    </div>
  </div>
</template>

<script>
import Swal from 'sweetalert2';
import 'sweetalert2/src/sweetalert2.scss';
import { useCounterStore } from '../store';
import { mapActions, mapState } from 'pinia';


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
            soldAt: null,
            quantity: null,
            productId: null,
            storeId: null,
            sale: {},
            error: 'error',
            succcess: 'success',
            isLoading: false,
        };

    },
    computed: {
        ...mapState(useCounterStore, ['products', 'stores']),
    },
    mounted () {
        //
    },
    methods: {
        ...mapActions(useCounterStore, ['addSale']),

    closeModal() {
      this.$emit('close');
    },
    async createSale() {
        try {
            this.isLoading = true;
            this.sale.productId = this.productId;
            this.sale.storeId = this.storeId;
            this.sale.quantity = this.quantity;
            this.sale.soldAt= this.soldAt;

            await this.addSale(this.sale); // Assuming addSale is an async action

            this.$emit('create');
            this.closeModal();
            this.resetForm();
        } catch (error) {
            console.error('Error creating sale:', error);
        } finally {
            this.isLoading = false;
        }
    },
    resetForm () {
        this.soldAt = null;
        this.quantity = null;
        this.productId = null;
        this.storeId = null;
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

