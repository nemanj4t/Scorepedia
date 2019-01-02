<template>

    <div class="table-wrapper">
        <table class="fl-table">
            <thead>
            <tr>
                <th>Player</th>
                <th @click="sort('points')" v-bind:class="select('points')">Points</th>
                <th @click="sort('assists')" v-bind:class="select('assists')">Assists</th>
                <th @click="sort('steals')" v-bind:class="select('steals')">Steals</th>
                <th @click="sort('rebounds')" v-bind:class="select('rebounds')">Rebounds</th>
                <th @click="sort('blocks')" v-bind:class="select('blocks')">Blocks</th>
                <th @click="sort('fouls')" v-bind:class="select('fouls')">Fouls</th>
            </tr>
            </thead>

            <tr v-for="(player, index) in stats.players">
                <td>{{index + 1}}. {{player.name}}</td>
                <td v-bind:class="select('points')">{{player.points}}</td>
                <td v-bind:class="select('assists')">{{player.assists}}</td>
                <td v-bind:class="select('steals')">{{player.steals}}</td>
                <td v-bind:class="select('rebounds')">{{player.rebounds}}</td>
                <td v-bind:class="select('blocks')">{{player.blocks}}</td>
                <td v-bind:class="select('fouls')">{{player.fouls}}</td>
            </tr>

        </table>
    </div>

</template>



<script>
    export default {
        name: "statistics",
        data() {
            return {
                stats: {
                    players: {},
                    sort: {},
                    dir: {}
                },

            }
        },

        methods: {
            sort(category) {
                if (category === this.stats.sort) {
                    this.stats.dir = this.stats.dir === 'asc' ? 'desc' : 'asc';
                    this.stats.players = this.stats.players.reverse();
                }
                else {
                    this.stats.sort = category;
                    this.stats.dir = this.stats.dir === 'asc' ? 'desc' : 'asc';
                    this.stats.players.sort((a, b) =>
                        Number(a[category]) - Number(b[category]));
                }
            },

            select(category) {
                if(category === this.stats.sort) {
                    return 'selectedColumn';
                }
            }
        },

        mounted() {
            axios.get('/statistics/full')
                .then(response => {
                   this.stats.players = response.data;
                   this.stats.sort = 'points';
                   this.stats.dir = 'desc';
                });
        }
    }

</script>

<style scoped>

    .selectedColumn
    {
        background-color: aqua;
    }

    .alnleft
    {
        text-align: left;
    }

    *{
        box-sizing: border-box;
        -webkit-box-sizing: border-box;
        -moz-box-sizing: border-box;
    }
    body{
        font-family: Helvetica;
        -webkit-font-smoothing: antialiased;
    }
    h2{
        text-align: center;
        font-size: 18px;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: white;
        padding: 30px 0;
    }

    /* Table Styles */

    .table-wrapper{
        margin: 10px 70px 70px;
        box-shadow: 0px 35px 50px rgba( 0, 0, 0, 0.2 );
    }

    .fl-table {
        border-radius: 5px;
        font-size: 12px;
        font-weight: normal;
        border: none;
        border-collapse: collapse;
        width: 100%;
        max-width: 100%;
        white-space: nowrap;
        background-color: white;
    }

    .fl-table td, .fl-table th {
        text-align: center;
        padding: 8px;
    }

    .fl-table td {
        border-right: 1px solid #f8f8f8;
        font-size: 12px;
    }

    .fl-table thead th {
        color: #ffffff;
        background: #4FC3A1;
    }


    .fl-table thead th:nth-child(odd) {
        color: #ffffff;
        background: #324960;
    }

    .fl-table tr:nth-child(even) {
        background: #F8F8F8;
    }

    #img-pic {
        max-width: 50px;
    }

    /* Responsive */

    @media (max-width: 767px) {
        .fl-table {
            display: block;
            width: 100%;
        }
        .table-wrapper:before{
            content: "Scroll horizontally >";
            display: block;
            text-align: right;
            font-size: 11px;
            color: white;
            padding: 0 0 10px;
        }
        .fl-table thead, .fl-table tbody, .fl-table thead th {
            display: block;
        }
        .fl-table thead th:last-child{
            border-bottom: none;
        }
        .fl-table thead {
            float: left;
        }
        .fl-table tbody {
            width: auto;
            position: relative;
            overflow-x: auto;
        }
        .fl-table td, .fl-table th {
            padding: 20px .625em .625em .625em;
            height: 60px;
            vertical-align: middle;
            box-sizing: border-box;
            overflow-x: hidden;
            overflow-y: auto;
            width: 120px;
            font-size: 13px;
            text-overflow: ellipsis;
        }
        .fl-table thead th {
            text-align: left;
            border-bottom: 1px solid #f7f7f9;
        }
        .fl-table tbody tr {
            display: table-cell;
        }
        .fl-table tbody tr:nth-child(odd) {
            background: none;
        }
        .fl-table tr:nth-child(even) {
            background: transparent;
        }
        .fl-table tr td:nth-child(odd) {
            background: #F8F8F8;
            border-right: 1px solid #E6E4E4;
        }
        .fl-table tr td:nth-child(even) {
            border-right: 1px solid #E6E4E4;
        }
        .fl-table tbody td {
            display: block;
            text-align: center;
        }
    }
</style>