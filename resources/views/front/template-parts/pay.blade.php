<div class="container">
    <h2>Оплата замовлення №{{ $order->id }}</h2>
    <p><strong>Сума до сплати:</strong> {{ $order->total_price }} грн</p>

    <form action="{{ route('liqpay.form', $order->id) }}" method="POST">
        @csrf
        <button type="submit" class="btn btn-success">Оплатити через LiqPay</button>
    </form>
</div>
