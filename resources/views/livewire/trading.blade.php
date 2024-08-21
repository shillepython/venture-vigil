<div>
    @if(isset(Auth::user()->verifications) && Auth::user()->verifications->status == 1)
    <div class="flex h-screen">
        <!-- Левая панель управления -->
        <div class="w-2/12 bg-gray-800 text-white p-4">
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
            <div class="flex space-x-4 mb-4">
                <button wire:click="openOrder('buy')" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">Купить</button>
                <button wire:click="openOrder('sell')" class="w-full bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Продать</button>
            </div>
        </div>

        <!-- Правая часть с графиком и ордерами -->
        <div class="w-10/12 bg-gray-100 p-4">
            <!-- График -->
            <div class="bg-gray-900 text-white p-4 rounded mb-4" wire:ignore>
                <h3 id="current-price" class="text-lg font-bold">Текущая цена: {{ $currentPrice }}</h3>
                <div id="chart" class="mb-4"></div>
            </div>

            <!-- Открытые ордера -->
            <div class="bg-white p-4 rounded shadow">
                <h3 class="text-lg font-bold mb-2">Открытые ордера</h3>
                <table class="table-auto w-full">
                    <thead class="bg-gray-800 text-white">
                    <tr>
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
                        <tr class="border-t" id="order-{{ $order->id }}">
                            <td class="px-4 py-2">{{ $order->symbol }}</td>
                            <td class="px-4 py-2">{{ ucfirst($order->type) }}</td>
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
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    @script
    <script>
        let initialData = @json($initialCandleData);

        const options = {
            series: [{
                data: initialData
            }],
            chart: {
                type: 'candlestick',
                height: 400,
                zoom: {
                    enabled: true,
                    type: 'x',
                    autoScaleYaxis: true
                },
                toolbar: {
                    show: true,
                    autoSelected: 'zoom'
                },
                panning: {
                    enabled: true,
                    type: 'x'
                }
            },
            theme: {
                mode: 'dark'
            },
            xaxis: {
                type: 'datetime',
                labels: {
                    style: {
                        colors: '#ffffff'
                    }
                }
            },
            yaxis: {
                tooltip: {
                    enabled: true
                },
                labels: {
                    style: {
                        colors: '#ffffff'
                    }
                }
            },
            grid: {
                borderColor: '#555',
            },
            plotOptions: {
                candlestick: {
                    colors: {
                        upward: '#00ff00',
                        downward: '#ff0000'
                    }
                }
            }
        };

        const chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();

        function addNewCandle() {
            const lastCandle = initialData[initialData.length - 1];
            const lastClosePrice = lastCandle.y[3];

            // Получение типа последнего ордера и winRate
            const lastOrderType = @this.get('lastOrderType');
            const successRate = {{ $successRate / 100 }};

            // Определение направления новой свечи на основе successRate и типа ордера
            const isFavorable = Math.random() < successRate;
            let newCandle;

            if (lastOrderType === 'buy') {
                console.log('1')
                newCandle = {
                    x: new Date(lastCandle.x).getTime() + 2 * 1000,
                    y: isFavorable ? [
                        lastClosePrice,
                        lastClosePrice + (Math.random() * 0.001), // high
                        lastClosePrice - (Math.random() * 0.0005), // low
                        lastClosePrice + (Math.random() * 0.001) // close (цена вверх)
                    ] : [
                        lastClosePrice,
                        lastClosePrice + (Math.random() * 0.0005), // high
                        lastClosePrice - (Math.random() * 0.001), // low
                        lastClosePrice - (Math.random() * 0.001) // close (цена вниз)
                    ]
                };
            } else if (lastOrderType === 'sell') {
                console.log('2')
                newCandle = {
                    x: new Date(lastCandle.x).getTime() + 2 * 1000,
                    y: isFavorable ? [
                        lastClosePrice,
                        lastClosePrice - (Math.random() * 0.001), // high
                        lastClosePrice - (Math.random() * 0.002), // low
                        lastClosePrice - (Math.random() * 0.001) // close (цена вниз)
                    ] : [
                        lastClosePrice,
                        lastClosePrice + (Math.random() * 0.001), // high
                        lastClosePrice - (Math.random() * 0.0005), // low
                        lastClosePrice + (Math.random() * 0.001) // close (цена вверх)
                    ]
                };
            } else {
                const isBullish = Math.random() < 0.5;
                newCandle = {
                    x: new Date(lastCandle.x).getTime() + 2 * 1000,
                    y: isBullish ? [
                        lastClosePrice,
                        lastClosePrice + (Math.random() * 0.001), // high
                        lastClosePrice - (Math.random() * 0.0005), // low
                        lastClosePrice + (Math.random() * 0.001) // close
                    ] : [
                        lastClosePrice,
                        lastClosePrice - (Math.random() * 0.0005), // high
                        lastClosePrice - (Math.random() * 0.001), // low
                        lastClosePrice - (Math.random() * 0.001) // close
                    ]
                };
            }

            initialData.push(newCandle);
            chart.updateSeries([{
                data: initialData
            }]);

            document.getElementById('current-price').textContent = `Текущая цена: ${newCandle.y[3].toFixed(6)}`;

            Livewire.dispatch('current-price', { price: newCandle.y[3] });
            Livewire.dispatch('load-orders');
        }

        setInterval(() => {
            addNewCandle();
        }, 2000);
    </script>
    @endscript

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
