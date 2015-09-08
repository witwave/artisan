<html>
    @if (count($data))
    <table>
        <tr>
            <th>{{ Lang::get('forms.email') }}</th>
            <th>{{ Lang::get('forms.first_name') }}</th>
            <th>{{ Lang::get('forms.last_name') }}</th>
            <th>{{ Lang::get('forms.active') }}</th>
            <th>{{ Lang::get('forms.updated') }}</th>
        </tr>
        @foreach ($data as $item)
            <tr>
                <td>{{ str_replace(',', '.', $item->email) }}</td>
                <td>{{ str_replace(',', '.', $item->first_name) }}</td>
                <td>{{ str_replace(',', '.', $item->last_name) }}</td>
                <td>@if($item->active){{ 'Yes' }}@else{{ 'No' }}@endif</td>
                <td>{{ str_replace(',', '.', $item->updated_at) }}</td>
            </tr>
        @endforeach
    </table>
    @endif
</html>
