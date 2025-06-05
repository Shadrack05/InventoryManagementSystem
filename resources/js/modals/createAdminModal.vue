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
          Create Admin
        </p>
        <!-- Modal description -->
         <label class="block text-sm mb-3">
          <span class="text-gray-700 dark:text-gray-400">Name</span>
          <input
            class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
            placeholder="James Kenyan"
            required
            v-model="name"
          />
        </label>

        <label class="block text-sm mb-3">
            <span class="text-gray-700 dark:text-gray-400">Email</span>
            <input
              class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
              placeholder="abc@gmail.com"
              v-model="email"
            />
            <span v-if="emailCheck" class="text-xs text-red-600 dark:text-red-400">
                {{ emailError }}
              </span>
          </label>

          <label class="block text-sm mb-3">
            <span class="text-gray-700 dark:text-gray-400">Password</span>
            <input
            type="password"
              class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
              placeholder=""
              v-model="password"
            />
            <span v-if="passwordCheck" class="text-xs text-red-600 dark:text-red-400">
                {{ passwordError }}
              </span>
          </label>

          <label class="block text-sm mb-3">
            <span class="text-gray-700 dark:text-gray-400">Confirm Password</span>
            <input
            type="password"
              class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input"
              placeholder=""
              v-model="confirmPassword"
            />
            <span v-if="passwordError" class="text-xs text-red-600 dark:text-red-400">
                {{ passwordError }}
              </span>
            </label>

            <label class="block mt-4 text-sm mb-3">
                <span class="text-gray-700 dark:text-gray-400">
                  Role
                </span>
                <select
                multiple
                  class="block w-full mt-1 text-sm dark:text-gray-300 dark:border-gray-600 dark:bg-gray-700 form-select focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:focus:shadow-outline-gray"
                  v-model="role"

                >
                <option disabled value="">Pastor, Vicar, Elder</option>
                  <option
                  v-for="option in roles" :value="option.name" :key="option.id"
                  >{{ option.name }}</option>
                </select>
              </label>

      </div>
      <footer
        class="flex flex-col items-center justify-end px-6 py-3 -mx-6 -mb-4 space-y-4 sm:space-y-0 sm:space-x-6 sm:flex-row bg-gray-50 dark:bg-gray-800"
      >
        <button
          class="w-full px-5 py-3 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg sm:w-auto sm:px-4 sm:py-2 active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple"
          @click="submitForm"
        >
          <span v-if="isLoading">
            <svg class="animate-spin h-5 w-5 mr-2 inline" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="white" stroke-width="4"></circle>
              <path class="opacity-75" fill="white" d="M4 12a8 8 0 018-8v8H4z"></path>
            </svg>
          </span>
          <span v-else>Create admin</span>
        </button>
      </footer>
    </div>
  </div>
</template>

<script>
import Swal from 'sweetalert2';
import 'sweetalert2/src/sweetalert2.scss';
import { useCounterStore } from '../store';
import { mapActions,mapState } from 'pinia';


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
            email: '',
            password: '',
            emailCheck: false,
            passwordCheck: false,
            confirmPassword: '',
            passwordError: '',
            emailError: '',
            admin: {},
            role: [],
            isLoading: false,
        };

    },
    computed: {
        ...mapState(useCounterStore, ['roles']),
    },
    mounted () {
        //
    },
    methods: {
        ...mapActions(useCounterStore, ['fetchAdmins']),

        validateEmail() {
            const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!re.test(this.email)) {
                this.emailCheck = true;
                this.emailError = "Please enter a valid email address.";
                return false;
            }
            this.emailError = '';
            this.emailCheck = false;
            return true;
        },
        validatePasswords() {
        if (this.password !== this.confirmPassword) {
            this.passwordCheck = true;
            this.passwordError = "Passwords do not match!";
            return false;
        }
        this.passwordError = '';
        this.passwordCheck = false;
        return true;
        },
        resetForm () {
            this.name = '';
            this.email = '';
            this.password = '';
            this.confirmPassword = '';
            this.admin = {};
            this.role = [];

            this.$nextTick(() => {
            });
        },
        async submitForm() {
            this.isLoading = true;
        if (this.validateEmail() && this.validatePasswords()) {
                this.admin.name = this.name;
                this.admin.email = this.email;
                this.admin.password = this.password;
                this.admin.password_confirmation = this.confirmPassword;

                try {
                await axios.post('api/register-tenant-admin', {
                        name:this.name,
                        email:this.email,
                        password:this.password,
                        password_confirmation:this.admin.password_confirmation,
                        role: this.role
                    }, {
                        headers: {
                        //
                        }
                    }).then(response => {
                        Swal.fire({
                        position: "top-end",
                        icon: "success",
                        title: "Admin Created Succesfully",
                        showConfirmButton: false,
                        timer: 1500
                    });
                    this.fetchAdmins();
                    this.resetForm();
                    this.closeModal();

                    }).catch(error => {

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
                    });
            } catch (error) {
                console.error('error creating admin', error);
            } finally {
                this.isLoading = false;
            }

        } else {
            console.error("Form contains errors. Fix them.");
            }
        },
    closeModal() {
      this.$emit('close');
    },
    async createAdmin() {
        try {
        this.admin.name = this.name;
        this.admin.description = this.description;

        await this.addAdmin(this.admin);

        this.$emit('create');
        this.closeModal();
        this.resetForm();
        } catch (error) {
        console.error('Error creating admin:', error);
        }
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

