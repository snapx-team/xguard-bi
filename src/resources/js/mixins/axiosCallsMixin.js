import axios from 'axios';

export const axiosCalls = {

    methods: {

        // Employees
        asyncGetEmployeeProfile() {
            return axios.get('get-employee-profile').catch((error) => {
                this.loopAllErrorsAsTriggerErrorToast(error);
            });
        },

        asyncGetAllUsers() {
            return axios.get('get-all-users').catch((error) => {
                this.loopAllErrorsAsTriggerErrorToast(error);
            });
        },

        asyncGetSomeUsers(searchTerm) {
            if (searchTerm === '') {
                return axios.get('get-all-users').catch((error) => {
                    this.loopAllErrorsAsTriggerErrorToast(error);
                });
            }
            return axios.get('get-some-users/' + searchTerm).catch((error) => {
                this.loopAllErrorsAsTriggerErrorToast(error);
            });
        },

        asyncGetEmployees() {
            return axios.get('get-employees').catch((error) => {
                this.loopAllErrorsAsTriggerErrorToast(error);
            });
        },

        asyncCreateOrUpdateEmployees(employeeData) {
            return axios.post('create-or-update-employees', employeeData).then((res) => {
                let created = res.data['created'];
                let updated = res.data['updated'];

                if (created > 0) {
                    this.triggerSuccessToast((created === 1) ? created + ' new employee added!' : created + ' new employees added!');
                }
                if (updated > 0) {
                    this.triggerSuccessToast((updated === 1) ? updated + ' new employee updated!' : updated + ' new employees updated!');
                }
                if (updated + created === 0) {
                    this.triggerSuccessToast('Nothing changed');
                }
            }).catch((error) => {
                this.loopAllErrorsAsTriggerErrorToast(error);
            });
        },

        asyncDeleteEmployees(employeeId) {
            return axios.delete('delete-employee/' + employeeId).then(() => {
                this.triggerSuccessToast('Employee Removed');
            }).catch((error) => {
                this.loopAllErrorsAsTriggerErrorToast(error);
            });
        },

        //Triggers
        triggerSuccessToast(message) {
            this.$toast.success(message, {
                position: 'bottom-right',
                timeout: 5000,
                closeOnClick: true,
                pauseOnFocusLoss: true,
                pauseOnHover: true,
                draggable: true,
                draggablePercent: 0.6,
                showCloseButtonOnHover: false,
                hideProgressBar: false,
                closeButton: 'button',
                icon: true,
                rtl: false
            });
        },

        triggerErrorToast(message) {
            this.$toast.error(message, {
                position: 'bottom-right',
                timeout: 5000,
                closeOnClick: true,
                pauseOnFocusLoss: true,
                pauseOnHover: true,
                draggable: true,
                draggablePercent: 0.6,
                showCloseButtonOnHover: false,
                hideProgressBar: false,
                closeButton: 'button',
                icon: true,
                rtl: false
            });
        },

        triggerInfoToast(message) {
            this.$toast.info(message, {
                position: 'bottom-right',
                timeout: 5000,
                closeOnClick: true,
                pauseOnFocusLoss: true,
                pauseOnHover: true,
                draggable: true,
                draggablePercent: 0.6,
                showCloseButtonOnHover: false,
                hideProgressBar: false,
                closeButton: 'button',
                icon: true,
                rtl: false
            });
        },

        // Loop all errors

        loopAllErrorsAsTriggerErrorToast(errorResponse) {
            if ('response' in errorResponse && 'errors' in errorResponse.response.data) {
                let errors = [];
                Object.values(errorResponse.response.data.errors).map(error => {
                    errors = errors.concat(error);
                });
                errors.forEach(error => this.triggerErrorToast(error));
            } else if (errorResponse.response.data.message) {
                this.triggerErrorToast(errorResponse.response.data.message);
            }
        }
    }
};
