<style>
    #cimg {
        max-width: 100%;
        max-height: 25em;
        object-fit: scale-down;
        object-position: center center;
    }
</style>
<main class="h-full pb-16 overflow-y-auto">
    <div class="container px-6 mx-auto grid">
        <h2 class="my-6 text-2xl font-semibold text-gray-700 dark:text-gray-200">
            <?php echo isset($id) ? 'Editar pagamento' : 'Novo pagamento'; ?>
            <a href="./?page=affiliates">
                <button class="px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                    Voltar
                </button>
            </a>
        </h2>

        <div class="px-4 py-3 mb-2 bg-white rounded-lg shadow-md dark:bg-gray-800">
            <form action="" id="manage-order" autocomplete="off">
                <label class="block text-sm mb-2">
                    <span class="text-gray-700 dark:text-gray-400">Afiliado</span>
                    <input name="referral_id" id="referral_id" type="number" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="Informe o número do afiliado"/>
                </label>

                <label class="block mt-4 text-sm">
                    <span class="text-gray-700 dark:text-gray-400">Valor</span>
                    <input name="price" id="price" type="number" step="0.01" class="block w-full mt-1 text-sm dark:border-gray-600 dark:bg-gray-700 focus:border-purple-400 focus:outline-none focus:shadow-outline-purple dark:text-gray-300 dark:focus:shadow-outline-gray form-input" placeholder="10,00"/>
                </label>
            </form>
        </div>

        <div class="mt-2">
            <button form="manage-order" class="px-5 py-3 font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                Cadastrar
            </button>
        </div>
    </div>
</main>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
<script>
    $('#manage-order').submit(function(e) {
        e.preventDefault();
        $.ajax({
            url: _base_url_ + 'class/Main.php?action=create_payment_affiliate',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                var returnedData = JSON.parse(resp);
                if (returnedData.status == 'success') {
                    alert('Pagamento cadastrado com sucesso!');
                    location.href = '/afiliados'
                } else if (returnedData.status == 'failed') {
                    alert(returnedData.msg);
                } else {
                    console.log(resp);
                    alert("[CP01] - Erro ao cadastrar pagamento");
                }
            }
        })
    });
</script>
