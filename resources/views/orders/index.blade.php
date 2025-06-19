<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Sales Reports</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root { --color-dark-navy: #000435; }
    </style>
</head>
<body class="bg-[var(--color-dark-navy)] text-white font-sans min-h-screen flex flex-col">

    <a href="{{ route('admin.dashboard') }}" 
       class="absolute top-6 left-6 bg-white text-[var(--color-dark-navy)] px-4 py-2 rounded-full font-semibold hover:bg-gray-200 transition z-50 shadow-lg">
       ← Back
    </a>
  
    <header class="bg-black bg-opacity-80 p-6 shadow-md">
        <h1 class="text-3xl font-bold text-center tracking-wide">Sales Reports</h1>
    </header>

    <main class="flex-grow container mx-auto max-w-7xl px-6 py-10">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
            <!-- Chart Section -->
            <section class="md:col-span-2 bg-black bg-opacity-80 rounded-xl p-6 shadow-lg">
                <h2 class="text-2xl font-bold mb-4 text-center">Sales Report</h2>
                <canvas id="salesChart"></canvas>
            </section>

            <!-- Total Revenue Section -->
<section class="bg-black bg-opacity-80 rounded-xl p-6 shadow-lg">
    <h2 class="text-2xl font-bold mb-4 text-center">Total Revenue</h2>
    <div class="text-center text-lg">
        <p class="font-semibold">Total Revenue This Month:</p>
        <p class="text-3xl">Rp{{ number_format($totalRevenue, 2) }}</p>
    </div>

    <h3 class="text-xl font-semibold mt-6 text-center">Top 3 Favorite Menu Items</h3>
    <ul class="mt-2 text-center">
        @foreach ($topMenuItems as $item)
            <li class="border-b border-gray-700 py-1">
                {{ $item->menu_name }} – {{ $item->total }} orders
            </li>
        @endforeach
    </ul>

</section>
            <!-- Report Table Section -->
            <section class="col-span-3 bg-black bg-opacity-80 rounded-xl p-6 shadow-lg mt-10">
                <h2 class="text-2xl font-bold mb-6 text-center">Detailed Sales Report</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Monthly Report -->
                    <div>
                        <h3 class="text-xl font-semibold mb-2">Per Month</h3>
                        <table class="w-full text-left text-sm">
                            <thead>
                                <tr class="border-b border-gray-600">
                                    <th class="py-1">Month</th>
                                    <th class="py-1 text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($monthlyReport as $month)
                                    <tr class="border-b border-gray-700">
                                        <td class="py-1">{{ $month->month }}</td>
                                        <td class="py-1 text-right">Rp{{ number_format($month->total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Yearly Report -->
                    <div>
                        <h3 class="text-xl font-semibold mb-2">Per Year</h3>
                        <table class="w-full text-left text-sm">
                            <thead>
                                <tr class="border-b border-gray-600">
                                    <th class="py-1">Year</th>
                                    <th class="py-1 text-right">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($yearlyReport as $year)
                                    <tr class="border-b border-gray-700">
                                        <td class="py-1">{{ $year->year }}</td>
                                        <td class="py-1 text-right">Rp{{ number_format($year->total, 2) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

        </div>
    </main>

    <script>
        const monthlyData = @json($monthlyReport);

        const labels = monthlyData.map(item => item.month);
        const data = monthlyData.map(item => parseFloat(item.total));

        const salesData = {
            labels: labels,
            datasets: [{
                label: 'Monthly Sales',
                data: data,
                backgroundColor: 'rgba(75, 192, 192, 0.6)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        };

        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: salesData,
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function(value) {
                                return 'Rp' + value.toLocaleString('id-ID');
                            }
                        }
                    }
                }
            }
        });
    </script>



</body>
</html>
