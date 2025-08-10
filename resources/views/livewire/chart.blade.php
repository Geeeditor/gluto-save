<div class="bg-[#1c1b22] shadow-sm mb-3 p-4 md:p-6 rounded-lg w-full">
    <div class="flex justify-between pb-3 border-gray-200 dark:border-gray-700 border-b">
        <dl>
            <dt class="pb-1 font-normal text-gray-500 dark:text-gray-400 text-base">Transaction Volume</dt>
            <dd class="font-bold text-gray-900 dark:text-white text-3xl leading-none">NGN {{ number_format($grandTotal, 2) }}</dd>
        </dl>
        <div>
            <span class="inline-flex items-center bg-green-100 dark:bg-green-900 px-2.5 py-1 rounded-md font-medium text-green-800 dark:text-green-300 text-xs">
                CHART
            </span>
        </div>
    </div>

    <div class="grid grid-cols-2 py-3">
        <dl>
            <dt class="pb-1 font-normal text-gray-500 dark:text-gray-400 text-base">Money In</dt>
            <dd class="font-bold text-green-500 dark:text-green-400 text-xl leading-none">NGN {{ number_format($totalPayments, 2) }}</dd>
        </dl>
        <dl>
            <dt class="pb-1 font-normal text-gray-500 dark:text-gray-400 text-base">Money Out</dt>
            <dd class="font-bold text-red-600 dark:text-red-500 text-xl leading-none">-NGN {{ number_format($totalWithdrawals, 2) }}</dd>
        </dl>
    </div>

    <div id="bar-chart" ></div>

    <div class="justify-between items-center grid grid-cols-1 border-gray-700 border-t" >
        <div class="flex justify-between items-center pt-5">
            <div class="relative" x-data="{ dropdown: false, selected: 'All Time' }" wire:ignore>
                <button @click="dropdown = !dropdown" id="dropdownDefaultButton"  data-dropdown-toggle="lastDaysdropdown"
                    class="inline-flex items-center font-medium text-gray-500 hover:text-gray-900 dark:hover:text-white dark:text-gray-400 text-sm text-center">
                    <span x-text="selected"></span>
                    <svg class="m-2.5 ms-1.5 w-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 4 4 4-4" />
                    </svg>
                </button>
                <div x-show="dropdown" @click.outside="dropdown = false" x-transition id="lastDaysdropdown"
                    class="top-8 z-10 absolute bg-gray-700 shadow-sm rounded-lg divide-y divide-gray-100 w-44 text-white">
                    <ul class="py-2" aria-labelledby="dropdownDefaultButton">
                        <li @click="selected = 'All Time'; dropdown = false" >
                            <a href="#" wire:click.prevent="updateTimeframe('All Time')" class="block hover:bg-gray-100 dark:hover:bg-gray-600 px-4 py-2 dark:hover:text-white">All Time</a>
                        </li>
                        <li @click="selected = '1 Year'; dropdown = false">
                            <a href="#" wire:click.prevent="updateTimeframe('1 Year')" class="block hover:bg-gray-100 dark:hover:bg-gray-600 px-4 py-2 dark:hover:text-white">1 Year</a>
                        </li>
                        <li @click="selected = '6 Months'; dropdown = false">
                            <a href="#" wire:click.prevent="updateTimeframe('6 months')" class="block hover:bg-gray-100 dark:hover:bg-gray-600 px-4 py-2 dark:hover:text-white">6 Months</a>
                        </li>
                        <li @click="selected = 'Last 3 Months'; dropdown = false">
                            <a href="#" wire:click.prevent="updateTimeframe('3 months')" class="block hover:bg-gray-100 dark:hover:bg-gray-600 px-4 py-2 dark:hover:text-white">Last 3 Months</a>
                        </li>
                        <li @click="selected = 'Last 30 Days'; dropdown = false">
                            <a href="#" wire:click.prevent="updateTimeframe('1 month')" class="block hover:bg-gray-100 dark:hover:bg-gray-600 px-4 py-2 dark:hover:text-white">Last 30 Days</a>
                        </li>
                        <li @click="selected = 'Today'; dropdown = false">
                            <a href="#" wire:click.prevent="updateTimeframe('Today')" class="block hover:bg-gray-100 dark:hover:bg-gray-600 px-4 py-2 dark:hover:text-white">Today</a>
                        </li>
                    </ul>
                </div>
            </div>

            <a href="{{ route('platform.payments') }}"
                class="inline-flex items-center hover:bg-gray-400 px-3 py-2 dark:border-gray-700 rounded-lg text-white hover:text-slate-300 text-sm uppercase">
                Manage Payments
                <svg class="ms-1.5 w-2.5 h-2.5 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 6 10">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 9 4-4-4-4" />
                </svg>
            </a>
        </div>
    </div>




    <script src="https://cdn.jsdelivr.net/npm/apexcharts@3.46.0/dist/apexcharts.min.js"></script>


    <script id="paymentData" type="application/json" wire:key="{{ json_encode($paymentValues) }}">
        @json($paymentValues)
    </script>



    <script>
        function renderChart() {
            const paymentDataElement = document.getElementById('paymentData');
            const paymentData = JSON.parse(paymentDataElement.textContent);

            const seriesKeyMap = {
                "Registration": "registration",
                "Subscription": "subscription",
                "Contribution": "contribution",
                "Debt Payment": "debtPyt",
                "Wallet Funding": "walletFunding",
                "Withdrawals": "withdrawals"
            };

            const options = {
                series: [{
                    name: "Registration",
                    color: "#31C48D",
                    data: [],
                }, {
                    name: "Subscription",
                    color: "#4F86F7",
                    data: [],
                }, {
                    name: "Contribution",
                    color: "#FFC107",
                    data: [],
                }, {
                    name: "Debt Payment",
                    color: "#FF5722",
                    data: [],
                }, {
                    name: "Wallet Funding",
                    color: "#8E24AA",
                    data: [],
                }, {
                    name: "Withdrawals",
                    color: "#F05252",
                    data: [],
                }],
                chart: {
                    sparkline: { enabled: false },
                    type: "bar",
                    width: "100%",
                    height: 400,
                    toolbar: { show: true },
                },
                fill: { opacity: 1 },
                plotOptions: {
                    bar: {
                        horizontal: false,
                        columnWidth: "100%",
                        borderRadiusApplication: "end",
                        borderRadius: 6,
                        dataLabels: { position: "top" },
                    },
                },
                legend: { show: true, position: "bottom" },
                dataLabels: { enabled: false },
                tooltip: {
                    shared: true,
                    intersect: false,
                    formatter: function(value) { return "NGN" + value; }
                },
                xaxis: {
                    labels: {
                        show: false,
                        style: {
                            fontFamily: "Inter, sans-serif",
                            cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400'
                        },
                        formatter: function(value) { return "NGN" + value; }
                    },
                    categories: [],
                    axisTicks: { show: false },
                    axisBorder: { show: false },
                },
                yaxis: {
                    labels: { show: false, style: { fontFamily: "Inter, sans-serif", cssClass: 'text-xs font-normal fill-gray-500 dark:fill-gray-400' }}
                },
                grid: {
                    show: true,
                    strokeDashArray: 4,
                    padding: { left: 2, right: 2, top: -20 },
                },
            };

            options.series.forEach(series => {
                const dataKey = seriesKeyMap[series.name];
                series.data = paymentData[dataKey] || [];
            });

            const chartElement = document.getElementById("bar-chart");
            if (chartElement && typeof ApexCharts !== 'undefined') {
                const chart = new ApexCharts(chartElement, options);
                chart.render();
            }
        }

        // Initial render when the page loads
    renderChart();

// Listen for Livewire events
document.addEventListener('livewire:load', function () {
    Livewire.on('chartUpdated', function () {
        renderChart();
    });
});
    </script>
</div>
