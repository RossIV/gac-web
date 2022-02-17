<template>
    <div>
        <div class="row">
            <div class="col-12">
                <h2>Team Registration</h2>
                <div class="alert alert-primary" role="alert" v-if="loading">
                    <b>Loading...</b>
                </div>
                <div class="alert alert-secondary" role="alert" v-if="!loading && events.length === 0">
                    <b>Eager beaver!</b> No events are currently accepting registrations. Please check back later.
                    If you need help, please contact <a href="mailto:gamecontrol@getaclue.tech">Game Control</a>.
                </div>
                <div class="alert alert-warning" role="alert" v-if="hasRegistration">
                    <b>Hold your horses!</b> You're already part of a team - there's no need to register again.
                    If you need help, please contact <a href="mailto:gamecontrol@getaclue.tech">Game Control</a>.
                </div>
            </div>
        </div>
        <div v-if="showRegistrationForm">
            <div class="row pt-3">
                <div>
                    Fill out the form below to get your team registered for Get a Clue!
                    After submitting the form, each team member will receive an email with some action items:
                    <ol>
                        <li>Confirm their email address</li>
                        <li>Electronically sign a participant liability waiver</li>
                        <li>Attest that they have been vaccinated against COVID-19</li>
                    </ol>
                    The member submitting this form will also receive an email with some additional action items:
                    <ol>
                        <li>Pay the registration fee for the team</li>
                    </ol>
                </div>
            </div>
            <div class="row pt-3">
                <div class="col-12">
                    <div class="card">
                        <h5 class="card-header">Event</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-sm-12 col-md-6">
                                    <b>Name:</b> {{ this.events[0].name }}<br/>
                                    <b>Location:</b> {{ this.events[0].location }}<br/>
                                    <b>Date:</b> {{ this.events[0].starts_at }} to {{ this.events[0].ends_at }}<br/>
                                    <b>Registration:</b> {{ this.events[0].registration_starts_at }} to {{ this.events[0].registration_starts_at }}<br/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pt-3">
                <div class="col-12">
                    <div class="card">
                        <h5 class="card-header">Team</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-sm-12 col-md-6">
                                    <label for="team_name" class="form-label" >Team Name</label>
                                    <input type="text" class="form-control" id="team_name" v-model="team.name">
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-sm-12 col-md-6">
                                    <label for="team_motto" class="form-label">Team Motto</label>
                                    <input type="text" class="form-control" id="team_motto" v-model="team.motto">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pt-3">
                <div class="col-12">
                    <div class="card">
                        <h5 class="card-header">Team Members</h5>
                        <div class="card-body">
                            <p class="card-text">
                                Each member specified here will receive an email with individual instructions after submitting the registration.
                                Please ensure all contact information is accurate. <b>Make sure to include yourself!</b>
                            </p>
                            <table class="table table-hover table-striped caption-top" v-if="team.members.length > 0">
                                <caption>{{ team.name }}</caption>
                                <thead class="table-light">
                                <th>Name</th><th>Email</th><th>Phone</th><th>Affiliation</th><th>Actions</th>
                                </thead>
                                <tbody>
                                <template v-for="member in team.members">
                                    <tr>
                                        <td>{{ member.first_name }} {{ member.last_name }} ({{ member.alt_name }})</td>
                                        <td>{{ member.email }}</td>
                                        <td>{{ member.phone }}</td>
                                        <td>{{ affiliationName(member.affiliation_id) }}</td>
                                        <td>
                                            <button type="button" class="btn btn-secondary">Edit</button>
                                            <button type="button" class="btn btn-danger">Delete</button>
                                        </td>
                                    </tr>
                                </template>
                                </tbody>
                            </table>
                            <button type="button" class="btn btn-success" v-if="!adding_team_member" v-on:click="add_new_team_member">
                                Add Team Member
                            </button>

                            <template v-if="adding_team_member">
                                <hr>
                                <h4>New Team Member Details:</h4>
                                <div class="row pt-3">
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <label for="member_first_name" class="form-label">First Name</label>
                                        <input type="text" class="form-control" id="member_first_name" required v-model="new_team_member.first_name">
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <label for="member_last_name" class="form-label">Last Name</label>
                                        <input type="text" class="form-control" id="member_last_name" required v-model="new_team_member.last_name">
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <label for="member_alt_name" class="form-label">Knight Name</label>
                                        <input type="text" class="form-control" id="member_alt_name" v-model="new_team_member.alt_name">
                                    </div>
                                </div>
                                <div class="row pt-3">
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <label for="member_email" class="form-label">Email Address</label>
                                        <input type="email" class="form-control" id="member_email" required v-model="new_team_member.email">
                                    </div>
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <label for="member_phone" class="form-label">Phone Number</label>
                                        <input type="text" class="form-control" id="member_phone" required v-model="new_team_member.phone">
                                    </div>
                                </div>
                                <div class="row pt-3">
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <label for="member_affiliation" class="form-label">Affiliation</label>
                                        <select id="member_affiliation" class="form-select" v-model="new_team_member.affiliation_id">
                                            <option selected disabled>Select One</option>
                                            <template v-for="affiliation in affiliations">
                                                <option :value="affiliation.id">{{ affiliation.name }}</option>
                                            </template>
                                        </select>
                                    </div>
                                </div>
                                <div class="row pt-3">
                                    <div class="col-sm-12 col-md-6 col-lg-4">
                                        <button type="button" class="btn btn-primary" v-on:click="process_new_team_member">Add Member</button>
                                        <button type="button" class="btn btn-danger" v-on:click="cancel_add_new_team_member">Cancel</button>
                                    </div>
                                </div>
                                <hr>
                            </template>

                            <div class="row pt-3">
                                <div class="mb-3 col-sm-12 col-md-6">
                                    <label for="additional_members" class="form-label mb-0">Additional Members</label>
                                    <div class="form-text">
                                        Are you willing and able to have others who may not have a team join your team on game day?
                                    </div>
                                    <select class="form-select" name="additional_members" id="additional_members" required v-model="team.accept_additional_members">
                                        <option selected disabled>Select One</option>
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pt-3">
                <div class="col-12">
                    <div class="card">
                        <h5 class="card-header">Additional Information</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-sm-12 col-md-6">
                                    <label for="payment_method" class="form-label mb-0">Payment Method</label>
                                    <div class="form-text">
                                        <b>Amount Due:</b> $40 ($10 discount for including a R.A.T.!)
                                    </div>
                                    <select class="form-select" name="payment_method" id="payment_method" required v-model="registration.payment_method_id">
                                        <option disabled selected>Select One</option>
                                        <template v-for="method in paymentMethods">
                                            <option :value="method.id">{{ method.name }}</option>
                                        </template>
                                    </select>
                                    <div class="form-text">
                                        {{ paymentMethodInstructions }}
                                    </div>
                                </div>
                            </div>
                            <div class="row" v-if="paymentNotesRequired">
                                <div class="mb-3 col-sm-12 col-md-6">
                                    <label for="payment_notes" class="form-label mb-0">Payment Notes</label>
                                    <div class="form-text">
                                        Please provide the username/email/phone from which you want the payment to be requested.
                                    </div>
                                    <input type="text" id="payment_notes" class="form-control" :required="paymentNotesRequired" v-model="registration.payment_notes">
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-sm-12 col-md-6">
                                    Terms & Conditions
                                    <div class="form-text pb-2">
                                        {{ events[0].terms }}
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="1" id="accept_terms" required v-model="registration.terms_agreed">
                                        <label class="form-check-label" for="accept_terms">
                                            We accept the terms & conditions.
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row pt-3 pb-3">
                <div class="col-12">
                    <button type="button" class="btn btn-primary" v-on:click="submitRegistration">Submit Registration</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Affiliation from '../models/Affiliation'
