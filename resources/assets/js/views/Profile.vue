<template>
    <div v-if="user != null" class="px-4 py-8 max-w-md mx-auto">
        <div class="flex bg-white shadow rounded-lg p-2 mb-4">
            <div class="pr-2">
                <img class="h-32 w-32 shadow rounded-lg" :src="user.avatar" :alt="user.name">
            </div>
            <div class="flex-1 p-2 flex flex-col justify-between">
                <div>
                    <div class="text-xl">{{ user.name }}</div>
                    <div class="text-grey-darker">{{ user.email }}</div>
                </div>
                <div class="text-grey-darker">Member since: {{ user.joined }}</div>
            </div>
        </div>
        
        <div class="shadow rounded-lg p-2 bg-white mb-4">
            <div class="p-2">Episodes Completed Per Week</div>
            <canvas ref="episodeChart" class=""></canvas>
        </div>

        <div class="flex justify-end">
            <a :href="routeLogout" class="p-2 bg-white hover:bg-purple hover:text-white no-underline rounded-lg shadow">Logout</a>
        </div>
    </div>
</template>

<script>
    var Chart = require('chart.js');

    export default {
        data() {
            return {
                user: null,
                chart: null,
            };
        },

        computed: {
            routeLogout: function() {
                return route('logout');
            },
        },

        mounted() {
            axios.get(route('users.index')).then(res => {
                this.user = res.data.data;
                this.loadChart();
            });
        },

        methods: {
            loadChart() {
                this.$nextTick(function() {
                    var ctx = this.$refs.episodeChart.getContext('2d');
                    this.chart = new Chart(ctx, {
                        type: 'line',
                        data: {
                            labels: _.map(this.user.last_episodes, 'week'),
                            datasets: [{
                                data: _.map(this.user.last_episodes, 'count'),
                                fill: false,
                                borderColor: '#9561e2',
                                lineTension: 0.1,
                            }]
                        },
                        options: {
                            legend: {
                                display: false,
                            },
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero:true
                                    }
                                }]
                            },
                            tooltips: {
                                enabled: false,
                            }
                        }
                    });
                });
                
            }
        }
    }
</script>
