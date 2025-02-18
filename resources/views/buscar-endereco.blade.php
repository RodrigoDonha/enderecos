<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Endereço</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.0.2/tailwind.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="container mx-auto">
        <div class="max-w-xl mx-auto bg-white p-6 shadow-md">
            <label for="endereco" class="block text-sm font-medium text-gray-700">Endereço:</label>
            <input type="text" id="endereco" name="end_completo" class="mt-1 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
            <ul id="enderecos-list" class="mt-2 bg-white border border-gray-300 rounded-md hidden"></ul>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let debounceTimeout;
            let currentRequest = null;

            $('#endereco').on('keyup', function() {
                clearTimeout(debounceTimeout);
                const endereco = $(this).val();

                if (endereco.length > 2) {
                    debounceTimeout = setTimeout(function() {
                        if (currentRequest !== null) {
                            currentRequest.abort();
                        }

                        currentRequest = $.ajax({
                            url: '{{ route("enderecos.buscar") }}',
                            method: 'GET',
                            data: { end_completo: endereco },
                            success: function(data) {
                                let list = $('#enderecos-list');
                                list.empty();
                                if (data.length > 0) {
                                    data.forEach(function(item) {
                                        list.append('<li class="p-2 border-b border-gray-200 cursor-pointer hover:bg-gray-100">' + item.end_completo + '</li>');
                                    });
                                    list.removeClass('hidden');
                                } else {
                                    list.addClass('hidden');
                                }
                            },
                            error: function(xhr, status, error) {
                                if (status !== 'abort') {
                                    console.error('Erro na consulta:', error);
                                }
                            },
                            complete: function() {
                                currentRequest = null;
                            }
                        });
                    }, 300); // 300ms debounce time
                } else {
                    $('#enderecos-list').addClass('hidden');
                }
            });

            $(document).on('click', '#enderecos-list li', function() {
                const selectedAddress = $(this).text();
                $('#endereco').val(selectedAddress);
                $('#enderecos-list').addClass('hidden');
            });
        });
    </script>
</body>
</html>
