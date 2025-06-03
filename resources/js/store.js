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
            branches: [],
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

                for (const role of Roles) {
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
        // async fetchAdminRoles() {
        //     try {
        //         const response = await axios.get('/api/user-role');
        //         this.Roles = response.data.roles;
        //         console.log('Roles fetched successfully:', this.Roles);
        //     } catch (error) {
        //         console.error('Error fetching roles:', error);

        //     }

        // },
        async loadBranchData(branchId) {
            try {
                const response = await axios.get(`/api/branch-statistics/${branchId}`);
                this.branch = response.data;
                console.log('Branch data loaded successfully:', this.branch);
            } catch (error) {
                console.error('Error loading branch data:', error);
            }

        },
        async loadStoreData(storeId) {
            try {
                const response = await axios.get(`/api/store-statistics/${storeId}`);
                this.storeStatistics = response.data;
                console.log('Store data loaded successfully:', this.storeStatistics);
            } catch (error) {
                console.error('Error loading store data:', error);
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
}

});
