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
                        <tr v-for="player in this.homePlayers">
                            <th scope="row">{{player.id}}</th>
                            <td>{{player.name}}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button
                                        type="button"
                                        @click="score('home', player.id)"
                                        class="btn btn-sm btn-secondary"
                                        :disabled="match.isFinished ? true: false"
                                    >
                                        P
                                    </button>
                                    <button
                                        type="button"
                                        @click="addition('blocks', 'home', player.id)"
                                        class="btn btn-sm btn-secondary"
                                        :disabled="match.isFinished ? true: false"
                                    >
                                        B
                                    </button>
                                    <button
                                        type="button"
                                        @click="addition('rebounds', 'home', player.id)"
                                        class="btn btn-sm btn-secondary"
                                        :disabled="match.isFinished ? true: false"
                                    >
                                        R
                                    </button>
                                    <button
                                        type="button"
                                        @click="addition('fouls', 'home', player.id)"
                                        class="btn btn-sm btn-secondary"
                                        :disabled="match.isFinished ? true: false"
                                    >
                                        F
                                    </button>
                                    <button
                                        type="button"
                                        @click="addition('assists', 'home', player.id)"
                                        class="btn btn-sm btn-secondary"
                                        :disabled="match.isFinished ? true: false"
                                    >
                                        A
                                    </button>
                                    <button
                                        type="button"
                                        @click="addition('steals', 'home', player.id)"
                                        class="btn btn-sm btn-secondary"
                                        :disabled="match.isFinished ? true: false"
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
                        <img class="float-left" id="club-logo" :src="this.match.home.image">
                    </div>
                    <div id="result" class="col-md-4 text-center">
                        <div class="col-md-12">{{this.home.points}} - {{this.guest.points}}</div>
                        <div class="col-md-12"><button id="finish" @click="finishMatch" :class="this.finishClass">{{this.finishText}}</button></div>
                    </div>
                    <div class="col-md-4">
                        <img class="float-right" id="club-logo" :src="this.match.guest.image">
                    </div>
                </div>
                <div class="row p-4">
                    <table class="table text-center">
                        <tbody>
                        <tr>
                            <th scope="row">blocks</th>
                            <td>{{this.home.blocks}}</td>
                            <td>{{this.guest.blocks}}</td>
                            <th scope="row">blocks</th>
                        </tr>
                        <tr>
                            <th scope="row">rebounds</th>
                            <td>{{this.home.rebounds}}</td>
                            <td>{{this.guest.rebounds}}</td>
                            <th scope="row">rebounds</th>
                        </tr>
                        <tr>
                            <th scope="row">fouls</th>
                            <td>{{this.home.fouls}}</td>
                            <td>{{this.guest.fouls}}</td>
                            <th scope="row">fouls</th>
                        </tr>
                        <tr>
                            <th scope="row">assists</th>
                            <td>{{this.home.assists}}</td>
                            <td>{{this.guest.assists}}</td>
                            <th scope="row">assists</th>
                        </tr>
                        <tr>
                            <th scope="row">steals</th>
                            <td>{{this.home.steals}}</td>
                            <td>{{this.guest.steals}}</td>
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
                        <tr v-for="player in this.guestPlayers">
                            <th scope="row">{{player.id}}</th>
                            <td>{{player.name}}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic example">
                                    <button
                                        type="button"
                                        @click="score('guest', player.id)"
                                        class="btn btn-sm btn-secondary"
                                        :disabled="match.isFinished ? true: false"
                                    >
                                        P
                                    </button>
                                    <button
                                        type="button"
                                        @click="addition('blocks', 'guest', player.id)"
                                        class="btn btn-sm btn-secondary"
                                        :disabled="match.isFinished ? true: false"
                                    >
                                        B
                                    </button>
                                    <button
                                        type="button"
                                        @click="addition('rebounds', 'guest', player.id)"
                                        class="btn btn-sm btn-secondary"
                                        :disabled="match.isFinished ? true: false"
                                    >
                                        R
                                    </button>
                                    <button
                                        type="button"
                                        @click="addition('fouls', 'guest', player.id)"
                                        class="btn btn-sm btn-secondary"
                                        :disabled="match.isFinished ? true: false"
                                    >
                                        F
                                    </button>
                                    <button
                                        type="button"
                                        @click="addition('assists', 'guest', player.id)"
                                        class="btn btn-sm btn-secondary"
                                        :disabled="match.isFinished ? true: false"
                                    >
                                        A
                                    </button>
                                    <button
                                        type="button"
                                        @click="addition('steals', 'guest', player.id)"
                                        class="btn btn-sm btn-secondary"
                                        :disabled="match.isFinished ? true: false"
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
                match: {
                    isFinished: true,
                    home: {
                        image: 'https://www.voya.ie/Interface/Icons/LoadingBasketContents.gif'
                    },
                    guest: {
                        image: 'https://www.voya.ie/Interface/Icons/LoadingBasketContents.gif'
                    }
                },
                home: {},
                guest: {},
                homePlayers: {},
                guestPlayers: {}
            }
        },

        methods: {
            addition(statistic, team, playerId) {
                if (team == "home") {
                    switch (statistic) {
                        case "blocks" :
                            this.home.blocks = Number(this.home.blocks) + 1;
                            break;
                        case "steals" :
                            this.home.steals = Number(this.home.steals) + 1;
                            break;
                        case "assists" :
                            this.home.assists = Number(this.home.assists) + 1;
                            break;
                        case "rebounds" :
                            this.home.rebounds = Number(this.home.rebounds) + 1;
                            break;
                        case "fouls" :
                            this.home.fouls = Number(this.home.fouls) + 1;
                            break;
                    }
                    this.postAddition(this.match.home.id, playerId, 1, statistic);
                }
                else {
                    switch (statistic) {
                        case "blocks" :
                            this.guest.blocks = Number(this.guest.blocks) + 1;
                            break;
                        case "steals" :
                            this.guest.steals = Number(this.guest.steals) + 1;
                            break;
                        case "assists" :
                            this.guest.assists = Number(this.guest.assists) + 1;
                            break;
                        case "rebounds" :
                            this.guest.rebounds = Number(this.guest.rebounds) + 1;
                            break;
                        case "fouls" :
                            this.guest.fouls = Number(this.guest.fouls) + 1;
                            break;
                    }
                    this.postAddition(this.match.guest.id, playerId, 1, statistic);
                }
            },

            score(team, playerId){
                var value = 0;
                if(team == "home") {
                    document.getElementsByName('homeoptradio').forEach(element => {
                        if(element.checked) value = element.value;
                    });
                    this.home.points = Number(this.home.points) + Number(value);
                    this.postAddition(this.match.home.id, playerId, value, "points")
                }
                else {
                    document.getElementsByName('guestoptradio').forEach(element => {
                        if(element.checked) value = element.value;
                    });
                    this.guest.points = Number(this.guest.points) + Number(value);
                    this.postAddition(this.match.guest.id, playerId, value, "points")
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
                this.match.isFinished = !this.match.isFinished;

                if(this.match.isFinished) {
                    this.finishClass = "btn btn-secondary";
                    this.finishText = "Unfinish";
                } else {
                    this.finishClass = "btn btn-danger";
                    this.finishText = "Finish";
                }

                axios.put('/matches', {
                    matchId: this.match.id,
                    finished: this.match.isFinished
                });
            }
        },

        mounted() {
            axios.get('/admin/matches/data/' + this.id)
                .then(response => {
                    this.match = response.data.match;
                    this.home = response.data.home;
                    this.guest = response.data.guest;
                    this.homePlayers = response.data.homePlayers;
                    this.guestPlayers = response.data.guestPlayers;
                    this.finishText = this.match.isFinished ? "Unfinish" : "Finish";
                    this.finishClass = this.match.isFinished ? "btn btn-secondary" : "btn btn-danger";
                    console.log(response.data)
                });
        }
    }


</script>

<style scoped>
    #club-logo {
        max-width: 100%;
    }

    #result {
        margin-top: auto;
        font-size: 24px;
    }

    #match-view {
        border: solid 1px;
        padding: 10px;
    }

    #home, #guest {
        border: solid 1px;
    }
</style>