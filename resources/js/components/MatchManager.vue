<template>
    <div class="container mt-4">
        <div class="row">
            <div id="home" class="col-md-4 p-4">
                <div class="row">
                    <strong class="mr-4">Choose addition:</strong>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" value=1 name="homeoptradio">1p
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" value=2 name="homeoptradio" checked>2p
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input" value=3 name="homeoptradio">3p
                        </label>
                    </div>
                </div>
                <div class="row">
                    <table class="table mt-4">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Chose Option</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="currentPlayer in this.team_match.home.current_players">
                            <th scope="row">{{currentPlayer.number}}</th>
                            <td>{{currentPlayer.player.name}}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button
                                        type="button"
                                        @click="score('home', currentPlayer.player.id)"
                                        class="btn btn-sm btn-secondary"
                                        :disabled="isFinished"
                                    >
                                        P
                                    </button>
                                    <button
                                        type="button"
                                        @click="addition('blocks', 'home', currentPlayer.player.id)"
                                        class="btn btn-sm btn-secondary"
                                        :disabled="isFinished"
                                    >
                                        B
                                    </button>
                                    <button
                                        type="button"
                                        @click="addition('rebounds', 'home', currentPlayer.player.id)"
                                        class="btn btn-sm btn-secondary"
                                        :disabled="isFinished"
                                    >
                                        R
                                    </button>
                                    <button
                                        type="button"
                                        @click="addition('fouls', 'home', currentPlayer.player.id)"
                                        class="btn btn-sm btn-secondary"
                                        :disabled="isFinished"
                                    >
                                        F
                                    </button>
                                    <button
                                        type="button"
                                        @click="addition('assists', 'home', currentPlayer.player.id)"
                                        class="btn btn-sm btn-secondary"
                                        :disabled="isFinished"
                                    >
                                        A
                                    </button>
                                    <button
                                        type="button"
                                        @click="addition('steals', 'home', currentPlayer.player.id)"
                                        class="btn btn-sm btn-secondary"
                                        :disabled="isFinished"
                                    >
                                        S
                                    </button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="match-view" class="col-md-4">
                <div class="row">
                    <div class="col-md-4">
                        <img class="float-left" id="club-logo" :src="this.team_match.home.image">
                    </div>
                    <div id="result" class="col-md-4 text-center">
                        <div class="col-md-12">{{this.team_match.home_statistic.points}} - {{this.team_match.guest_statistic.points}}</div>
                        <div class="col-md-12"><button id="finish" @click="finishMatch" :class="this.finishClass">{{this.finishText}}</button></div>
                    </div>
                    <div class="col-md-4">
                        <img class="float-right" id="club-logo" :src="this.team_match.guest.image">
                    </div>
                </div>
                <div class="row p-4">
                    <table class="table text-center">
                        <tbody>
                        <tr>
                            <th scope="row">blocks</th>
                            <td>{{this.team_match.home_statistic.blocks}}</td>
                            <td>{{this.team_match.guest_statistic.blocks}}</td>
                            <th scope="row">blocks</th>
                        </tr>
                        <tr>
                            <th scope="row">rebounds</th>
                            <td>{{this.team_match.home_statistic.rebounds}}</td>
                            <td>{{this.team_match.guest_statistic.rebounds}}</td>
                            <th scope="row">rebounds</th>
                        </tr>
                        <tr>
                            <th scope="row">fouls</th>
                            <td>{{this.team_match.home_statistic.fouls}}</td>
                            <td>{{this.team_match.guest_statistic.fouls}}</td>
                            <th scope="row">fouls</th>
                        </tr>
                        <tr>
                            <th scope="row">assists</th>
                            <td>{{this.team_match.home_statistic.assists}}</td>
                            <td>{{this.team_match.guest_statistic.assists}}</td>
                            <th scope="row">assists</th>
                        </tr>
                        <tr>
                            <th scope="row">steals</th>
                            <td>{{this.team_match.home_statistic.steals}}</td>
                            <td>{{this.team_match.guest_statistic.steals}}</td>
                            <th scope="row">steals</th>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div id="guest" class="col-md-4 p-4">
                <div class="row">
                    <strong class="mr-4">Choose addition:</strong>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input guestoptradio" value=1 name="guestoptradio">1p
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input guestoptradio" value=2 name="guestoptradio" checked>2p
                        </label>
                    </div>
                    <div class="form-check-inline">
                        <label class="form-check-label">
                            <input type="radio" class="form-check-input guestoptradio" value=3 name="guestoptradio">3p
                        </label>
                    </div>
                </div>
                <div class="row">
                    <table class="table mt-4">
                        <thead>
                        <tr>
                            <th scope="col">ID</th>
                            <th scope="col">Name</th>
                            <th scope="col">Chose Option</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="currentPlayer in this.team_match.guest.current_players">
                            <th scope="row">{{currentPlayer.number}}</th>
                            <td>{{currentPlayer.player.name}}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button
                                        type="button"
                                        @click="score('guest', currentPlayer.player.id)"
                                        class="btn btn-sm btn-secondary"
                                        :disabled="isFinished"
                                    >
                                        P
                                    </button>
                                    <button
                                        type="button"
                                        @click="addition('blocks', 'guest', currentPlayer.player.id)"
                                        class="btn btn-sm btn-secondary"
                                        :disabled="isFinished"
                                    >
                                        B
                                    </button>
                                    <button
                                        type="button"
                                        @click="addition('rebounds', 'guest', currentPlayer.player.id)"
                                        class="btn btn-sm btn-secondary"
                                        :disabled="isFinished"
                                    >
                                        R
                                    </button>
                                    <button
                                        type="button"
                                        @click="addition('fouls', 'guest', currentPlayer.player.id)"
                                        class="btn btn-sm btn-secondary"
                                        :disabled="isFinished"
                                    >
                                        F
                                    </button>
                                    <button
                                        type="button"
                                        @click="addition('assists', 'guest', currentPlayer.player.id)"
                                        class="btn btn-sm btn-secondary"
                                        :disabled="isFinished"
                                    >
                                        A
                                    </button>
                                    <button
                                        type="button"
                                        @click="addition('steals', 'guest', currentPlayer.player.id)"
                                        class="btn btn-sm btn-secondary"
                                        :disabled="isFinished"
                                    >
                                        S
                                    </button>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "MatchManager",
        props: ['id'],
        data() {
            return {
                finishClass: "btn btn-danger",
                finishText: "Finish",

                isFinished: true,
                team_match: {
                    home: {
                        image: 'https://www.voya.ie/Interface/Icons/LoadingBasketContents.gif',
                        currentPlayers: {},
                    },

                    guest: {
                        image: 'https://www.voya.ie/Interface/Icons/LoadingBasketContents.gif',
                        currentPlayers: {},
                    },

                    home_statistic: {},

                    guest_statistic: {}
                },
            }
        },

        methods: {
            addition(statistic, team, playerId) {
                if (team === "home") {
                    switch (statistic) {
                        case "blocks" :
                            this.team_match.home_statistic.blocks = Number(this.team_match.home_statistic.blocks) + 1;
                            break;
                        case "steals" :
                            this.team_match.home_statistic.steals = Number(this.team_match.home_statistic.steals) + 1;
                            break;
                        case "assists" :
                            this.team_match.home_statistic.assists = Number(this.team_match.home_statistic.assists) + 1;
                            break;
                        case "rebounds" :
                            this.team_match.home_statistic.rebounds = Number(this.team_match.home_statistic.rebounds) + 1;
                            break;
                        case "fouls" :
                            this.team_match.home_statistic.fouls = Number(this.team_match.home_statistic.fouls) + 1;
                            break;
                    }
                    this.postAddition(this.team_match.home.id, playerId, 1, statistic);
                }
                else {
                    switch (statistic) {
                        case "blocks" :
                            this.team_match.guest_statistic.blocks = Number(this.team_match.guest_statistic.blocks) + 1;
                            break;
                        case "steals" :
                            this.team_match.guest_statistic.steals = Number(this.team_match.guest_statistic.steals) + 1;
                            break;
                        case "assists" :
                            this.team_match.guest_statistic.assists = Number(this.team_match.guest_statistic.assists) + 1;
                            break;
                        case "rebounds" :
                            this.team_match.guest_statistic.rebounds = Number(this.team_match.guest_statistic.rebounds) + 1;
                            break;
                        case "fouls" :
                            this.team_match.guest_statistic.fouls = Number(this.team_match.guest_statistic.fouls) + 1;
                            break;
                    }
                    this.postAddition(this.team_match.guest.id, playerId, 1, statistic);
                }
            },

            score(team, playerId){
                let value = 0;
                if(team === "home") {
                    document.getElementsByName('homeoptradio').forEach(element => {
                        if(element.checked) value = element.value;
                    });
                    this.team_match.home_statistic.points = Number(this.team_match.home_statistic.points) + Number(value);
                    this.postAddition(this.team_match.home.id, playerId, value, "points")
                }
                else {
                    document.getElementsByName('guestoptradio').forEach(element => {
                        if(element.checked) value = element.value;
                    });
                    this.team_match.guest_statistic.points = Number(this.team_match.guest_statistic.points) + Number(value);
                    this.postAddition(this.team_match.guest.id, playerId, value, "points")
                }
            },

            postAddition(teamId, playerId, value, key) {
                axios.post('/admin/matches/data/' + this.id, {
                    teamId: teamId,
                    playerId: playerId,
                    value: value,
                    key: key
                })
            },

            finishMatch() {
                this.isFinished = !this.isFinished;

                if(this.isFinished) {
                    this.finishClass = "btn btn-secondary";
                    this.finishText = "Unfinish";
                } else {
                    this.finishClass = "btn btn-danger";
                    this.finishText = "Finish";
                }

                axios.put('/matches', {
                    matchId: this.id,
                    finished: this.isFinished
                });
            }
        },

        mounted() {
            axios.get('/admin/matches/data/' + this.id)
                .then(response => {
                    this.team_match = response.data.team_match;
                    this.isFinished = response.data.isFinished;
                    this.finishText = this.isFinished ? "Unfinish" : "Finish";
                    this.finishClass = this.isFinished ? "btn btn-secondary" : "btn btn-danger";
                    console.log(response.data)
                });
            console.log(this.id);
        }
    }


</script>

<style scoped>
    #club-logo {
        max-width: 100%;
    }

    #result {
        margin-top: auto;
        font-size: 20px;
    }

    #match-view {
        border: solid 1px;
        padding: 10px;
    }

    #home, #guest {
        border: solid 1px;
    }
</style>