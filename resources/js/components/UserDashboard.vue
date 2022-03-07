<template>
    <div>
        <div class="row">
            <div class="col-12">
                <h2>Dashboard</h2>
                <div class="alert alert-primary" role="alert" v-if="loading">
                    <b>Loading...</b>
                </div>
            </div>
        </div>
        <div class="row" v-if="!loading">
            <div class="col-sm-12 col-md-4" v-if="hasOutstandingParticipantTasks">
                <div class="card">
                    <div class="card-header">Participant Action Required</div>
                    <div class="card-body">
                        <h5 class="card-title">Additional Information Needed</h5>
                        <p class="card-text">
                            You're registered for an event, but we need some more information to confirm your participation.
                        </p>
                        <a href="/profile" class="btn btn-primary">Finalize My Registration Now</a>
                    </div>
                </div>
            </div>
            <template v-for="team in current_user.teams" v-if="isMemberOfTeam">
                <div class="col-sm-12 col-md-4">
                    <div class="card">
                        <div class="card-header">My Team</div>
                        <div class="card-body">
                            <h5 class="card-title">{{ team.name }}</h5>
                            <p class="card-text">
                                {{ teamMemberCountSentence(team) }}
                            </p>
                            <a href="/my-team" class="btn btn-primary">View My Team</a>
                        </div>
                    </div>
                </div>
            </template>
            <div class="col-sm-12 col-md-4" v-if="teamsWithOutstandingPayment">
                <div class="card">
                    <div class="card-header">Team Leader Action Required</div>
                    <div class="card-body">
                        <h5 class="card-title">Payment Needed</h5>
                        <p class="card-text">
                            We have not yet received payment for your event registration.
                        </p>
                    </div>
                    <div class="card-footer">
                        <small>If you opted to pay in-person on game day, you can safely disregard this message.</small>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4" v-if="teamsWithRegistration">
                <div class="card">
                    <div class="card-header">Participant Action Recommended</div>
                    <div class="card-body">
                        <h5 class="card-title">Download ClueKeeper</h5>
                        <p class="card-text">
                            ClueKeeper is the app that we use to navigate you and your team throughout the day from clue site to clue site.
                            We strongly encourage downloading it in advance for easier use on game day.
                        </p>
                        <a href="https://cluekeeper.com/app" class="btn btn-primary" target="_blank">Download Now</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-4" v-if="!teamsWithRegistration && events && events.length > 0">
                <div class="card">
                    <div class="card-header">Upcoming Events</div>
                    <div class="card-body">
                        <h5 class="card-title">{{ events[0].name }}</h5>
                        <p class="card-text">
                            Team registration is open until {{ friendlyRegistrationEndDate }}
                        </p>
                        <a href="/team-registration" class="btn btn-primary">Register Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
import Event from "../models/Event";
import CurrentUser from "../models/CurrentUser";
import {format, formatRelative} from "date-fns";
import Swal from "sweetalert2";
import * as Sentry from "@sentry/vue";

export default {
    name: "UserDashboard",
    data: function () {
        return {
            current_user: {},
            events: [],
            loading: true,
        }
    },
    methods: {
        loadInitialData: async function() {
            try {
                this.events = await Event.where('active_registration', '1').get();
                let userRelations = ['nativeTeams', 'nativeTeams.registrations', 'signaturesPending']
                this.current_user = await CurrentUser.with(userRelations).first();
            } catch (error) {
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
        teamMemberCountSentence: function(team) {
            let adjustedCount = team.usersCount - 1
            if (adjustedCount === 0) {
                return 'You are the only member of this team.'
            } else if (adjustedCount === 1) {
                return 'You are a member of this team, along with one other person.'
            } else {
                return `You are a member of this team, along with ${adjustedCount} other people.`
            }
        }
    },
    mounted: function() {
        this.loading = true
        this.loadInitialData()
        this.loading = false
    },
    computed: {
        friendlyRegistrationEndDate: function() {
            let relative = formatRelative(Date.parse(this.events[0].registration_ends_at), new Date())
            let formatted = format(Date.parse(this.events[0].registration_ends_at), "PPPP p")
            return (relative.includes('at')) ? relative : formatted
        },
        ownedTeams: function() {
            let self = this
            return this.current_user.teams && this.current_user.teams.length > 0
                && this.current_user.teams.filter(function(team) { return team.owner_id === self.current_user.id })
        },
        teamsWithOutstandingPayment: function() {
            let teams = this.ownedTeams && this.ownedTeams.length > 0
                && this.ownedTeams.filter(function (team) { return team.registrations[0].payment_due })
            return (Array.isArray(teams) && teams.length > 0)
        },
        teamsWithRegistration: function() {
            return this.current_user.teams && this.current_user.teams.length > 0
                && this.current_user.teams.filter(function(team) { return team.registrations.length > 0 })
        },
        hasOutstandingParticipantTasks: function() {
            // Member of a team with a registration, and has tasks that need to be done
            return this.teamsWithRegistration && this.teamsWithRegistration.length > 0 &&
                (
                    !this.current_user.profile_complete ||
                    (this.current_user.signaturesPending &&
                        this.current_user.signaturesPending.length > 0)
                )
        },
        isMemberOfTeam: function() {
            return this.current_user.teams && this.current_user.teams.length > 0
        }
    }
}
</script>
