    <template>
    <div v-if="user != null" class="px-4 py-8 max-w-2xl mx-auto md:flex">
        <div class="flex justify-center md:block md:pr-8 md:w-1/4 mb-4">
            <img class="h-32 w-32 md:h-auto md:w-full shadow-md" :src="user.avatar">
        </div>
        <div class="flex-1">
            <div class="bg-white p-4 shadow mb-4">
                <div class="text-3xl font-bold">{{ user.name }}</div>
                <div class="text-sm mb-4">{{ user.email }}</div>
                <div class="text-sm">Member since: {{ user.joined }}</div>
            </div>

            <div class="bg-white p-4 shadow mb-4">
                <div class="font-bold text-xl">Episodes Completed Per Week</div>
                <canvas ref="episodeChart" class="py-4"></canvas>
            </div>

            <div class="bg-white p-4 shadow">
                <div class="font-bold text-xl mb-2">Subscriptions</div>
                <ul class="list-reset">
                    <li v-for="podcast in user.subscriptions" :key="podcast.id" class="mb-1">
                        <router-link class="no-underline text-orange block hover:text-orange-dark hover:underline" :to="{name:'podcasts.show', params:{id:podcast.id}}">
                            <div>{{ podcast.title }}</div>
                        </router-link>
                    </li>
                </ul>
            </div>
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
