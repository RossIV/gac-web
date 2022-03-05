<template>
    <div>
        <div class="row">
            <div class="col-12">
                <h2>My Team</h2>
                <div class="alert alert-primary" role="alert" v-if="loading">
                    <b>Loading...</b>
                </div>
            </div>
        </div>
        <template v-if="!loading" v-for="team in current_user.teams">
            <div class="row pt-3">
                <div class="col-12">
                    <div class="card">
                        <h5 class="card-header">Team</h5>
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-sm-12 col-md-6">
                                    <label for="team_name" class="form-label">Team Name</label>
                                    <input type="text" class="form-control" id="team_name" v-model="team.name" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="mb-3 col-sm-12 col-md-6">
                                    <label for="team_motto" class="form-label">Team Motto</label>
                                    <input type="text" class="form-control" id="team_motto" v-model="team.motto" readonly>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <table class="table table-hover table-striped caption-top" v-if="team.users.length > 0">
                                        <caption>Team Members</caption>
                                        <thead class="table-light">
                                        <th>Name</th><th>Email</th><th>Phone</th><th>Affiliation</th>
                                        </thead>
                                        <tbody>
                                        <template v-for="(member, index) in team.users">
                                            <tr>
                                                <td>{{ member.first_name }} {{ member.last_name }} ({{ member.alt_name }})</td>
                                                <td>{{ member.email }}</td>
                                                <td>{{ member.phone }}</td>
                                                <td>{{ affiliationName(member.affiliation_id) }}</td>
                                            </tr>
                                        </template>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </div>
</template>
<script>
import Event from "../models/Event";
import Affiliation from "../models/Affiliation";
import PaymentMethod from "../models/PaymentMethod";
import CurrentUser from "../models/CurrentUser";
import Swal from "sweetalert2";
import * as Sentry from "@sentry/vue";

export default {
    name: "MyTeam",
    data: function() {
        return {
            loading: true,
            current_user: {
                teams: []
            }
        }
    },
    methods: {
        loadInitialData: async function() {
            try {
                this.events = await Event.where('active_registration', '1').get();
                this.affiliations = await Affiliation.get();
                let relationships = ['eventRegistrations', 'nativeTeams', 'nativeTeams.users']
                this.current_user = await CurrentUser.with(relationships).first();
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
        affiliationName: function(id) {
            let affil = this.affiliations.filter(obj => {return obj['id'] === id})[0]
            return affil.name
        }
    },
    mounted: function() {
        this.loading = true
        this.loadInitialData()
        this.loading = false
    },
    computed: {

    }
}
</script>
