@extends('layouts.trading')
@section('main')
    <div class="w-full h-screen">
        <div class="tradingview-widget-container" style="height:100%;width:100%">
            <div class="tradingview-widget-container__widget" style="height:calc(100% - 32px);width:100%"></div>
            <script type="text/javascript" src="https://s3.tradingview.com/external-embedding/embed-widget-advanced-chart.js" async>
                {
                    "autosize": true,
                    "symbol": "NASDAQ:AAPL",
                    "interval": "D",
                    "timezone": "Europe/Berlin",
                    "theme": "dark",
                    "style": "1",
                    "locale": "ru",
                    "withdateranges": true,
                    "hide_side_toolbar": false,
                    "allow_symbol_change": true,
                    "details": true,
                    "calendar": false,
                    "support_host": "https://venture-vigil.com"
                }
            </script>
        </div>
    </div>
@endsection
