<template>
    <div>
        <div class="row">
            <div class="col-12">
                <h2>Profile</h2>
                <div class="alert alert-primary" role="alert" v-if="loading">
                    <b>Loading...</b>
                </div>
                <div class="alert alert-primary" role="alert" v-if="actionRequired">
                    <h5>Additional Information Needed</h5>
                    <template v-if="!this.hasEmergencyContact">Please complete the Emergency Contact fields below.<br/></template>
                    <template v-if="!this.hasSignedWaiver">Please sign the participation waiver using the link below.<br/></template>
                </div>
            </div>
        </div>
        <div class="row pt-3">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Name</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-4 col-lg-4">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" id="first_name" class="form-control" v-model="current_user.first_name">
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-4">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" id="last_name" class="form-control" v-model="current_user.last_name">
                            </div>
                            <div class="col-sm-12 col-md-4 col-lg-4">
                                <label for="alt_name" class="form-label">Knight Name</label>
                                <input type="text" id="alt_name" class="form-control" v-model="current_user.alt_name">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row pt-3">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Contact Information</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" id="email" class="form-control" v-model="current_user.email">
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" id="phone" class="form-control" v-model="current_user.phone">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pt-3">
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
                                <input type="text" id="emergency_contact_name" class="form-control" v-model="current_user.emergency_contact_name">
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <label for="emergency_contact_phone" class="form-label">Emergency Contact Phone</label>
                                <input type="tel" id="emergency_contact_phone" class="form-control" v-model="current_user.emergency_contact_phone">
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <label for="emergency_contact_relationship" class="form-label">Emergency Contact Relationship</label>
                                <input type="text" id="emergency_contact_relationship" class="form-control" v-model="current_user.emergency_contact_relationship">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row pt-3">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Participation Waiver</h5>
                    <div class="card-body">
                        <div class="row">
                            <p class="card-text">
                                In order to participate in any event, all participants must sign a participation waiver.
                                Our records indicate that you <b>have not</b> yet signed a waiver.
                                Please click the button below to sign.
                            </p>
                        </div>
                        <div class="row pt-3">
                            <div class="col-sm-12 col-md-4">
                                <button type="button" class="btn btn-secondary">Sign Waiver</button>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-muted">
                        It may take several minutes after signing for the correct status to reflect here.
                        If you have signed the waiver and after 30 minutes are still seeing this message, please contact Game Control.
                    </div>
                </div>
            </div>
        </div>
        <div class="row pt-3">
            <div class="col-sm-12 col-md-4">
                <button type="button" class="btn btn-primary">Save Profile</button>
            </div>
        </div>
    </div>
</template>
<script>
import CurrentUser from "../models/CurrentUser";

export default {
    name: "UserProfile",
    data: function () {
        return {
            current_user: {},
            loading: true,
        }
    },
    methods: {
        loadInitialData: async function() {
            this.current_user = await CurrentUser.first();
        },
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
        hasSignedWaiver: function() {
            return false
        }
    }
}
</script>
