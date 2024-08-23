<div>
    @if(isset(Auth::user()->verifications) && Auth::user()->verifications->status == 1)
        <div class="flex flex-col lg:flex-row">
            <!-- Левая панель управления -->
            <div class="w-full lg:w-2/12 bg-gray-800 text-white p-4">
                <h2 class="text-xl font-bold mb-4">Управление</h2>

                <!-- Поле для выбора объема сделки -->
                <div class="mb-4">
                    <label for="volume" class="block text-sm font-medium">Объем сделки</label>
                    <input type="number" id="volume" wire:model="volume"
                           class="w-full px-3 py-2 bg-gray-900 text-white border border-gray-700 rounded"
                           min="0.01" max="1.00" step="0.01">
                    <p class="text-sm text-gray-400 mt-2">Баланс: ${{ $availableBalance }}</p>
                    <p id="trade-amount" class="text-sm text-gray-400">Сумма сделки: ${{ $tradeAmount }}</p>
                </div>

                <!-- Кнопки открытия сделки -->
                <div class="flex flex-col lg:flex-row space-y-4 lg:space-y-0 lg:space-x-4 mb-4">
                    <button wire:click="openOrder('buy')" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Купить</button>
                    <button wire:click="openOrder('sell')" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Продать</button>
                </div>
            </div>

            <!-- Правая часть с графиком и ордерами -->
            <div class="w-full lg:w-10/12 bg-gray-700 p-4">
                <!-- График -->
                <div class="bg-gray-900 text-white p-4 rounded mb-4" wire:ignore>
                    <h3 id="current-price" class="text-lg font-bold">Текущая цена: {{ $currentPrice }}</h3>
                    <div id="chart" class="mb-4"></div>
                </div>

                <!-- Открытые ордера -->
                <div class="bg-white p-4 rounded shadow overflow-x-auto">
                    <h3 class="text-lg font-bold mb-2">Открытые ордера</h3>
                    <table class="table-auto w-full min-w-[600px]">
                        <thead class="bg-gray-800 text-white">
                        <tr class="text-center">
                            <th class="px-4 py-2">Актив</th>
                            <th class="px-4 py-2">Тип</th>
                            <th class="px-4 py-2">Объем</th>
                            <th class="px-4 py-2">Цена входа</th>
                            <th class="px-4 py-2">Продолжительность</th>
                            <th class="px-4 py-2">Прибыль</th>
                            <th class="px-4 py-2">Действие</th>
                        </tr>
                        </thead>
                        <tbody id="orders-table">
                        @foreach ($orders as $order)
                            <tr class="border-t text-center" id="order-{{ $order->id }}">
                                <td class="px-4 py-2">{{ $order->symbol }}</td>
                                @php
                                    $classType = $order->type === 'buy' ? 'text-green-700' : 'text-red-600';
                                @endphp
                                <td class="px-4 py-2 {{ $order->type === 'buy' ? 'text-green-700' : 'text-red-600' }}">{{ ucfirst($order->type) }}</td>
                                <td class="px-4 py-2">{{ $order->volume }}</td>
                                <td class="px-4 py-2">{{ $order->entry_price }}</td>
                                <td class="px-4 py-2">{{ $order->duration }} минут</td>
                                <td class="px-4 py-2" id="profit-{{ $order->id }}">
                                <span style="color: {{ $order->profit >= 0 ? 'green' : 'red' }};">
                                    ${{ number_format($order->profit, 2) }}
                                </span>
                                </td>
                                <td class="px-4 py-2">
                                    <button wire:click="closeOrder({{ $order->id }}, {{$currentPrice}})"
                                            class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                                        Закрыть ордер
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="bg-white p-4 rounded shadow overflow-x-auto mt-8">
                    <h3 class="text-lg font-bold mb-2">История сделок</h3>
                    <table class="table-auto w-full min-w-[600px]">
                        <thead class="bg-gray-800 text-white">
                        <tr class="text-center">
                            <th class="px-4 py-2">Актив</th>
                            <th class="px-4 py-2">Тип</th>
                            <th class="px-4 py-2">Объем</th>
                            <th class="px-4 py-2">Цена входа</th>
                            <th class="px-4 py-2">Цена закрытия</th>
                            <th class="px-4 py-2">Прибыль</th>
                            <th class="px-4 py-2">Дата</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($orderHistory as $history)
                            <tr class="border-t text-center">
                                <td class="px-4 py-2">{{ $history->symbol }}</td>
                                <td class="px-4 py-2 {{ $history->type === 'buy' ? 'text-green-700' : 'text-red-600' }}">{{ ucfirst($history->type) }}</td>
                                <td class="px-4 py-2">{{ $history->volume }}</td>
                                <td class="px-4 py-2">{{ $history->entry_price }}</td>
                                <td class="px-4 py-2">{{ $history->closing_price }}</td>
                                <td class="px-4 py-2">
                    <span style="color: {{ $history->profit >= 0 ? 'green' : 'red' }};">
                        ${{ number_format($history->profit, 2) }}
                    </span>
                                </td>
                                <td class="px-4 py-2">{{ $history->created_at->format('d.m.Y H:i') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $orderHistory->links() }}
                    </div>
                </div>
            </div>
        </div>
        <script src="https://unpkg.com/lightweight-charts/dist/lightweight-charts.standalone.production.js"></script>

        <script>
            let initialData = @json($initialCandleData);
            console.log(initialData);

            const domElement = document.querySelector("#chart");

            function createChart() {
                const containerWidth = domElement.clientWidth;
                const containerHeight = domElement.clientHeight || 600; // Устанавливаем высоту по умолчанию, если контейнер пуст

                const chartProperties = {
                    width: containerWidth,
                    height: containerHeight,
                    timeScale: {
                        timeVisible: true,
                        secondVisible: false
                    }
                };

                return LightweightCharts.createChart(domElement, chartProperties);
            }

            let chart = createChart();
            let candleSeries = chart.addCandlestickSeries();
            candleSeries.setData(initialData);

            // Функция для добавления новых свечей
            function addNewCandle() {
                const lastCandle = initialData[initialData.length - 1];
                const lastClosePrice = lastCandle.close;

                const lastOrderType = @this.get('lastOrderType');
                const successRate = {{ $successRate / 100 }};

                const randomHigh = lastClosePrice + (Math.random() * 2000 / 100000);
                const randomLow = lastClosePrice - (Math.random() * 2000 / 100000);

                const isFavorable = Math.random() < successRate;
                let newCandle;

                const nextTime = lastCandle.time + 60; // Добавляем 1 минуту

                if (lastOrderType === 'buy') {
                    newCandle = {
                        time: nextTime,
                        open: lastClosePrice,
                        high: randomHigh,
                        low: randomLow,
                        close: isFavorable ? randomHigh : randomLow
                    };
                } else if (lastOrderType === 'sell') {
                    newCandle = {
                        time: nextTime,
                        open: lastClosePrice,
                        high: randomHigh,
                        low: randomLow,
                        close: isFavorable ? randomLow : randomHigh
                    };
                } else {
                    const isBullish = Math.random() < 0.5;
                    newCandle = {
                        time: nextTime,
                        open: lastClosePrice,
                        high: randomHigh,
                        low: randomLow,
                        close: isBullish ? randomHigh : randomLow
                    };
                }

                initialData.push(newCandle);
                candleSeries.setData(initialData);

                document.getElementById('current-price').textContent = `Текущая цена: ${newCandle.close.toFixed(6)}`;

                Livewire.dispatch('current-price', { price: newCandle.close });
                Livewire.dispatch('load-orders');
            }

            // Обновляем размер графика при изменении размера окна
            window.addEventListener('resize', () => {
                chart.applyOptions({
                    width: domElement.clientWidth,
                    height: domElement.clientHeight || 600
                });
            });

            setInterval(() => {
                addNewCandle();
            }, 2000);
        </script>

    @else
        <!-- Сообщение о необходимости верификации аккаунта -->
        <div class="flex h-screen items-center justify-center">
            <div class="bg-white p-6 rounded shadow-lg text-center">
                <h2 class="text-2xl font-bold mb-4">Необходима верификация аккаунта</h2>
                <p class="text-gray-700">Чтобы начать торговать, вам необходимо пройти верификацию аккаунта. Пожалуйста, свяжитесь с поддержкой или перейдите в настройки, чтобы завершить процесс верификации.</p>
            </div>
        </div>
    @endif
</div>
