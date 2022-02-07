<template>
    <div>
        <div class="row">
            <div class="col-12">
                <h2>Team Registration</h2>
                <div class="alert alert-warning" role="alert">
                    <b>Hold your horses!</b> You're already part of a team - there's no need to register again.
                    If you need help, please contact <a href="mailto:gamecontrol@getaclue.tech">Game Control</a>.
                </div>
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
        </div>
        <div class="row pt-3">
            <div class="col-12">
                <div class="card">
                    <h5 class="card-header">Team</h5>
                    <div class="card-body">
                        <div class="row">
                            <div class="mb-3 col-sm-12 col-md-6">
                                <label for="team_name" class="form-label" >Team Name</label>
                                <input type="text" class="form-control" id="team_name" v-model="registration.team_name">
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-sm-12 col-md-6">
                                <label for="team_motto" class="form-label">Team Motto</label>
                                <input type="text" class="form-control" id="team_motto" v-model="registration.team_motto">
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
                            Each member you specify here will receive an email with individual instructions after submitting your registration.
                            Please ensure all contact information is accurate. <b>Make sure to include yourself!</b>
                        </p>
                        <button type="button" class="btn btn-success">Add Team Member</button>
                        <div class="row pt-3">
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <label for="member_first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="member_first_name" required>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <label for="member_last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="member_last_name" required>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <label for="member_alt_name" class="form-label">Knight Name</label>
                                <input type="text" class="form-control" id="member_alt_name">
                            </div>
                        </div>
                        <div class="row pt-3">
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <label for="member_email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="member_email" required>
                            </div>
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <label for="member_phone" class="form-label">Phone Number</label>
                                <input type="text" class="form-control" id="member_phone" required>
                            </div>
                        </div>
                        <div class="row pt-3">
                            <div class="col-sm-12 col-md-6 col-lg-4">
                                <label for="member_affiliation" class="form-label">Affiliation</label>
                                <input type="text" class="form-control" id="member_affiliation" required>
                            </div>
                        </div>
                        <div class="row pt-3">
                            <div class="mb-3 col-sm-12 col-md-6">
                                <label for="additional_members" class="form-label mb-0">Additional Members</label>
                                <div class="form-text">
                                    Are you willing and able to have others who may not have a team join your team on game day?
                                </div>
                                <select class="form-select" name="additional_members" id="additional_members" required v-model="registration.additional_members">
                                    <option disabled selected>Select One</option>
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
                                    Amount Due: <b>$40</b> ($10 discount for including a RAT)
                                </div>
                                <select class="form-select" name="payment_method" id="payment_method" required v-model="registration.payment_method">
                                    <option disabled selected>Select One</option>
                                    <option value="venmo">In Advance - Venmo</option>
                                    <option value="google">In Advance - Google Pay</option>
                                    <option value="credit">In Advance - Credit/Debit Card</option>
                                    <option value="day_of">Day Of - Any Method</option>
                                    <option value="other">Other - Please contact me to discuss</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="mb-3 col-sm-12 col-md-6">
                                Terms & Conditions
                                <div class="form-text pb-2">
                                    Get-a-Clue is a fun, long standing tradition that is dependent on one simple rule: the first place team hosts GAC for the next year. By filling out this registration and participating, you are agreeing to follow this rule. You understand that if your team comes in first place, you will be expected to host GAC for 2023. GAC almost ended in 2017 because a team did not follow this rule. If you win but decide not to host, you are ending a 30+ year long tradition. We can even offer support and advice when you find yourself planning GAC. We want you to have fun. We don’t want you to panic. But we need you to understand that there’s a chance that you’ll end up with the responsibility, and it’s really not ok to just skip out on it. From generations of past, current, and future GAC players: we’re all counting on you.
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="1" id="accept_terms" required v-model="registration.accept_terms">
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
                <button type="button" class="btn btn-primary">Submit Registration</button>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "TeamRegistration",
    data: function () {
        return {
            registration: {
                team_name: "",
                team_motto: "",
                team_members: [],
                additional_members: "",
                payment_method: "",
                accept_terms: ""
            },
            adding_team_member: false
        }
    }
}
</script>

<style scoped>

</style>
