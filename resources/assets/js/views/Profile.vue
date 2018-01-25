<template>
    <div v-if="user != null" class="px-4 py-8 max-w-2xl mx-auto md:flex">
        <div class="flex justify-center md:block md:pr-8 md:w-1/4 mb-4">
            <img class="h-32 w-32 md:h-auto md:w-full shadow-md" :src="user.avatar">
        </div>
        <div class="flex-1">
            <div>
                <div>{{ user.name }}</div>
                <div>{{ user.email }}</div>
                <div>Member Since: {{ user.joined }}</div>
            </div>

            <div>
                <div class="font-bold">Episodes Completed Per Week</div>
                <canvas ref="episodeChart" class="py-4"></canvas>
            </div>

            <div>
                <div class="font-bold">Subscriptions</div>
                <div v-for="podcast in user.subscriptions" :key="podcast.id">
                    <div>
                        <router-link :to="{name:'podcasts.show', params:{id:podcast.id}}">{{ podcast.title }}</router-link>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Chart from 'Chart.js';

    export default {
        data() {
            return {
                user: null,
                chart: null,
            };
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
                                borderColor: '#f6993f',
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
