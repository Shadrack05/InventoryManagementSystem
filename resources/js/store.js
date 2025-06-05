import { defineStore } from 'pinia';
import axios from 'axios';
import Swal from 'sweetalert2';
import 'sweetalert2/src/sweetalert2.scss';

export const useCounterStore = defineStore('counter', {
    state() {
        return {
            user: null,
            products: [],
            Roles: [],
            roles: [],
            admins: [],
            branch: [],
            sales: [],
            branches: [],
            transfers: [],
            stores: [],
            products: [],
            inventories: [],
            branchStatistics: [],
            storeStatistics: [],
            currentView: null,
        };
    },
    actions: {
        async fetchAdminRoles() {
            try {
                const response = await axios.get('/api/user-role');

                this.user = response.data.user.name;
                this.Roles= response.data.roles;

                for (const role of this.Roles) {
                    if (role === 'admin') {
                        this.currentView = 'HomeComponent'
                        return
                    }

                    if (/^branch\d+$/.test(role)) {
                        const branchId = parseInt(role.match(/\d+/)[0])
                        this.loadBranchData(branchId)
                        this.currentView = 'branchStatComponent'
                        return
                    }


                    if (/^store\d+$/.test(role)) {
                        const storeId = parseInt(role.match(/\d+/)[0])
                        this.loadStoreData(storeId)
                        this.currentView = 'storeStatComponent'
                        return
                    }

                }

            // Default fallback
            this.currentView = {
                template: '<p>Unauthorized or Unknown Role</p>'
            }

            } catch (error) {
                console.error('Error fetching user:', error);
            }
        },
        async loadBranchData(branchId) {
            try {
                const response = await axios.get(`/api/branch-statistics/${branchId}`);
                this.branch = response.data;
            } catch (error) {
                console.error('Error loading branch data:', error);
            }

        },
        async loadStoreData(storeId) {
            try {
                const response = await axios.get(`/api/store-statistics/${storeId}`);
                this.storeStatistics = response.data;
            } catch (error) {
                console.error('Error loading store data:', error);
            }

        },

    async fetchAdmins() {
        try {
            const response = await axios.get('api/users');
            this.admins = response.data;
        } catch (error) {
            let errorMessage = "An unexpected error occurred.";

            if (error.response && error.response.data) {
              const errorData = error.response.data;
              errorMessage = errorData.message || errorMessage;
            }

            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: errorMessage,
            });
        }
      },
      async editAdmin(adminId, admin) {
        try {
            const response = await axios.post(`api/edit-admin/${adminId}`, admin);
            this.message = response;
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Your Admin has been Edited",
                showConfirmButton: false,
                timer: 1500
            });
            return response;
        } catch (error) {
            let errorMessage = "An unexpected error occurred.";

            if (error.response && error.response.data) {
              const errorData = error.response.data;
              errorMessage = errorData.message || errorMessage;
            }

            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: errorMessage,
            });
            throw error;
        }
      },

    async fetchRoles() {
        try {
            const response = await axios.get('api/roles');
            this.roles = response.data;
        } catch (error) {
            let errorMessage = "An unexpected error occurred.";

            if (error.response && error.response.data) {
              const errorData = error.response.data;
              errorMessage = errorData.message || errorMessage;
            }

            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: errorMessage,
            });
        }
      },

        async fetchProducts() {
            try {
                const response = await axios.get('api/products');
                this.products = response.data;
            } catch (error) {
                let errorMessage = "An unexpected error occurred.";

                if (error.response && error.response.data) {
                    const errorData = error.response.data;
                    errorMessage = errorData.message || errorMessage;
                }

                console.error("Error fetching products:", errorMessage);
                alert(errorMessage);
            }
        },

        async addproduct(product) {
            try {
                const response = await axios.post('api/create-product', product);
                this.message = response.success;
                this.error = response.error;

                alert("Your product has been saved successfully!");
                return response;
            } catch (error) {
                let errorMessage = "An unexpected error occurred.";

                if (error.response && error.response.data) {
                    const errorData = error.response.data;
                    errorMessage = errorData.message || errorMessage;
                }

                console.error("Error adding product:", errorMessage);
                alert(errorMessage);
                throw error;
            }
        },

        async editproduct(productId, product) {
            try {
                const response = await axios.post(`api/edit-product/${productId}`, product);
                this.message = response;
                return response;
            } catch (error) {
                let errorMessage = "An unexpected error occurred.";

                if (error.response && error.response.data) {
                    const errorData = error.response.data;
                    errorMessage = errorData.message || errorMessage;
                }

                console.error("Error editing product:", errorMessage);
                alert(errorMessage);
                throw error;
            }
        },

    async removeproduct(productId) {
        try {
            const response = await axios.delete(`api/delete-product/${productId}`);
            this.message = response;

            alert("Your product has been removed successfully!");
            return response;
        } catch (error) {
            let errorMessage = "An unexpected error occurred.";

            if (error.response && error.response.data) {
                const errorData = error.response.data;
                errorMessage = errorData.message || errorMessage;
            }

            console.error("Error removing product:", errorMessage);
            alert(errorMessage);
            throw error;
        }
    },

    async fetchBranches() {
        try {
            const response = await axios.get('api/branches');
            this.branches = response.data;
        } catch (error) {
            let errorMessage = "An unexpected error occurred.";

            if (error.response && error.response.data) {
              const errorData = error.response.data;
              errorMessage = errorData.message || errorMessage;
            }

            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: errorMessage,
            });
        }
      },
      async addBranch(branch) {
        try {
        const response = await axios.post('api/create-branch', branch);
        this.message = response.success;
        this.error = response.error;
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Your Branch has been saved",
            showConfirmButton: false,
            timer: 1500
        });
        return response;
        } catch (error) {
            let errorMessage = "An unexpected error occurred.";

            if (error.response && error.response.data) {
              const errorData = error.response.data;
              errorMessage = errorData.message || errorMessage;
            }

            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: errorMessage,
            });
            throw error;
        }
      },
      async editBranch(branchId, branch) {
        try {
            const response = await axios.post(`api/edit-branch/${branchId}`, branch);
            this.message = response;
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Your Branch has been Edited",
                showConfirmButton: false,
                timer: 1500
            });
            return response;
        } catch (error) {
            let errorMessage = "An unexpected error occurred.";

            if (error.response && error.response.data) {
              const errorData = error.response.data;
              errorMessage = errorData.message || errorMessage;
            }

            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: errorMessage,
            });
            throw error;
        }
      },
      async removeBranch(branchId) {
        try {
            const response = await axios.delete(`api/delete-branch/${branchId}`);
            this.message = response;
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Your Branch has been removed",
                showConfirmButton: false,
                timer: 1500
            });
            return response;
        } catch (error) {
            let errorMessage = "An unexpected error occurred.";

            if (error.response && error.response.data) {
              const errorData = error.response.data;
              errorMessage = errorData.message || errorMessage;
            }

            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: errorMessage,
            });
            throw error;
        }
      },
    async addStore(store) {
        try {
        const response = await axios.post('api/create-store', store);
        this.message = response.success;
        this.error = response.error;
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Store has been Recorded",
            showConfirmButton: false,
            timer: 1500
        });
        return response;
        } catch (error) {
            let errorMessage = "An unexpected error occurred.";

            if (error.response && error.response.data) {
              const errorData = error.response.data;
              errorMessage = errorData.message || errorMessage;
            }

            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: errorMessage,
            });
            throw error;
        }
      },
      async fetchStores() {
        try {
            const response = await axios.get('api/stores');
            this.stores = response.data;
        } catch (error) {
            let errorMessage = "An unexpected error occurred.";

            if (error.response && error.response.data) {
              const errorData = error.response.data;
              errorMessage = errorData.message || errorMessage;
            }

            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: errorMessage,
            });
        }
      },
      async editStore(storeId, store) {
        try {
            const response = await axios.post(`api/edit-store/${storeId}`, store);
            this.message = response;
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Your Store details have been Edited",
                showConfirmButton: false,
                timer: 1500
            });
            return response;
        } catch (error) {
            let errorMessage = "An unexpected error occurred.";

            if (error.response && error.response.data) {
              const errorData = error.response.data;
              errorMessage = errorData.message || errorMessage;
            }

            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: errorMessage,
            });
            throw error;
        }
      },
      async removeStore(storeId) {
        try {
            const response = await axios.delete(`api/delete-store/${storeId}`);
            this.message = response;
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Your Store has been removed",
                showConfirmButton: false,
                timer: 1500
            });
            return response;
        } catch (error) {
            let errorMessage = "An unexpected error occurred.";

            if (error.response && error.response.data) {
              const errorData = error.response.data;
              errorMessage = errorData.message || errorMessage;
            }

            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: errorMessage,
            });
            throw error;
        }
      },
    async fetchProducts() {
        try {
            const response = await axios.get('api/products');
            this.products = response.data;
        } catch (error) {
            let errorMessage = "An unexpected error occurred.";

            if (error.response && error.response.data) {
              const errorData = error.response.data;
              errorMessage = errorData.message || errorMessage;
            }

            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: errorMessage,
            });
        }
      },
      async addProduct(product) {
        try {
        const response = await axios.post('api/create-product', product);
        this.message = response.success;
        this.error = response.error;
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Your product has been saved",
            showConfirmButton: false,
            timer: 1500
        });
        return response;
        } catch (error) {
            let errorMessage = "An unexpected error occurred.";

            if (error.response && error.response.data) {
              const errorData = error.response.data;
              errorMessage = errorData.message || errorMessage;
            }

            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: errorMessage,
            });
            throw error;
        }
      },
      async editProduct(productId, product) {
        try {
            const response = await axios.post(`api/edit-product/${productId}`, product);
            this.message = response;
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Your Product has been Edited",
                showConfirmButton: false,
                timer: 1500
            });
            return response;
        } catch (error) {
            let errorMessage = "An unexpected error occurred.";

            if (error.response && error.response.data) {
              const errorData = error.response.data;
              errorMessage = errorData.message || errorMessage;
            }

            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: errorMessage,
            });
            throw error;
        }
      },
      async removeProduct(productId) {
        try {
            const response = await axios.delete(`api/delete-product/${productId}`);
            this.message = response;
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Your Product has been removed",
                showConfirmButton: false,
                timer: 1500
            });
            return response;
        } catch (error) {
            let errorMessage = "An unexpected error occurred.";

            if (error.response && error.response.data) {
              const errorData = error.response.data;
              errorMessage = errorData.message || errorMessage;
            }

            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: errorMessage,
            });
            throw error;
        }
      },
    async fetchInventories() {
        try {
            const response = await axios.get('api/inventories');
            this.inventories = response.data;
        } catch (error) {
            let errorMessage = "An unexpected error occurred.";

            if (error.response && error.response.data) {
              const errorData = error.response.data;
              errorMessage = errorData.message || errorMessage;
            }

            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: errorMessage,
            });
        }
      },
      async addInventory(inventory) {
        try {
        const response = await axios.post('api/create-inventory', inventory);
        this.message = response.success;
        this.error = response.error;
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Your inventory has been saved",
            showConfirmButton: false,
            timer: 1500
        });
        return response;
        } catch (error) {
            let errorMessage = "An unexpected error occurred.";

            if (error.response && error.response.data) {
              const errorData = error.response.data;
              errorMessage = errorData.message || errorMessage;
            }

            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: errorMessage,
            });
            throw error;
        }
      },
      async editInventory(inventoryId, inventory) {
        try {
            const response = await axios.post(`api/edit-inventory/${inventoryId}`, inventory);
            this.message = response;
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Your Inventory has been Edited",
                showConfirmButton: false,
                timer: 1500
            });
            return response;
        } catch (error) {
            let errorMessage = "An unexpected error occurred.";

            if (error.response && error.response.data) {
              const errorData = error.response.data;
              errorMessage = errorData.message || errorMessage;
            }

            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: errorMessage,
            });
            throw error;
        }
      },
      async removeInventory(inventoryId) {
        try {
            const response = await axios.delete(`api/delete-inventory/${inventoryId}`);
            this.message = response;
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Your Inventory has been removed",
                showConfirmButton: false,
                timer: 1500
            });
            return response;
        } catch (error) {
            let errorMessage = "An unexpected error occurred.";

            if (error.response && error.response.data) {
              const errorData = error.response.data;
              errorMessage = errorData.message || errorMessage;
            }

            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: errorMessage,
            });
            throw error;
        }
      },
    async fetchSales() {
        try {
            const response = await axios.get('api/sales');
            this.sales = response.data;
        } catch (error) {
            let errorMessage = "An unexpected error occurred.";

            if (error.response && error.response.data) {
              const errorData = error.response.data;
              errorMessage = errorData.message || errorMessage;
            }

            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: errorMessage,
            });
        }
      },
      async addSale(sale) {
        try {
        const response = await axios.post('api/create-sale', sale);
        this.message = response.success;
        this.error = response.error;
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Your sale has been saved",
            showConfirmButton: false,
            timer: 1500
        });
        this.fetchInventories();
        return response;
        } catch (error) {
            let errorMessage = "An unexpected error occurred.";

            if (error.response && error.response.data) {
              const errorData = error.response.data;
              errorMessage = errorData.message || errorMessage;
            }

            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: errorMessage,
            });
            throw error;
        }
      },
      async editSale(saleId, sale) {
        try {
            const response = await axios.post(`api/edit-sale/${saleId}`, sale);
            this.message = response;
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Your Sale has been Edited",
                showConfirmButton: false,
                timer: 1500
            });
            this.fetchInventories();
            return response;
        } catch (error) {
            let errorMessage = "An unexpected error occurred.";

            if (error.response && error.response.data) {
              const errorData = error.response.data;
              errorMessage = errorData.message || errorMessage;
            }

            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: errorMessage,
            });
            throw error;
        }
      },
      async removeSale(saleId) {
        try {
            const response = await axios.delete(`api/delete-sale/${saleId}`);
            this.message = response;
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Your Sale has been removed",
                showConfirmButton: false,
                timer: 1500
            });
            this.fetchInventories();
            return response;
        } catch (error) {
            let errorMessage = "An unexpected error occurred.";

            if (error.response && error.response.data) {
              const errorData = error.response.data;
              errorMessage = errorData.message || errorMessage;
            }

            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: errorMessage,
            });
            throw error;
        }
      },
    async fetchTransfers() {
        try {
            const response = await axios.get('api/transfers');
            this.transfers = response.data;
        } catch (error) {
            let errorMessage = "An unexpected error occurred.";

            if (error.response && error.response.data) {
              const errorData = error.response.data;
              errorMessage = errorData.message || errorMessage;
            }

            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: errorMessage,
            });
        }
      },
      async addTransfer(transfer) {
        try {
        const response = await axios.post('api/create-transfer', transfer);
        this.message = response.success;
        this.error = response.error;
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Your transfer has been saved",
            showConfirmButton: false,
            timer: 1500
        });
        this.fetchInventories();
        return response;
        } catch (error) {
            let errorMessage = "An unexpected error occurred.";

            if (error.response && error.response.data) {
              const errorData = error.response.data;
              errorMessage = errorData.message || errorMessage;
            }

            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: errorMessage,
            });
            throw error;
        }
      },
      async editTransfer(transferId, transfer) {
        try {
            const response = await axios.post(`api/edit-transfer/${transferId}`, transfer);
            this.message = response;
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Your Transfer has been Edited",
                showConfirmButton: false,
                timer: 1500
            });
            this.fetchInventories();
            return response;
        } catch (error) {
            let errorMessage = "An unexpected error occurred.";

            if (error.response && error.response.data) {
              const errorData = error.response.data;
              errorMessage = errorData.message || errorMessage;
            }

            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: errorMessage,
            });
            throw error;
        }
      },
      async removeTransfer(transferId) {
        try {
            const response = await axios.delete(`api/delete-transfer/${transferId}`);
            this.message = response;
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Your Transfer has been removed",
                showConfirmButton: false,
                timer: 1500
            });
            this.fetchInventories();
            return response;
        } catch (error) {
            let errorMessage = "An unexpected error occurred.";

            if (error.response && error.response.data) {
              const errorData = error.response.data;
              errorMessage = errorData.message || errorMessage;
            }

            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: errorMessage,
            });
            throw error;
        }
      },
    async addPosition(position) {
        try {
        const response = await axios.post('api/create-position', position);
        this.message = response.success;
        this.error = response.error;
        Swal.fire({
            position: "top-end",
            icon: "success",
            title: "Your Position has been saved",
            showConfirmButton: false,
            timer: 1500
        });
        return response;
        } catch (error) {
            let errorMessage = "An unexpected error occurred.";

            if (error.response && error.response.data) {
              const errorData = error.response.data;
              errorMessage = errorData.message || errorMessage;
            }

            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: errorMessage,
            });
            throw error;
        }
      },
      async editPosition(positionId, position) {
        try {
            const response = await axios.post(`api/edit-position/${positionId}`, position);
            this.message = response;
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Your Position has been Edited",
                showConfirmButton: false,
                timer: 1500
            });
            return response;
        } catch (error) {
            let errorMessage = "An unexpected error occurred.";

            if (error.response && error.response.data) {
              const errorData = error.response.data;
              errorMessage = errorData.message || errorMessage;
            }

            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: errorMessage,
            });
            throw error;
        }
      },
      async removeRole(positionId) {
        try {
            const response = await axios.delete(`api/delete-position/${positionId}`);
            this.message = response;
            Swal.fire({
                position: "top-end",
                icon: "success",
                title: "Position has been removed",
                showConfirmButton: false,
                timer: 1500
            });
            return response;
        } catch (error) {
            let errorMessage = "An unexpected error occurred.";

            if (error.response && error.response.data) {
              const errorData = error.response.data;
              errorMessage = errorData.message || errorMessage;
            }

            Swal.fire({
              icon: "error",
              title: "Oops...",
              text: errorMessage,
            });
            throw error;
        }
      },
}

});
