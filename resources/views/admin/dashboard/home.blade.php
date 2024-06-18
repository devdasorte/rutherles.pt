@php

    use Carbon\Carbon;
    $user = Auth::user();
    

    $plan_id = $user->plan_id;

    $price = Utility::getplan();
 


    $raffle = isset($_GET['raffle']) ? $_GET['raffle'] : '';
    $top = isset($_GET['top']) ? $_GET['top'] : '';

@endphp



<style>
    tr.text-gray-700.dark\:text-gray-400 {
        vertical-align: text-bottom;
    }

    .span-whats {
        width: 100%;
        justify-content: space-around;
        margin-top: 10px;
    }

    #btn-whats {
        display: flex;
        justify-content: center;
        align-content: center;
        align-items: center;
        padding: 8px;
        max-height: 38px;
        gap: 3px;
        max-width: 50%;
        background-color: #0e9f6e;
    }

    .span-whats>a {
        display: flex;
        justify-content: center;
        align-content: center;
        align-items: center;
        padding: 8px;
        gap: 3px;
        width: 45%;
        max-height: 38px;
        background-color: #0e9f6e;
    }

    .span-whats>button {
        justify-content: space-evenly;
        align-content: center;
        align-items: center;
        padding: 8px;
        gap: 3px;
        max-height: 38px;
        width: 45%;
    }

    #btn-whats>svg {
        width: 25px;
        height: 25px;
        max-width: 25px;
        min-width: 15px;
        max-height: 25px;
        min-height: 15px;
    }

    .winner-info span {
        display: block;
    }

    .items-end {
        align-items: flex-end !important;
    }

    .mx-auto {
        margin-left: auto;
        margin-right: auto;

    }

    @media and (max-width: 768px) {
        .container {
            padding-inline: 4px
        }
    }
