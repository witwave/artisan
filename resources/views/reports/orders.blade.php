<html>
    @if (count($data))
    <table>
        <tr>
            <th>User</th>
            <th>{{ Lang::get('forms.email') }}</th>
            <th>{{ Lang::get('forms.paid') }}</th>
            <th>{{ Lang::get('forms.payment_status') }}</th>
            <th>{{ Lang::get('forms.transaction_id') }}</th>
            <th>{{ Lang::get('forms.ordered_on') }}</th>
            <th>{{ Lang::get('forms.products') }}</th>
            <th>{{ Lang::get('forms.sku') }}</th>
        </tr>
        @foreach($data as $order)
            @foreach($order->products as $product)
                <tr>
                    @if ($order->user != null)
                    <td>{{ str_replace(',', '.', $order->user->first_name) }} {{ str_replace(',', '.', $order->user->last_name) }}</td>
                    <td>{{ str_replace(',', '.', $order->user->email) }}</td>
                    @else
                    <td>User deleted</td>
                    <td>User deleted</td>
                    @endif
                    <td>{{ App\Helpers\RHelper::formatCurrency($order->paid, Lang::get('currency.currency')) }}</td>
                    <td>{{ str_replace(',', '.', $order->payment_status) }}</td>
                    <td>{{ str_replace(',', '.', $order->transaction_id) }}</td>
                    <td>{{ str_replace(',', '.', $order->created_at) }}</td>
                    <td>{{ str_replace(',', '.', $product->name) }}</td>
                    <td>{{ str_replace(',', '.', $product->sku) }}</td>
                </tr>
            @endforeach
        @endforeach
    </table>
    @endif
</html>
