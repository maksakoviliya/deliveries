<!DOCTYPE html>
<html>
<head>
    <title>Акт приема-передачи товаров</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>

<style>
    body {
        font-size: 12px;
    }

    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    h2 {
        letter-spacing: normal;
        font-size: 12px;
    }

    .uppercase {
        text-transform: uppercase;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #000;
    }

    .table th, .table td {
        padding: 6px;
        font-weight: normal;
        border: 1px solid #000;
        text-align: center;
    }

    .table__signature {
        width: 100%;
        border-collapse: collapse;
    }


</style>

<body>
<h2 class="text-center">Акт <br> приема-передачи товаров № {{ $act->id }}</h2>
<p class="text-right">от {{ $date }} г.</p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;<span
            class="uppercase">{{ $client->company->type }}</span>&nbsp;{{ $client->company->title }}, именуемый в
    дальнейшем "Принципиал", в лице {{ $client->name }}, с одной
    стороны и ИП Войцехович С.С., именуемый в дальнейшем "Агент", в лице Вайцеховича Сергея Сергеевича, с другой
    стороны, совместно именуемые "Стороны", составили настоящий Акт о нижеследующем:</p>
<br>
<p>1. Доставка товаров Принципиала, исполняемая Агентом в сроки, в сроки, установленные Принципиалом. Заказы, переданные
    агенту приведены ниже:</p>
<br>
<table class="table">
    <tr>
        <th>№<br>п/п</th>
        <th>Наименование товара</th>
        <th>Количество</th>
        <th>Общий вес</th>
        <th>Оценочная стоимость</th>
        <th>Комментарий</th>
        <th>Наложенный платеж</th>
    </tr>
    @foreach($act->orders as $i => $order)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $order->recipient->product_name }}</td>
            <td>{{ $order->quantity }}</td>
            <td>{{ $order->weight }}</td>
            <td>{{ $order->price }}</td>
            <td>{{ $order->comment }}</td>
            <td>-</td>
        </tr>
    @endforeach
    <tr>
        <td></td>
        <td>Итого:</td>
        <td></td>
        <td>{{ $order->totalWeight }}</td>
        <td>{{ $order->price }}</td>
        <td></td>
        <td></td>
    </tr>
</table>
<p>2. Товар передан в соответствующем количестве и ассортименте.</p>
<p>3. Стороны взаимных претензий не имеют.</p>
<br>
<p>Вариант. 3. При приемке Товара обнаружены недостатки:</p>
<p>3.1. По ассортименту: ___________________________________________.</p>
<p>3.2. По количеству: _____________________________________________.</p>
<p>3.3. ____________________________________________________________.</p>
<br>
<p>4. Настоящий Акт составлен в 2 (двух) экземплярах, имеющих равную юридическую силу, по одному для каждой Стороны.</p>
<br><br><br><br><br>
<p class="text-center">Подписи Сторон</p>
<table class="table__signature">
    <tr>
        <td class="w-1/2">Принципал:</td>
        <td class="w-1/2">Агент:</td>
    </tr>
    <tr>
        <td class="w-1/2">________/________ (подпись/Ф.И.О.)</td>
        <td class="w-1/2">________/________ (подпись/Ф.И.О.)</td>
    </tr>
</table>
</body>
</html>