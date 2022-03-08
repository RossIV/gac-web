<template>
    <main class="form-signin">
        <h1>{{ appname }}</h1>
        <h2 class="h3 mb-3 fw-normal">{{ actionText }}</h2>


        <div class="row">
            <div class="col-12">
                <div class="form-floating">
                    <input type="email" class="form-control" id="email" placeholder="name@example.com" v-model="$v.user.email.$model" :class="{ 'is-invalid': $v.user.email.$error }">
                    <label for="email">Email address</label>
                    <div class="invalid-feedback" v-if="!$v.user.email.required">Email is required</div>
                    <div class="invalid-feedback" v-if="!$v.user.email.email">Email must be a valid email address</div>
                </div>
            </div>
        </div>
        <template v-if="registering">
            <div class="row pt-3">
                <div class="col-12">
                    <h5>Looks like you're new here...</h5>
                    <p>Tell us a little bit about yourself, and we'll get your account created.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <label for="first_name" class="form-label">First Name</label>
                    <input type="text" id="first_name" class="form-control" v-model="$v.user.first_name.$model" :class="{ 'is-invalid': $v.user.first_name.$error }">
                    <div class="invalid-feedback" v-if="!$v.user.first_name.required">First Name is required</div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <label for="last_name" class="form-label">Last Name</label>
                    <input type="text" id="last_name" class="form-control" v-model="$v.user.last_name.$model" :class="{ 'is-invalid': $v.user.last_name.$error }">
                    <div class="invalid-feedback" v-if="!$v.user.last_name.required">Last Name is required</div>
                </div>
            </div>
            <div class="row pt-2">
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <label for="phone" class="form-label">Phone</label> <small>(numbers only)</small>
                    <input type="tel" id="phone" class="form-control" v-model="$v.user.phone.$model" :class="{ 'is-invalid': $v.user.phone.$error }">
                    <div class="invalid-feedback" v-if="!$v.user.phone.required">Phone Number is required</div>
                    <div class="invalid-feedback" v-if="!$v.user.phone.numeric">Phone Number must contain numbers only</div>
                </div>
                <div class="col-sm-12 col-md-6 col-lg-6">
                    <label for="affiliation_id" class="form-label">Affiliation</label>
                    <select id="affiliation_id" class="form-select" v-model="user.affiliation_id" :class="{ 'is-invalid': $v.user.affiliation_id.$error }">
                        <option selected disabled>Select One</option>
                        <template v-for="affiliation in affiliations">
                            <option :value="affiliation.id">{{ affiliation.name }}</option>
                        </template>
                    </select>
                    <div class="invalid-feedback" v-if="!$v.user.affiliation_id.required">Affiliation is required</div>
                </div>
            </div>
        </template>


        <button class="w-100 btn btn-lg btn-primary mt-3" type="button" v-on:click="process" :class="actionButtonClass" v-html="actionButtonText"></button>

        <div class="row pt-3">
            <div class="col">
                <small>
                    {{ appname }} uses magic links to authenticate.
                    Simply submit your email address above, click the link in your inbox, and you're in!<br/><br/>
                    If you're new here, don't worry - we'll prompt you to create an account automatically.
                </small>
            </div>
        </div>
    </main>
</template>
<script>
import Swal from 'sweetalert2'
import {required, email, numeric, requiredIf} from 'vuelidate/lib/validators'
import * as Sentry from "@sentry/vue";

export default {
    name: "Login",
    props: {
        appname: String,
        affiliations: Array
    },
    data: function () {
        return {
            registering: false,
            submitting: false,
            user: {
                email: '',
                first_name: '',
                last_name: '',
                phone: '',
                affiliation_id: ''
            }
        }
    },
    methods: {
        process: async function() {
            this.submitting = true;
            if (!this.registering) {
                return this.loginUser()
            } else {
                return this.registerUser()
            }
        },
        registerUser: async function() {
            let self = this
            if (this.$v.user.$invalid) {
                this.$v.user.$touch()
                return
            }
            await axios.post('/api/auth/register', this.user)
                .then(function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Please check your email for a link to finish logging in.',
                        icon: 'success',
                        showCancelButton: false,
                        showCloseButton: true
                    })
                })
                .catch(function(error) {
                    self.handleAxiosError(error, 'register')
                })
                .finally(function() {
                    self.registering = false;
                    self.submitting = false;
                    let email = self.user.email;
                    self.user = {}
                    self.user.email = email
                })
        },
        loginUser: async function() {
            let self = this
            if (this.$v.user.email.$invalid) {
                this.$v.user.email.$touch()
                return
            }
            await axios.post('/api/auth/login', {email: this.user.email})
                .then(function(response) {
                    Swal.fire({
                        title: 'Success!',
                        text: 'Please check your email for a link to finish logging in.',
                        icon: 'success',
                        showCancelButton: false,
                        showCloseButton: true
                    })
                })
                .catch(function(error) {
                    self.handleAxiosError(error, 'login')
                })
                .finally(function() {
                    self.submitting = false;
                })
        },
        handleAxiosError: function(error, action) {
            let self = this
            let msg = ''
            if (error.response) {
                if (error.response.status === 422 && action === 'login') {
                    // Email doesn't exist, need to register
                    self.registering = true
                    self.$v.user.$reset()
                    return
                } else if (error.response.status === 422 && action === 'register') {
                    if (error.response.data.errors) {
                        let errors = []
                        for (const [key, value] of Object.entries(error.response.data.errors)) {
                            errors.push(value[0])
                        }
                        msg = errors.join('\n')
                    }
                } else {
                    console.log('Response Error', error.response)
                }
            } else if (error.request) {
                console.log('Request Error', error.request)
            } else {
                console.log('Unknown Error', error.message)
            }

            Sentry.captureException(error);

            if (msg.length === 0) {
                msg = 'Something went wrong processing your request. '
                msg += 'Please try again, or contact Game Control if the issue persists.'
            }

            Swal.fire({
                title: 'Whoops!',
                text: msg,
                icon: 'error',
                showCancelButton: false,
                showCloseButton: true
            })
        },
    },
    computed: {
        actionText: function() {
            return (this.registering) ? 'Register' : 'Login';
        },
        actionButtonClass: function() {
            if (this.submitting) {
                return 'btn btn-secondary'
            } else {
                return (this.$v.user.$anyError && this.$v.user.$anyDirty) ? 'btn btn-danger' : 'btn btn-primary'
            }
        },
        actionButtonText: function() {
            if (this.submitting) {
                return `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`
            } else {
                return (this.$v.user.$anyError && this.$v.user.$anyDirty) ? 'Whoops! Please resolve all listed errors.' : this.actionText
            }
        }
    },
    validations: {
        user: {
            email: { required, email},
            first_name: { required: requiredIf(function(foo) { return this.registering })},
            last_name: { required: requiredIf(function(foo) { return this.registering })},
            phone: { required: requiredIf(function(foo) { return this.registering }), numeric },
            affiliation_id: { required: requiredIf(function(foo) { return this.registering })},
        }
    }
}
</script>
