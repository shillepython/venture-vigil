<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;
use App\Models\TradingOrder;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;

class Trading extends Component
{
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

        // Создание первой свечи на основе текущей цены
        $this->generateInitialCandle($this->currentPrice);
    }

    public function generateInitialCandle($price)
    {
        $open = (float) $price;
        $high = $open + 0.001;
        $low = $open - 0.001;
        $close = (float) $price;

        $this->initialCandleData[] = [
            'x' => now()->toISOString(),
            'y' => [$open, $high, $low, $close]
        ];
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
            $this->volume = round($this->volume, 2);
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
        return view('livewire.trading');
    }
}
