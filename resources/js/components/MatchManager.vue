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
                                        @click="score('home')"
                                        class="btn btn-sm btn-secondary"
                                    >
                                        P
                                    </button>
                                    <button
                                        type="button"
                                        @click="addition('block', 'home')"
                                        class="btn btn-sm btn-secondary"
                                    >
                                        B
                                    </button>
                                    <button
                                        type="button"
                                        @click="addition('rebound', 'home')"
                                        class="btn btn-sm btn-secondary"
                                    >
                                        R
                                    </button>
                                    <button
                                        type="button"
                                        @click="addition('foul', 'home')"
                                        class="btn btn-sm btn-secondary"
                                    >
                                        F
                                    </button>
                                    <button
                                        type="button"
                                        @click="addition('assist', 'home')"
                                        class="btn btn-sm btn-secondary"
                                    >
                                        A
                                    </button>
                                    <button
                                        type="button"
                                        @click="addition('steal', 'home')"
                                        class="btn btn-sm btn-secondary"
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
                    <div id="result" class="col-md-4 text-center">{{this.home.points}} - {{this.guest.points}}</div>
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
                                        @click="score('guest')"
                                        class="btn btn-sm btn-secondary"
                                    >
                                        P
                                    </button>
                                    <button
                                        type="button"
                                        @click="addition('block', 'guest')"
                                        class="btn btn-sm btn-secondary"
                                    >
                                        B
                                    </button>
                                    <button
                                        type="button"
                                        @click="addition('rebound', 'guest')"
                                        class="btn btn-sm btn-secondary"
                                    >
                                        R
                                    </button>
                                    <button
                                        type="button"
                                        @click="addition('foul', 'guest')"
                                        class="btn btn-sm btn-secondary"
                                    >
                                        F
                                    </button>
                                    <button
                                        type="button"
                                        @click="addition('assist', 'guest')"
                                        class="btn btn-sm btn-secondary"
                                    >
                                        A
                                    </button>
                                    <button
                                        type="button"
                                        @click="addition('steal', 'guest')"
                                        class="btn btn-sm btn-secondary"
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
                match: {
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
            test() {
                axios.post('/admin/matches/data/' + this.id, {
                    userId: this.something,
                })
                    .then(response => {
                        this.something = response.data;
                    })
            },

            addition(statistic, team) {
                if (team == "home")
                    switch (statistic) {
                        case "block" : {
                            this.home.blocks = Number(this.home.blocks) + 1;
                        }
                            break;
                        case "steal" :
                            this.home.steals = Number(this.home.steals) + 1;
                            break;
                        case "assist" :
                            this.home.assists = Number(this.home.assists) + 1;
                            break;
                        case "rebound" :
                            this.home.rebounds = Number(this.home.rebounds) + 1;
                            break;
                        case "foul" :
                            this.home.fouls = Number(this.home.fouls) + 1;
                            break;
                    }
                else {
                    switch (statistic) {
                        case "block" :
                            this.guest.blocks = Number(this.guest.blocks) + 1;
                            break;
                        case "steal" :
                            this.guest.steals = Number(this.guest.steals) + 1;
                            break;
                        case "assist" :
                            this.guest.assists = Number(this.guest.assists) + 1;
                            break;
                        case "rebound" :
                            this.guest.rebounds = Number(this.guest.rebounds) + 1;
                            break;
                        case "foul" :
                            this.guest.fouls = Number(this.guest.fouls) + 1;
                            break;
                    }
                }
            },

            score(team){
                var value = 0;
                if(team == "home") {
                    document.getElementsByName('homeoptradio').forEach(element => {
                        if(element.checked) value = element.value;
                    });
                    this.home.points = Number(this.home.points) + Number(value);
                }
                else {
                    console.log('asdasd');
                    document.getElementsByName('guestoptradio').forEach(element => {
                        if(element.checked) value = element.value;
                    });
                    this.guest.points = Number(this.guest.points) + Number(value);
                    console.log(this.guest.points);
                }
            },
        },

        mounted() {
            axios.get('/admin/matches/data/' + this.id)
                .then(response => {
                    this.match = response.data.match;
                    this.home = response.data.home;
                    this.guest = response.data.guest;
                    this.homePlayers = response.data.homePlayers;
                    this.guestPlayers = response.data.guestPlayers;
                    console.log(response.data.home)
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