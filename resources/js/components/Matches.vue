<template>

     <div>
        <!-- Live Matches -->
        <!-- Bindovanje da proverim -->
        <div class="container card mt-4 mb-4" v-if="liveMatches.length > 0">
            <div class="card-body">
                <h3>Live</h3>
                <div class="row justify-content-between" >
                        <div class="col-md-5 m-4" style="border: dashed 4px; padding: 20px" v-for="match in liveMatches">
                            <div class="row">
                                <div class="col-md-4">
                                    <img style="max-width: 100%;" v-bind:src="match.team_match.home.image">
                                </div>
                                <div class="col-md-4" style="font-size: 20px;">
                                    <div class="col-md-12 text-center">{{match.team_match.home_statistic.points}} - {{match.team_match.guest_statistic.points}}</div>
                                    <div class="col-md-12 text-center"><a class="btn btn-sm btn-dark" v-bind:href="'/matches/' + match.id">Details</a></div>
                                </div>
                                <div class="col-md-4">
                                    <img class="" style="max-width: 100%;" v-bind:src="match.team_match.guest.image">
                                </div>
                                <div class="col-md-4 text-center">
                                    <strong>{{match.team_match.home.short_name}}</strong>
                                </div>
                                <div class="col-md-4 text-center">
                                    {{match.carbon}}
                                </div>
                                <div class="col-md-4 text-center">
                                    <strong>{{match.team_match.guest.short_name}}</strong>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>

        <!-- Upcoming Matches -->
        <div class="container card mt-4 mb-4" v-if="upcomingMatches.length > 0">
            <div class="card-body">
                <h3>Upcoming</h3>
                <div class="row justify-content-between">
                        <div class="col-md-5 m-4" style="border: dashed 1px; padding: 20px" v-for="match in upcomingMatches">
                            <div class="row">
                                <div class="col-md-4">
                                    <img style="max-width: 100%;" v-bind:src="match.team_match.home.image">
                                </div>
                                <div class="col-md-4" style="font-size: 20px;">
                                    <div class="col-md-12 text-center">{{match.team_match.home_statistic.points}} - {{match.team_match.guest_statistic.points}}</div>
                                    <div class="col-md-12 text-center"><a v-bind:href="'/matches/' + match.id" class="btn btn-sm btn-dark ">Details</a></div>
                                </div>
                                <div class="col-md-4">
                                    <img class="" style="max-width: 100%;" v-bind:src="match.team_match.guest.image">
                                </div>
                                <div class="col-md-4 text-center">
                                    <strong>{{match.team_match.home.short_name}}</strong>
                                </div>
                                <div class="col-md-4 text-center">
                                    {{match.carbon}}
                                </div>
                                <div class="col-md-4 text-center">
                                    <strong>{{match.team_match.guest.short_name}}</strong>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>

        <!-- Finished Matches -->
        <div class="container card mt-4 mb-4" v-if="finishedMatches.length > 0">
            <div class="card-body">
                <h3>Finished</h3>
                <div class="row justify-content-between" >
                        <div class="col-md-5 m-4" style="border: dashed 1px; padding: 20px" v-for="match in finishedMatches">
                            <div class="row">
                                <div class="col-md-4">
                                    <img style="max-width: 100%;" v-bind:src="match.team_match.home.image">
                                </div>
                                <div class="col-md-4" style="font-size: 20px;">
                                    <div class="col-md-12 text-center">{{match.team_match.home_statistic.points}} - {{match.team_match.guest_statistic.points}}</div>
                                    <div class="col-md-12 text-center"><a v-bind:href="'/matches/' + match.id" class="btn btn-sm btn-dark ">Details</a></div>
                                </div>
                                <div class="col-md-4">
                                    <img class="" style="max-width: 100%;" v-bind:src="match.team_match.guest.image">
                                </div>
                                <div class="col-md-4 text-center">
                                    <strong>{{match.team_match.home.short_name}}</strong>
                                </div>
                                <div class="col-md-4 text-center">
                                    {{match.carbon}}
                                </div>
                                <div class="col-md-4 text-center">
                                    <strong>{{match.team_match.guest.short_name}}</strong>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>


    export default {
        name: "matches",
        data() {
            return {
                liveMatches: {},
                upcomingMatches: {},
                finishedMatches: {}
            }
        },

        methods: {

        },

        mounted() {
            axios.get('/matches/data')
                .then(response => {
                   this.liveMatches = response.data.liveMatches;
                   this.finishedMatches = response.data.finishedMatches;
                   this.upcomingMatches = response.data.upcomingMatches;
                });
        },

        sockets : {
            liveMatches (data) {
                let newData = JSON.parse(data);

                let match = this.liveMatches.find(m => {
                    return m.id === Number(newData.matchId);
                });

                if(match != null) {
                    if(match.team_match.guest.id === newData.teamId) {
                        match.team_match.guest_statistic.points = newData.value;
                    }
                    else if (match.team_match.home.id === newData.teamId) {
                        match.team_match.home_statistic.points = newData.value;
                    }
                }
            }
        },
    }
</script>
