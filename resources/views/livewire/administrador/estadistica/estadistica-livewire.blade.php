<div>
    <!--SEO-->
    @section('tituloPagina', 'ESTADÍSTICAS')
    {{ setlocale(LC_TIME, 'es_ES', 'Spanish_Spain', 'Spanish') }}

    <!--TITULO-->
    <h1>ESTADÍSTICAS</h1>

    <div>
        <!--TOTALES-->
        @if (count($totales))
            <h2>Ganancia hoy</h2>
            <p>Total compra: {{ $totales[0]->totalcompra }} </p>
            <p>Total venta: {{ $totales[0]->totalventa }} </p>
        @endif

    </div>

    <div>
        @php
            $label_chart_compras_mes = [];
            $data_chart_compras_mes = [];
            
            $label_chart_ventas_mes = [];
            $data_chart_ventas_mes = [];
        @endphp
        <!--COMPRAS MENSUALES-->
        @if (count($compras_mensuales))
            @php
                foreach ($compras_mensuales as $item) {
                    array_push($label_chart_compras_mes, strftime('%B', strtotime($item->mes)));
                    array_push($data_chart_compras_mes, $item->totalmes);
                }
            @endphp
            <canvas id="chart_compras_mes"></canvas>
        @endif

        <!--VENTAS MENSUALES-->
        @if (count($ventas_mensuales))
            @php
                foreach ($compras_mensuales as $item) {
                    array_push($label_chart_ventas_mes, strftime('%B', strtotime($item->mes)));
                    array_push($data_chart_ventas_mes, $item->totalmes);
                }
            @endphp
            <canvas id="chart_ventas_mes"></canvas>
        @endif

    </div>

</div>

@push('script')
    <script>
        //COMPRAS MENSUALES
        const ctx_chart_compras_mes = document.getElementById('chart_compras_mes');
        new Chart(ctx_chart_compras_mes, {
            type: 'line',
            data: {
                labels: {{ Js::from($label_chart_compras_mes) }},
                datasets: [{
                    label: '# of Votes',
                    data: {{ Js::from($data_chart_compras_mes) }},
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        //VENTAS MENSUALES
        const ctx_chart_ventas_mes = document.getElementById('chart_ventas_mes');
        new Chart(ctx_chart_ventas_mes, {
            type: 'line',
            data: {
                labels: {{ Js::from($label_chart_ventas_mes) }},
                datasets: [{
                    label: '# of Votes',
                    data: {{ Js::from($data_chart_ventas_mes) }},
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        //VENTAS DIARIAS
        new Chart(ctx_chart_compras_mes, {
            type: 'line',
            data: {
                labels: {{ Js::from($label_chart_compras_mes) }},
                datasets: [{
                    label: '# of Votes',
                    data: {{ Js::from($data_chart_compras_mes) }},
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        //VENTAS MENSUALES
        const ctx_chart_ventas_mes = document.getElementById('chart_ventas_mes');
        new Chart(ctx_chart_ventas_mes, {
            type: 'bar',
            data: {
                labels: {{ Js::from($label_chart_ventas_mes) }},
                datasets: [{
                    label: '# of Votes',
                    data: {{ Js::from($data_chart_ventas_mes) }},
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush
<div>
    <!--SEO-->
    @section('tituloPagina', 'ESTADÍSTICAS')
    {{ setlocale(LC_TIME, 'es_ES', 'Spanish_Spain', 'Spanish') }}

    <!--TITULO-->
    <h1>ESTADÍSTICAS</h1>

    <div>
        <!--TOTALES-->
        @if (count($totales))
            <h2>Ganancia hoy</h2>
            <p>Total compra: {{ $totales[0]->totalcompra }} </p>
            <p>Total venta: {{ $totales[0]->totalventa }} </p>
        @endif

    </div>

    <div>
        @php
            $label_chart_compras_mes = [];
            $data_chart_compras_mes = [];
            
            $label_chart_ventas_mes = [];
            $data_chart_ventas_mes = [];
            
            $label_chart_compras_dia = [];
            $data_chart_compras_dia = [];
        @endphp
        <!--COMPRAS MENSUALES-->
        @if (count($compras_mensuales))
            @php
                foreach ($compras_mensuales as $item) {
                    array_push($label_chart_compras_mes, strftime('%B', strtotime($item->mes)));
                    array_push($data_chart_compras_mes, $item->totalmes);
                }
            @endphp
            <canvas id="chart_compras_mes"></canvas>
        @endif

        <!--VENTAS MENSUALES-->
        @if (count($ventas_mensuales))
            @php
                foreach ($compras_mensuales as $item) {
                    array_push($label_chart_ventas_mes, strftime('%B', strtotime($item->mes)));
                    array_push($data_chart_ventas_mes, $item->totalmes);
                }
            @endphp
            <canvas id="chart_ventas_mes"></canvas>
        @endif

        <!--COMPRAS DIARIOS-->
        @if (count($compras_dia))
            @php
                foreach ($compras_dia as $item) {
                    array_push($label_chart_compras_dia, $item->dia);
                    array_push($data_chart_compras_dia, $item->totaldia);
                }
            @endphp
            <canvas id="chart_compras_dia"></canvas>
        @endif

    </div>

</div>

@push('script')
    <script>
        //COMPRAS MENSUALES
        const ctx_chart_compras_mes = document.getElementById('chart_compras_mes');
        new Chart(ctx_chart_compras_mes, {
            type: 'line',
            data: {
                labels: {{ Js::from($label_chart_compras_mes) }},
                datasets: [{
                    label: '# of Votes',
                    data: {{ Js::from($data_chart_compras_mes) }},
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        //VENTAS MENSUALES
        const ctx_chart_ventas_mes = document.getElementById('chart_ventas_mes');
        new Chart(ctx_chart_ventas_mes, {
            type: 'line',
            data: {
                labels: {{ Js::from($label_chart_ventas_mes) }},
                datasets: [{
                    label: '# of Votes',
                    data: {{ Js::from($data_chart_ventas_mes) }},
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
        //COMPRAS DIARIAS
        const ctx_chart_compras_dia = document.getElementById('chart_compras_dia');
        new Chart(ctx_chart_compras_dia, {
            type: 'bar',
            data: {
                labels: {{ Js::from(array_reverse($label_chart_compras_dia)) }},
                datasets: [{
                    label: '# of Votes',
                    data: {{ Js::from(array_reverse($data_chart_compras_dia)) }},
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush
