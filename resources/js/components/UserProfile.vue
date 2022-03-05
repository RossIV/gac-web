<template>
    <div>
        <div class="row">
            <div class="col-12">
                <h2>Profile</h2>
                <div class="alert alert-primary" role="alert" v-if="loading">
                    <b>Loading...</b>
                </div>
                <div class="alert alert-primary" role="alert" v-if="!loading && actionRequired">
                    <h5>Additional Information Needed</h5>
                    <template v-if="!this.hasEmergencyContact">Please complete the Emergency Contact fields below.<br/></template>
                    <template v-if="!this.hasSignedWaiver">Please sign the participation waiver using the link below.<br/></template>
                </div>
                <div class="alert alert-success" role="alert" v-if="!loading && !actionRequired">
                    <h5>You're all set!</h5>
                    We have everything needed from you at this time. See you soon!
                </div>
            </div>
        </div>
        <div class="row pt-3" v-if="!loading">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Personal Information</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-4 col-lg-4">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" id="first_name" class="form-control" v-model="$v.current_user.first_name.$model" :class="{ 'is-invalid': $v.current_user.first_name.$error }">
                                <div class="invalid-feedback" v-if="!$v.current_user.first_name.required">First Name is required</div>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-4">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" id="last_name" class="form-control" v-model="$v.current_user.last_name.$model" :class="{ 'is-invalid': $v.current_user.last_name.$error }">
                                <div class="invalid-feedback" v-if="!$v.current_user.last_name.required">Last Name is required</div>
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-4">
                                <label for="alt_name" class="form-label">Knight Name</label>
                                <input type="text" id="alt_name" class="form-control" v-model="$v.current_user.alt_name.$model" :class="{ 'is-invalid': $v.current_user.alt_name.$error }">
                                <div class="invalid-feedback" v-if="!$v.current_user.alt_name.required">Knight Name is required</div>
                            </div>
                        </div>
                        <div class="row pt-3">
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" id="email" class="form-control" v-model="$v.current_user.email.$model" :class="{ 'is-invalid': $v.current_user.email.$error }">
                                <div class="invalid-feedback" v-if="!$v.current_user.email.required">Email is required</div>
                                <div class="invalid-feedback" v-if="!$v.current_user.email.email">Email must be a valid email address</div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <label for="phone" class="form-label">Phone</label> <small>(numbers only)</small>
                                <input type="tel" id="phone" class="form-control" v-model="$v.current_user.phone.$model" :class="{ 'is-invalid': $v.current_user.phone.$error }">
                                <div class="invalid-feedback" v-if="!$v.current_user.phone.required">Phone Number is required</div>
                                <div class="invalid-feedback" v-if="!$v.current_user.phone.numeric">Phone Number must contain numbers only</div>
                            </div>
                        </div>
                        <div class="row pt-3">
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <label for="affiliation_id" class="form-label">Affiliation</label>
                                <select id="affiliation_id" class="form-select" v-model="current_user.affiliation_id" :class="{ 'is-invalid': $v.current_user.affiliation_id.$error }">
                                    <option selected disabled>Select One</option>
                                    <template v-for="affiliation in affiliations">
                                        <option :value="affiliation.id">{{ affiliation.name }}</option>
                                    </template>
                                </select>
                                <div class="invalid-feedback" v-if="!$v.current_user.affiliation_id.required">Affiliation is required</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row pt-3" v-if="!loading">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Emergency Contact</h5>
                    <div class="card-body">
                        <div class="row">
                            <p class="card-text">
                                While extremely unlikely, unforeseen circumstances can occur during events that necessitate Game Control contacting someone on your behalf.
                                Please provide contact information here for someone <b>other than yourself</b> who Game Control should contact in case an emergency situation should arise.
                                <b>This information is NOT shared with ANYONE outside of Game Control!</b>
                            </p>
                        </div>
                        <div class="row pt-3">
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <label for="emergency_contact_name" class="form-label">Emergency Contact Name</label>
                                <input type="text" id="emergency_contact_name" class="form-control" v-model="$v.current_user.emergency_contact_name.$model" :class="{ 'is-invalid': $v.current_user.emergency_contact_name.$error }">
                                <div class="invalid-feedback" v-if="!$v.current_user.emergency_contact_name.required">Emergency Contact Name is required</div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <label for="emergency_contact_phone" class="form-label">Emergency Contact Phone</label> <small>(numbers only)</small>
                                <input type="tel" id="emergency_contact_phone" class="form-control" v-model="$v.current_user.emergency_contact_phone.$model" :class="{ 'is-invalid': $v.current_user.emergency_contact_phone.$error }">
                                <div class="invalid-feedback" v-if="!$v.current_user.emergency_contact_phone.required">Emergency Contact Phone is required</div>
                                <div class="invalid-feedback" v-if="!$v.current_user.emergency_contact_phone.numeric">Emergency Contact Phone must contain numbers only</div>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <label for="emergency_contact_relationship" class="form-label">Emergency Contact Relationship</label>
                                <input type="text" id="emergency_contact_relationship" class="form-control" v-model="$v.current_user.emergency_contact_relationship.$model" :class="{ 'is-invalid': $v.current_user.emergency_contact_relationship.$error }">
                                <div class="invalid-feedback" v-if="!$v.current_user.emergency_contact_relationship.required">Emergency Contact Relationship is required</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pt-3" v-if="!loading && hasEventRegistration">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Participation Waiver</h5>
                    <div class="card-body">
                        <div class="row">
                            <p class="card-text">
                                In order to participate in any event, all participants must sign a participation waiver.
                                <template v-if="!hasSignedWaiver">
                                    Our records indicate that you <b>have not</b> yet signed a waiver.
                                    Please click the button below to sign.
                                </template>
                                <template v-else>
                                    Our records indicate that you <b>have</b> signed a waiver. Thank you!
                                </template>
                            </p>
                        </div>
                        <div class="row pt-3" v-if="!hasSignedWaiver">
                            <div class="col-sm-12 col-md-4">
                                <a class="btn btn-secondary" role="button" target="_blank" :href="pendingSignatureURL">Sign Waiver</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-muted" v-if="!hasSignedWaiver">
                        It may take several minutes after signing for the correct status to reflect here.
                        If you have signed the waiver and after 30 minutes are still seeing this message, please contact Game Control.
                    </div>
                </div>
            </div>
        </div>
        <div class="row pt-3" v-if="!loading">
            <div class="col-sm-12 col-md-4">
                <button type="button" class="btn btn-primary" v-on:click="processUser" :class="saveButtonClass" :disabled="submitting" v-html="saveButtonText">Save Profile</button>
            </div>
        </div>
    </div>
</template>
<script>
import Affiliation from "../models/Affiliation";
import CurrentUser from "../models/CurrentUser";
import User from "../models/User";
import { required, email, numeric } from 'vuelidate/lib/validators'
import Swal from 'sweetalert2'
import * as Sentry from "@sentry/vue";

export default {
    name: "UserProfile",
    data: function () {
        return {
            affiliations: [],
            current_user: {},
            loading: true,
            submitting: false
        }
    },
    methods: {
        loadInitialData: async function() {
            try {
                this.affiliations = await Affiliation.get();
                let relationships = ['eventRegistrations', 'signatures', 'signaturesPending']
                this.current_user = await CurrentUser.with(relationships).first();
            } catch(error) {
                Sentry.captureException(error);
                let msg = 'Something went wrong while loading data. '
                msg += 'Please try again, or contact Game Control if the issue persists.'
                Swal.fire({
                    title: 'Whoops!',
                    text: msg,
                    icon: 'error',
                    showCancelButton: false,
                    showCloseButton: true
                })
            }
        },
        getDirtyFields: function() {
            // https://github.com/vuelidate/vuelidate/issues/646
            let dirtyFieldsModel = {};
            let model = this.$v.current_user;
            const recurModel = (node,model)=>{
                for (let field in node) {
                    if (node.hasOwnProperty(field)) {
                        //check if field is your model field and it changed
                        if (typeof node[field].$model != 'undefined' && node[field].$dirty) {
                            model[field] = node[field].$model;
                        //check if field is your model field and it is object that has changed childs
                        } else if (typeof node[field].$model != 'undefined' && node[field].$anyDirty && typeof node[field].$model == 'object'){
                            model[field] = {};
                            //recursive iterate through children of current object type field
                            recurModel(node[field],model[field]);
                        }
                    }
                }
            }
            recurModel(model,dirtyFieldsModel);
            return dirtyFieldsModel
        },
        processUser: async function() {
            this.submitting = true
            this.$v.current_user.$touch()
            if (!this.$v.current_user.$invalid) {
                try {
                    let dirty_user = this.getDirtyFields()
                    dirty_user.id = this.current_user.id
                    await (new User(dirty_user)).patch()
                    this.submitting = false
                } catch (error) {
                    Sentry.captureException(error);
                    this.submitting = false
                    let msg = 'Something went wrong processing your profile. '
                    msg += 'Please try again, or contact Game Control if the issue persists.'
                    await Swal.fire({
                        title: 'Whoops!',
                        text: msg,
                        icon: 'error',
                        timer: 5000,
                        showCancelButton: false,
                        showCloseButton: true
                    })
                    return
                }

                await Swal.fire({
                    title: 'Success!',
                    text: 'Your profile has been updated.',
                    icon: 'success',
                    timer: 4000,
                    showCancelButton: false,
                    showCloseButton: false
                })
            }
            this.submitting = false
        }
    },
    mounted: function() {
        this.loading = true
        this.loadInitialData()
        this.loading = false
    },
    computed: {
        actionRequired: function() {
            return !this.hasEmergencyContact || !this.hasSignedWaiver
        },
        hasEmergencyContact: function() {
            return (
                this.current_user.emergency_contact_name &&
                this.current_user.emergency_contact_phone &&
                this.current_user.emergency_contact_relationship
            )
        },
        hasEventRegistration: function() {
            return this.current_user
                && this.current_user.hasOwnProperty('eventRegistrations')
                && this.current_user.eventRegistrations.length > 0
        },
        hasSignedWaiver: function() {
            return this.current_user
                && this.current_user.hasOwnProperty('signaturesPending')
                && this.current_user.signaturesPending.length === 0
        },
        saveButtonClass: function() {
            if (this.submitting) {
                return 'btn btn-secondary'
            } else {
                return (this.$v.current_user.$invalid && this.$v.current_user.$anyDirty) ? 'btn btn-danger' : 'btn btn-primary'
            }
        },
        saveButtonText: function() {
            if (this.submitting) {
                return `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`
            } else {
                return (this.$v.current_user.$invalid && this.$v.current_user.$anyDirty) ? 'Whoops! Please resolve all listed errors.' : 'Save User'
            }
        },
        pendingSignatureURL: function() {
            if (this.current_user.signaturesPending && this.current_user.signaturesPending.length > 0) {
                let base_url = this.current_user.signaturesPending[0].document_url
                let email = this.current_user.email
                return `${base_url}&email=${email}`
            }
        }
    },
    validations: {
        current_user: {
            first_name: { required },
            last_name: { required },
            alt_name: { required },
            email: { required, email },
            phone: { required, numeric },
            affiliation_id: { required, numeric },
            emergency_contact_name: { required },
            emergency_contact_phone: { required, numeric },
            emergency_contact_relationship: { required },
        }
    }
}
</script>