import Event from '../models/Event'
import EventRegistration from '../models/EventRegistration'
import PaymentMethod from '../models/PaymentMethod'
import Team from '../models/Team'

export default {
    name: "TeamRegistration",
    data: function () {
        return {
            registration: {
                event_id: "",
                team_id: "",
                payment_method_id: "",
                payment_notes: "",
                terms_agreed: ""
            },
            team: {
                name: "",
                motto: "",
                members: [],
                accept_additional_members: "",
            },
            adding_team_member: false,
            editing_team_member: false,
            new_team_member: {
                first_name: "",
                last_name: "",
                alt_name: "",
                email: "",
                phone: "",
                affiliation_id: ""
            },
            events: [],
            affiliations: [],
            paymentMethods: [],
            hasRegistration: false,
            loading: true
        }
    },
    methods: {
        add_new_team_member: function() {
            this.adding_team_member = true;
        },
        cancel_add_new_team_member: function() {
            this.adding_team_member = false;
            this.new_team_member = {};
        },
        process_new_team_member: function() {
            this.team.members.push(this.new_team_member)
            this.adding_team_member = false;
            this.new_team_member = {};
        },
        load_initial_data: async function() {
            this.events = await Event.where('active_registration', '1').get();
            this.affiliations = await Affiliation.get();
            this.paymentMethods = await PaymentMethod.get();
        },
        submitRegistration: async function() {
            let team = await (new Team(this.team)).save()
            console.log(team)

            this.registration.event_id = this.events[0].id
            this.registration.team_id = team.id
            let registration = await (new EventRegistration(this.registration)).save()
            console.log(registration)
        },
        affiliationName: function(id) {
            let affil = this.affiliations.filter(obj => {return obj['id'] === id})[0]
            return affil.name
        }
    },
    mounted: function() {
        this.loading = true
        this.load_initial_data()
        this.loading = false
    },
    computed: {
        showRegistrationForm: function() {
            return !this.loading && this.events.length > 0
        },
        paymentNotesRequired: function() {
            if (this.registration.payment_method_id) {
                let method = this.paymentMethods.filter(obj => {return obj['id'] === this.registration.payment_method_id})[0]
                return method.additional_info_required
            } else {
                return false
            }
        },
        paymentMethodInstructions: function() {
            if (this.registration.payment_method_id) {
                let method = this.paymentMethods.filter(obj => {return obj['id'] === this.registration.payment_method_id})[0]
                let fee = (method.fee !== 0) ? ` ($${method.fee} Fee Applies)` : ''
                return method.instructions + fee
            } else {
                return ''
            }
        }
    }
}
</script>

<style scoped>

</style>
