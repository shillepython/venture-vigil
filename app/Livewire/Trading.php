<?php

namespace App\Livewire;

use App\Models\OrderTradeHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use App\Models\TradingOrder;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Livewire\Attributes\On;

class Trading extends Component
{
    use WithPagination;
    public $symbol = 'EUR/USD';
    public $interval = 1;
    public $successRate;
    public $currentPrice; // Публичное свойство для текущей цены
    public $orders = [];
    public $volume = 0.01; // Начальное значение объема
    public $availableBalance;
    public $tradeAmount; // Новое свойство для суммы сделки
    public $initialCandleData = [];
    public $lastOrderType;

    protected $listeners = ['refreshOrders' => 'loadOrders'];

    public function mount()
    {
        $this->fetchCurrentPrice();
        $this->loadOrders();
        $this->availableBalance = Auth::user()->balance;
        $this->successRate = Auth::user()->successRate;

        if ($this->orders->isEmpty()) {
            $this->lastOrderType = null;
        } else {
            $randomOrder = $this->orders->random();
            $this->lastOrderType = $randomOrder->type;
        }
        $this->generateInitialCandles($this->currentPrice, 5100); // Генерация 1000 случайных свечей

        $this->updateTradeAmount(); // Обновляем сумму сделки при монтировании компонента
    }

    public function fetchCurrentPrice()
    {
        $response = Http::get('https://open.er-api.com/v6/latest/EUR');

        if ($response->successful()) {
            $data = $response->json();
            $this->currentPrice = $data['rates']['USD']; // Получение курса EUR/USD
        } else {
            $this->currentPrice = 1.1128; // Резервное значение, если API недоступно
        }
    }

    public function generateInitialCandles($price, $count = 1000)
    {
        $candles = [];
        $currentPrice = $price;
        $time = 0;
        for ($i = 0; $i < $count; $i++) {
            $open = $currentPrice;
            $high = $open + (mt_rand(0, 2000) / 100000); // случайное значение для high
            $low = $open - (mt_rand(0, 2000) / 100000);  // случайное значение для low
            $close = mt_rand(0, 1) ? $high : $low;

            $candles[] = [
                'time' => time() + $time,
                'open' => $open,
                'high' => $high,
                'low' => $low,
                'close' => $close
            ];

            $time += 1000;
            $currentPrice = $close; // обновляем текущую цену для следующей свечи
        }

        $this->initialCandleData = $candles;
    }

    public function updatedVolume()
    {
        // Проверка значения и его корректировка
        if ($this->volume < 0) {
            $this->volume = 0;
        } elseif ($this->volume > 1) {
            $this->volume = 1;
        } else {
            // Округляем значение до 2 знаков после запятой
            $this->volume = round($this->volume, 3);
        }

        $this->updateTradeAmount(); // Обновляем сумму сделки
    }

    public function updateTradeAmount()
    {
        $this->tradeAmount = round($this->availableBalance * $this->volume, 2);
    }

    public function openOrder($type)
    {
        $entryPrice = $this->currentPrice;
        $tradeAmount = $this->tradeAmount; // Используем вычисленную сумму сделки

        TradingOrder::create([
            'user_id' => Auth::id(),
            'symbol' => $this->symbol,
            'type' => $type,
            'volume' => $tradeAmount,
            'entry_price' => $entryPrice,
            'duration' => $this->interval,
        ]);

        $user = Auth::user();
        $user->balance -= $tradeAmount;
        if ($user->balance < 0) {
            $user->balance = 0;
        }
        $user->save();

        $this->lastOrderType = $type;

        $this->loadOrders();
        $this->availableBalance = $user->balance;
        $this->updateTradeAmount(); // Обновляем сумму сделки после открытия ордера
    }


    #[On('current-price')]
    public function updateCurrentPrice($price)
    {
        $this->currentPrice = $price; // Обновляем текущую цену
    }

    public function calculateProfit($entryPrice, $closingPrice, $volume, $type)
    {
        $quantity = $volume / $entryPrice;

        // Если тип ордера "buy", прибыль возникает при росте цены
        if ($type === 'buy') {
            $currentValue = $quantity * $closingPrice;
            $profit = $currentValue - $volume;
        }
        // Если тип ордера "sale", прибыль возникает при падении цены
        elseif ($type === 'sell') {
            $currentValue = $quantity * $closingPrice;
            $profit = $volume - $currentValue; // Прибыль возникает, когда цена снижается
        }

        return $profit;
    }

    public function closeOrder($orderId, $currentPrice)
    {
        $order = TradingOrder::find($orderId);
        if (!$order || $order->user_id != Auth::id()) {
            abort(403);
        }

        $profit = $this->calculateProfit($order->entry_price, $currentPrice, $order->volume, $order->type);

        // Вычисление продолжительности сделки в минутах
        $createdAt = Carbon::parse($order->created_at);
        $closedAt = Carbon::now();
        $duration = $closedAt->diffInMinutes($createdAt);

        // Сохранение в историю
        OrderTradeHistory::create([
            'user_id' => Auth::id(),
            'symbol' => $order->symbol,
            'type' => $order->type,
            'volume' => $order->volume,
            'entry_price' => $order->entry_price,
            'closing_price' => $currentPrice,
            'profit' => $profit,
            'duration' => $duration, // Используем рассчитанную продолжительность
        ]);

        $user = Auth::user();
        $user->balance = round($user->balance + $order->volume + $profit, 3);
        if ($user->balance < 0) {
            $user->balance = 0;
        }
        $user->save();

        $order->delete();

        $this->loadOrders();

        if ($this->orders->isEmpty()) {
            $this->lastOrderType = null;
        } else {
            $randomOrder = $this->orders->random();
            $this->lastOrderType = $randomOrder->type;
        }

        $this->availableBalance = $user->balance;
        $this->updateTradeAmount();
    }

    #[On('load-orders')]
    public function loadOrders()
    {
        $this->orders = Auth::user()->tradingOrders()->get()->map(function ($order) {
            $currentPrice = $this->currentPrice;
            $order->profit = $this->calculateProfit($order->entry_price, $currentPrice, $order->volume, $order->type);

            return $order;
        });
    }

    public function render()
    {
        $orderHistory = OrderTradeHistory::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return view('livewire.trading', [
            'orderHistory' => $orderHistory
        ]);
    }
}