</style>
@push('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}">
@endpush





<div style="justify-content:space-between" class="row">

   @php

$plans = Utility::getsettings('plan_setting');
$plan = json_decode($plans,true);

$plan_id = $user->plan_id;
$price = $plan[$plan_id];
$plan_expired_date= $plan['plan_expired_date'];


   @endphp

    @if (Auth::user()->type == 'Admin')
        <div class="col-md-12">
            @if ($price == 0.00)
            <x-painel-alert   icon="o-exclamation-triangle" shadow title="{{ __('Seu plano é uma versão de avaliação ') . 'válido até ' . Utility::date_format($plan_expired_date) }}"  >
    

  

                <x-slot name="actions">
                    <a href="{{ route('planos') }}" class="btn btn-sm">{{ __('Atualize') }}</a>
                </x-slot>


            </x-painel-alert>
            

           
           

        
            


           
            @endif

            @if ($plan_expired_date )

            <x-painel-alert   icon="o-exclamation-triangle" shadow title="{{ __('Seu plano vence em ') .   Utility::date_format($plan_expired_date) }}" input="Atualize"  >
    

  

                <x-slot name="actions">
                    <a href="{{ route('planos') }}" class="btn btn-sm">{{ __('Atualize') }}</a>
                </x-slot>

                
            </x-painel-alert>



           
            @endif
      
          
   
        </div>
    @endif



    <div class="row">





        @include('rifa.admin.home')

        <div style="justify-content:space-between" class="row">



            <div class="col-xxl-6">
                <div style="height:85%" class="card bg-primary">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-sm-8">
                                <h2 class="text-white mb-3"> Olá {{ $firestname[0] ? $firestname[0] : 'Admin' }}</h2>
                                <p class="text-white mb-4">
                                    {{ __('Tenha um ótimo dia! Adicione rapidamente Suas campanhas e recursos.') }}
                                </p>




                                <div class="dropdown quick-add-btn">
                                    <a class="btn-q-add dropdown-toggle dash-btn btn btn-default btn-light"
                                        data-bs-toggle="dropdown" href="javascript:void(0)" role="button"
                                        aria-haspopup="false" aria-expanded="false">
                                        <i class="ti ti-plus drp-icon"></i>
                                        <span class="ms-1">{{ __('Adicione') }}</span>
                                    </a>
                                    <div class="dropdown-menu">

                                        @if (Auth::user()->type != 'Super Admin')
                                        @endif

                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4 d-none d-sm-flex">
                                <img src="{{ asset('vendor/landing-page2/image/img-auth-3.svg') }}" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>

            </div>




            <div class="col-xxl-6">
                <div style="height:85%" class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5> {{ __('Campanhas') }} </h5>

                    </div>
                    <div class="card-body">

                        <div id="users-chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</main>




@push('javascript')
<script src="{{ asset('vendor/modules/moment.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/apexcharts.min.js') }}"></script>
    <script src="{{ asset('vendor/daterangepicker/daterangepicker.min.js') }}"></script>
    <script>
        $(function() {
            var start = moment().subtract(5, 'days');
            var end = moment();

            function cb(start, end) {
                $('.chartRange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
                var start = start.format('YYYY-MM-DD');
                var end = end.format('YYYY-MM-DD');
                $.ajax({
                    url: "{{ route('get.chart.data') }}",
                    type: 'POST',
                    data: {
                        start: start,
                        end: end,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(result) {
                        chartFun(result.lable, result.value);
                    },
                    error: function(data) {
                        return data.responseJSON;
                    }
                });
            }

            function chartFun(lable, value) {
                var options = {
                    chart: {
                        height: '85%',
                        type: 'area',
                        toolbar: {
                            show: false,
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    stroke: {
                        width: 2,
                        curve: 'smooth'
                    },
                    series: [{
                        name: 'Users',
                        data: value
                    }],
                    xaxis: {
                        categories: lable,
                    },
                    colors: ['{{ $chatcolor }}'],

                    grid: {
                        strokeDashArray: 4,
                    },
                    legend: {
                        show: false,
                    },
                    markers: {
                        size: 4,
                        colors: ['{{ $chatcolor }}'],
                        opacity: 0.9,
                        strokeWidth: 2,
                        hover: {
                            size: 7,
                        }
                    },
                    yaxis: {
                        tickAmount: 3,
                        min: 0,
                    }
                };
                $("#users-chart").empty();
                var chart = new ApexCharts(document.querySelector("#users-chart"), options);
                chart.render();
            }
            $('.chartRange').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                    'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                    'This Month': [moment().startOf('month'), moment().endOf('month')],
                    'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1,
                        'month').endOf('month')],
                    'This Year': [moment().startOf('year'), moment().endOf('year')],
                    'Last Year': [moment().subtract(1, 'year').startOf('year'), moment().subtract(1,
                        'year').endOf('year')],
                }
            }, cb);
            cb(start, end);
        });











        function hideView() {
            var x = document.getElementById("hide-view");
            var y = document.getElementById("hided");

            if (x.style.display === "none") {
                x.style.display = "block";
                y.style.display = "none";
            } else {
                x.style.display = "none";
                y.style.display = "block";
            }
        }

        $(document).ready(function() {
            $('#get-ganhador').on('click', function() {
                $("#error").empty()

                if ($('#raffle').val() == '') {
                    show_toastr('Campanha não selecionada!',
                        'Selecione uma campanha para buscar o ganhador!', 'error');
                    return false;

                }
                if ($('#number').val() == '') {
                    show_toastr('Número não informado!', 'Informe um número para buscar o ganhador!',
                        'error');
                    return false;

                }

                $('#buscar-ganhador').submit();
            });
            $('#buscar-ganhador').submit(function(e) {
                e.preventDefault()

                $.ajax({
                    url: _BASE_URL_ + "class/Main.php?action=search_raffle_winner",
                    method: 'POST',
                    type: 'POST',
                    data: new FormData($(this)[0]),
                    dataType: 'json',
                    cache: false,
                    processData: false,
                    contentType: false,
                    error: err => {
                        console.log(err)


                    },
                    success: function(resp) {

                        if (resp.status == 'success' && resp.name) {
                            show_toastr('Gnhador encontrado!',
                                'Ganhador encontrado com sucesso!', 'success');

                            var half_phone = resp.phone.substr(0, 9) + '****';
                            $('#name').html('<strong>Nome:</strong> ' + resp.name);
                            $('#winner_phone').val(resp.phone);
                            $('#winner_number').val(resp.number);
                            $('#pedido').html('<strong>Campanha:</strong> ' + resp
                                .product_name);
                            $('#order').html('<strong>Pedido:</strong> ' + resp.pedido);
                            $('#quantity').html('<strong>Quantidade:</strong> ' + resp
                                .quantity);
                            $('#value').html('<strong>Valor:</strong> R$ ' + resp.value);
                            $('#name').html('<strong>Nome:</strong> ' + resp.name);
                            $('#phone').html('<strong>Telefone:</strong> ' + half_phone);
                            $('#date').html('<strong>Data:</strong> ' + resp.date);
                            if (resp.type_of_draw == 1) {
                                $('#cota').html('<strong>Número:</strong> ' + resp.number);
                            } else {
                                $('#cota').html('<strong>Bicho:</strong> ' + resp.number);
                            }
                            $('#payment_status').html('<strong>Status:</strong> ' + resp
                                .payment_status);
                            $('.winner').text('');
                            $('#btn-vencedor-clean').removeClass('flex').addClass('hidden')
                            $('#span-whats').removeClass('hidden').addClass('flex');
                            $("#winner_info").removeClass('hidden')
                            $("#btn-whats").attr('href',
                                'https://api.whatsapp.com/send?phone=55' + resp.phone +
                                '&text=Olá, ' + resp.name +
                                ', você foi o ganhador da campanha ' + resp.product_name +
                                ' com o número ' + resp.number + '! Parabéns!');




                        } else {

                            $('#name').html('');
                            $('#phone').html('');
                            $('#date').html('');
                            $('#number').html('');
                            $('#payment_status').html('');
                            $("#error").html('Vencedor não encontrado, tente outro número');
                            $("#span-whats").addClass('hidden').removeClass('flex');
                            $('#winner_info').addClass('hidden')


                            console.log(resp)
                        }
                    }
                })
            })

            $('#btn-vencedor').on('click', function() {

                var id = $('#raffle').val();
                var draw_number = $('#winner_number').val();
                var draw_winner = $('#winner_phone').val();


                $.ajax({
                    url: _BASE_URL_ + "class/Main.php?action=save_raffle_winner",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },

                    method: 'POST',
                    type: 'POST',
                    data: {
                        id: id,
                        draw_number: draw_number,
                        draw_winner: draw_winner
                    },
                    dataType: 'json',

                    success: function(resp) {

                        if (resp.status == 'success') {
                            show_toastr('Gnhador salvo!', 'Ganhador salvo com sucesso!',
                                'success');

                            $('#btn-vencedor').removeClass('flex').addClass('hidden')
                            $('#btn-vencedor-clean').removeClass('hidden').addClass('flex')
                        } else {
                            alert('Erro ao salvar ganhador');


                        }
                    }
                })

            })
            $('#btn-vencedor-clean').on('click', function() {
                $('#name').html('');
                $('#phone').html('');
                $('#date').html('');
                $('#number').html('');
                $('#payment_status').html('');
                $("#error").html('');
                $("#winner_info").addClass('hidden')
                $('#btn-vencedor').removeClass('hidden').addClass('flex')
                $('#btn-vencedor-clean').removeClass('flex').addClass('hidden')
                $('#span-whats').addClass('hidden').removeClass('flex');

            })
        })
    </script>
@endpush
