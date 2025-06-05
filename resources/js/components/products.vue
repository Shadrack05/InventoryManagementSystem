<template>
    <div class="h-full pb-16 overflow-y-auto bg-white dark:bg-gray-800">
         <div class="container px-6 mx-auto grid">
            <p
            class="mt-2 mb-3 text-lg font-semibold text-gray-700 dark:text-gray-300"
          >
           Products
          </p>

        <div class="flex items-center space-x-8 mt-2 mb-2">
            <button v-if="Roles.includes('admin')" class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
                @click="openCreateProduct()"
                >
                    + Add Product
                </button>
        </div>

          <table class="w-full whitespace-no-wrap">
            <thead>
              <tr
                class="text-xs font-semibold tracking-wide text-left text-gray-500 uppercase border-b dark:border-gray-700 bg-gray-50 dark:text-gray-400 dark:bg-gray-800"
              >
                <th class="px-4 py-3">Name</th>
                <th class="px-4 py-3">SKU</th>
                <th class="px-4 py-3">Description</th>
                <th v-if="Roles.includes('admin')" class="px-4 py-3">Actions</th>
              </tr>
            </thead>
            <tbody
              class="bg-white divide-y dark:divide-gray-700 dark:bg-gray-800"
            >
              <tr class="text-gray-700 dark:text-gray-400"
              v-for="product in products" :key="product.id">
                <td class="px-4 py-3">
                  <div class="flex items-center text-sm">
                    <div>
                      <p class="font-semibold"> {{ product.name }}</p>
                    </div>
                  </div>
                </td>
                <td class="px-4 py-3 text-sm">
                    {{ product.sku }}
                </td>
                <td class="px-4 py-3 text-sm">
                    {{ product.description }}
                </td>
                <td v-if="Roles.includes('admin')" class="px-4 py-3">
                    <div class="flex items-center space-x-4 text-sm">
                      <button
                        class="flex items-center justify-between px-2 py-2 text-sm font-medium leading-5 text-purple-600 rounded-lg dark:text-gray-400 focus:outline-none focus:shadow-outline-gray"
                        aria-label="Edit"
                        @click="openModal(product)"
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
                        @click="deleteProduct(product)"
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
    <EditProductModal
    :editVisible="editModal"
    :productData="selectedProduct"
    @closeEdit="closeModal()"
    @edit="editProduct()"
    />
    <CreateProductModal
    :isVisible="isModalOpen"
    @close="closeModal()"
    @create="createProduct()"
    />

</template>

<script>
import Swal from 'sweetalert2';
import 'sweetalert2/src/sweetalert2.scss';
import { mapActions, mapState } from 'pinia';
import CreateProductModal from '../modals/createProductModal.vue';
import EditProductModal from '../modals/editProductModal.vue';
import { useCounterStore } from '../store.js';



export default {
    data() {
        return {
            isModalOpen: false,
            selectedProduct: {},
            editModal: false,
            alertMessage:'',
            alertType: ''
        };
    },
    props: {
        storeId: {
            type: Number,
            required: false
        }
    },
    mounted () {
        // this.fetchProducts();
    },
    components: {
        CreateProductModal,
        EditProductModal
    },
    computed: {
        ...mapState(useCounterStore, ['products', 'Roles']),
    },
    methods: {
        ...mapActions(useCounterStore, ['addProduct','fetchProducts', 'removeProduct']),

        openModal(product) {
            this.selectedProduct = { ...product };
            this.editModal = true;
        },
        openCreateProduct() {
            this.isModalOpen = true;
        },
        editProduct () {
            this.fetchProducts();
        },
        async deleteProduct(product) {
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
                    let groupId = product.id;
                    try {
                      this.removeProduct(groupId);
                      this.fetchProducts();
                    } catch (error) {
                        console.error('error deleting product', error);
                    }
                }
                });
        },
        createProduct () {
            this.fetchProducts();
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
