<!DOCTYPE html>
<html>
<head>
    <title>Laravel 9 Generate PDF Example - ItSolutionStuff.com</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
</head>

<style>
    .text-center {
        text-align: center;
    }

    .text-right {
        text-align: right;
    }

    h2 {
        letter-spacing: normal;
    }

    .uppercase {
        text-transform: uppercase;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        border: 1px solid #000;
    }

    th, td {
        padding: 10px;
        font-weight: normal;
        border: 1px solid #000;
        text-align: center;
    }
</style>

<body>
<h2 class="text-center">Акт <br> приема-передачи товара</h2>
<p class="text-right">{{ $date }}</p>
<p>&nbsp;&nbsp;&nbsp;&nbsp;<span class="uppercase">{{ $client->company->type }}</span>&nbsp;{{ $client->company->title }}, именуемый в дальнейшем "Принципиал", в лице {{ $client->name }}, с одной
    стороны и ИП Войцехович С.С., именуемый в дальнейшем "Агент", в лице Вайцеховича Сергея Сергеевича, с другой стороны, совместно именуемые "Стороны", составили настоящий Акт о нижеследующем:</p>
<br>
<p>1. Доставка товаров Принципиала, исполняемая Агентом в сроки, в сроки, установленные Принципиалом. Заказы, переданные агенту приведены ниже:</p>
<br>
<table class="table">
    <tr>
        <th>№<br>п/п</th>
        <th>Внутренний номер заказа</th>
        <th>Наименование товара</th>
        <th>Вес товара</th>
        <th>Оценочная стоимость товара</th>
    </tr>
    @foreach($act->orders as $i => $order)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>{{ $order->id }}</td>
            <td>{{ $order->recipient->product_name }}</td>
            <td>{{ $order->weight }}</td>
            <td>{{ $order->price }}</td>
        </tr>
    @endforeach
    <tr>
        <td></td>
        <td>Итого:</td>
        <td></td>
        <td>{{ $order->totalWeight }}</td>
        <td>{{ $order->price }}</td>
    </tr>
</table>

</body>
</html>