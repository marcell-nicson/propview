<x-app-layout>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Lista de imoveis -->
                <div class="p-6">                    
                    <h5>{{ __("Lista de imoveis") }}
                        <button type="button" class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#modalimovel">
                            Incluir +
                        </button>
                    </h5>

                    @if ($imoveis->isEmpty())
                        <p>Nenhum imovel cadastrado.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>                                    
                                    <th class="text-sm">Titulo</th>
                                    <th class="text-sm">Descrição</th>
                                    <th class="text-sm">Tipo</th>
                                    <th class="text-sm">Endereço</th>
                                    <th class="text-sm">Latitude</th>
                                    <th class="text-sm">Longitude</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($imoveis as $imovel)
                                    <tr>
                                        <td class="text-sm"> {{ $imovel->id . ' - ' }} {{ $imovel->titulo }}</td>
                                        <td class="text-sm">{{ $imovel->descricao }}</td>
                                        <td class="text-sm">{{ $imovel->tipo_negocio }}</td>
                                        <td class="text-sm">{{ $imovel->endereco }}</td>
                                        <td class="text-sm">{{ $imovel->latitude }}</td>
                                        <td class="text-sm">{{ $imovel->longitude }}</td>
                                        <td> 
                                            <a type="button" data-toggle="modal" data-target="#fotosImovelModal{{ $imovel->id }}">
                                                <i class="fa-regular fa-image" style="color: #146c19; font-size: 20px;"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#editarimovelModal{{ $imovel->id }}">
                                                <i class="fas fa-edit" style="color: #2a45cc; font-size: 20px;"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#excluirimovelModal{{ $imovel->id }}">
                                                <i class="fa-solid fa-trash" style="color: #df1616; font-size: 20px;"></i>
                                            </a>
                                        </td>
                                    </tr>                                    
                                    <div class="modal fade" id="excluirimovelModal{{ $imovel->id }}" tabindex="-1" role="dialog" aria-labelledby="excluirimovelModal{{ $imovel->id }}Label" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="excluirimovelModal{{ $imovel->id }}Label">Confirmar Exclusão</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Tem certeza de que deseja excluir o imovel {{ $imovel->nome }}?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                    <form action="{{ route('imovel.destroy', $imovel->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Excluir</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal de Edição do imovel -->
                                    <div class="modal fade" id="editarimovelModal{{ $imovel->id }}" tabindex="-1" role="dialog" aria-labelledby="editarimovelModal{{ $imovel->id }}Label" aria-hidden="true">                                    
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editarimovelModal{{ $imovel->id }}Label">Editar imovel</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('imovel.update', $imovel->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="titulo" class="form-label">Título</label>
                                                            <input type="text" class="form-control" id="titulo" name="titulo" value="{{ $imovel->titulo }}" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="descricao" class="form-label">Descrição</label>
                                                            <textarea class="form-control" id="descricao" name="descricao" rows="4" required>{{ $imovel->descricao }}</textarea>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="tipo_negocio" class="form-label">Tipo de Negócio:</label>
                                                            <select class="form-control" id="tipo_negocio" name="tipo_negocio" value="{{ $imovel->tipo_negocio }}" required>
                                                                <option value="venda">Venda</option>
                                                                <option value="aluguel">Aluguel</option>
                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="fotos" class="form-label">Incluir Fotos</label>
                                                            <input type="file" class="form-control" id="fotos" name="fotos[]" multiple>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="titulo_foto" class="form-label">Título da Foto</label>
                                                            <input type="text" class="form-control" id="titulo_foto" name="titulo_foto">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="descricao_foto" class="form-label">Descrição da Foto</label>
                                                            <textarea class="form-control" id="descricao_foto" name="descricao_foto" rows="2"></textarea>
                                                        </div>                                                     
                                                        <div class="mb-3">
                                                            <label for="endereco" class="form-label">Endereço</label>
                                                            <input type="text" class="form-control" id="endereco" value="{{ $imovel->endereco }}" placeholder="Rua. Joaquim Nabuco, Mossoró - RN, 59600-300" name="endereco" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="latitude" class="form-label">Latitude</label>
                                                            <input type="text" class="form-control" id="latitude" value="{{ $imovel->latitude }}" name="latitude" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="longitude" class="form-label">Longitude</label>
                                                            <input type="text" class="form-control" id="longitude" value="{{ $imovel->longitude }}" name="longitude" required>
                                                        </div>
                                                    </div>                    
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                        <button type="submit" class="btn btn-success">Salvar Alterações</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                              

                                    <!-- Modal para exibir as fotos -->
                                    <div class="modal fade" id="fotosImovelModal{{ $imovel->id }}" tabindex="-1" role="dialog" aria-labelledby="fotosImovelModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="fotosImovelModalLabel">Fotos do Imóvel</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">                                                    
                                                    <div class="row">
                                                        @foreach ($imovel->photos as $foto)
                                                            <div class="col-4">                                                                
                                                                <img src="{{ route('exibir-foto', $foto->id) }}" class="img-fluid" alt="{{ $foto->titulo }}">
                                                                <p>{{ $foto->descricao }}</p>
                                                                <button type="button" class="btn btn-danger btn-sm excluir-foto" data-foto-id="{{ $foto->id }}">
                                                                    Excluir
                                                                </button>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                @endforeach
                                @if (session('success'))
                                    <div class="alert alert-success">
                                        {{ session('success') }}
                                    </div>
                                @endif


                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                <script>
                                    $(document).ready(function() {
                                        // Função de validação para email e whatsapp
                                        function validateInput(inputField, regex, validationMessageId, validMessage, invalidMessage) {
                                            inputField.on("input", function() {
                                                if (regex.test($(this).val())) {
                                                    $(validationMessageId).text(validMessage).css("color", "green");
                                                } else {
                                                    $(validationMessageId).text(invalidMessage).css("color", "red");
                                                }
                                            });
                                        }
                                
                                        // Expressões regulares para email e whatsapp
                                        var emailRegex = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
                                        var whatsappRegex = /^\(\d{2}\)\s9\d{4}-\d{4}$/;
                                
                                        // Validação de email
                                        validateInput($("#email"), emailRegex, "#email-validation-message", "Formato de Email válido", "Formato de Email inválido");
                                
                                        // Validação de WhatsApp
                                        validateInput($("#whatsapp"), whatsappRegex, "#whatsapp-validation-message", "Formato de WhatsApp válido", "Formato de WhatsApp inválido");
                                    });
                                </script>

                                <script>
                                    $(document).ready(function() {
                                        $('.excluir-foto').on('click', function() {
                                            var fotoId = $(this).data('foto-id');

                                            // Exiba um modal de confirmação antes de excluir a foto
                                            if (confirm('Tem certeza de que deseja excluir esta foto?')) {
                                                // Faça uma solicitação AJAX para excluir a foto
                                                $.ajax({
                                                    type: 'POST',
                                                    url: '/excluir-foto/' + fotoId, // Substitua pelo URL real de exclusão
                                                    data: {
                                                        _token: '{{ csrf_token() }}', // Se estiver usando o Laravel
                                                    },
                                                    success: function(response) {
                                                        // Atualize o modal após a exclusão
                                                        $('#fotosImovelModal{{ $imovel->id }}').modal('hide');
                                                    },
                                                    error: function() {
                                                        alert('Erro ao excluir a foto.');
                                                    }
                                                });
                                            }
                                        });
                                    });
                                </script>
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
  
    <!-- Modal -->
    <div class="modal fade" id="modalimovel" tabindex="-1" role="dialog" aria-labelledby="modalimovelLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalimovelLabel">Cadastro de imovel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('imovel.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="titulo" class="form-label">Título</label>
                            <input type="text" class="form-control" id="titulo" name="titulo" required>
                        </div>
                        <div class="mb-3">
                            <label for="descricao" class="form-label">Descrição</label>                            
                            <textarea  class="form-control"  id="descricao" name="descricao" rows="4" required> </textarea>
                        </div>
                        <!-- Campos para adicionar fotos -->
                        <div class="mb-3">
                            <label for="fotos" class="form-label">Fotos</label>
                            <input type="file" class="form-control" id="fotos" name="fotos[]" multiple>
                        </div>

                        <!-- Campo para o título da foto -->
                        <div class="mb-3">
                            <label for="titulo_foto" class="form-label">Título da Foto</label>
                            <input type="text" class="form-control" id="titulo_foto" name="titulo_foto">
                        </div>

                        <!-- Campo para a descrição da foto -->
                        <div class="mb-3">
                            <label for="descricao_foto" class="form-label">Descrição da Foto</label>
                            <textarea class="form-control" id="descricao_foto" name="descricao_foto" rows="2"></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="tipo_negocio" class="form-label">Tipo de Negócio:</label>
                            <select class="form-control" id="tipo_negocio" name="tipo_negocio" required>
                                <option value="venda">Venda</option>
                                <option value="aluguel">Aluguel</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="endereco" class="form-label">Endereço</label>
                            <input type="text" class="form-control" id="endereco" placeholder="Rua. Joaquim Nabuco, Mossoró - RN, 59600-300" name="endereco" required>
                        </div>
                        <div class="mb-3">
                            <label for="latitude" class="form-label">Latitude</label>
                            <input type="text" class="form-control" id="latitude" name="latitude" required>
                        </div>
                        <div class="mb-3">
                            <label for="longitude" class="form-label">Longitude</label>
                            <input type="text" class="form-control" id="longitude" name="longitude" required>
                        </div>
                    </div>                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        
        $(document).ready(function () {
    var timeout;
    $('#endereco').on('input', function () {
        clearTimeout(timeout);
        var endereco = $(this).val();
        if (endereco !== '') {
            timeout = setTimeout(function () {
                geocodeAddress(endereco);
            }, 1000); // Aguarde 1 segundo após a última entrada para disparar a pesquisa
        }
    });

        function geocodeAddress(address) {
            $.ajax({
                url: 'https://nominatim.openstreetmap.org/search',
                method: 'get',
                data: {
                    q: address,
                    format: 'json',
                },
                success: function (response) {
                    if (response.length > 0) {
                        var lat = response[0].lat;
                        var lon = response[0].lon;
                        $('#latitude').val(lat);
                        $('#longitude').val(lon);
                    } else {
                        alert('Endereço não encontrado. Verifique o endereço e tente novamente.');
                    }
                },
                error: function () {
                    alert('Ocorreu um erro ao tentar geocodificar o endereço.');
                },
            });
        }
    });




    </script>
    
    
    
</x-app-layout>
