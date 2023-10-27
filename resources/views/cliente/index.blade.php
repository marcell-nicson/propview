<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Lista de Clientes -->
                <div class="p-6">                    
                    <h5>{{ __("Lista de Clientes") }}
                        <button type="button" class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#modalCliente">
                            Incluir +
                        </button>
                    </h5>

                    @if ($clientes->isEmpty())
                        <p>Nenhum cliente cadastrado.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>                                    
                                    <th class="text-sm">Nome</th>
                                    <th class="text-sm">Data de Nascimento</th>
                                    <th class="text-sm">Email</th>
                                    <th class="text-sm">WhatsApp</th>
                                    <th class="text-sm">Endereço</th>                                    
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($clientes as $cliente)
                                    <tr>
                                        <td class="text-sm">
                                            {{ $cliente->id . ' - ' }} {{ $cliente->nome }}
                                        </td>                                        
                                        <td class="text-sm">{{ $cliente->nascimento }}</td>
                                        <td class="text-sm">{{ $cliente->email }}</td>                                        
                                        <td class="text-sm">{{ $cliente->whatsapp }}</td>
                                        <td class="text-sm">{{ $cliente->endereco }}</td>                                        
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#editarClienteModal{{ $cliente->id }}">
                                                <i class="fas fa-edit" style="color: #2a45cc; font-size: 20px;"></i>
                                            </a>
                                        </td>
                                        <td>
                                            <a href="#" data-toggle="modal" data-target="#excluirClienteModal{{ $cliente->id }}">
                                                <i class="fa-solid fa-trash" style="color: #df1616; font-size: 20px;"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    
                                    <div class="modal fade" id="excluirClienteModal{{ $cliente->id }}" tabindex="-1" role="dialog" aria-labelledby="excluirClienteModal{{ $cliente->id }}Label" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="excluirClienteModal{{ $cliente->id }}Label">Confirmar Exclusão</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    Tem certeza de que deseja excluir o Cliente {{ $cliente->nome }}?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                    <form action="{{ route('cliente.destroy', $cliente->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Excluir</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Modal de Edição do Cliente -->
                                    <div class="modal fade" id="editarClienteModal{{ $cliente->id }}" tabindex="-1" role="dialog" aria-labelledby="editarClienteModal{{ $cliente->id }}Label" aria-hidden="true">                                    
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="editarClienteModal{{ $cliente->id }}Label">Editar Cliente</h5>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <form action="{{ route('cliente.update', $cliente->id) }}" method="POST" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">                                                        
                                                        <div class="form-group">
                                                            <label for="nome">Nome</label>
                                                            <input type="text" class="form-control" id="nome" name="nome" value="{{ $cliente->nome }}" required>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="nascimento" class="form-label">Data de Nascimento</label>
                                                            <input type="date" class="form-control" id="nascimento" name="nascimento">
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="email">Email</label>
                                                            <input type="email" class="form-control" id="email" name="email" placeholder="exemplo@dominio.com" value="{{ $cliente->email }}" required>
                                                            <span id="email-validation-message"></span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="whatsapp">WhatsApp</label>
                                                            <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="{{ $cliente->whatsapp }}" placeholder="(99) 9XXXX-XXXX" required>                                                            

                                                            <span id="whatsapp-validation-message"></span>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="endereco">Endereço</label>
                                                            <input type="text" class="form-control" id="endereco" name="endereco" value="{{ $cliente->endereco }}" required>
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
                                @endforeach                                                       
                            </tbody>
                            @if (session('success'))
                                <div class="alert alert-success">
                                    {{ session('success') }}
                                </div>
                            @endif
                            @if (session('erro'))
                                <div class="alert alert-danger">
                                    {{ session('erro') }}
                                </div>
                            @endif
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
  
    <!-- Modal -->
    <div class="modal fade" id="modalCliente" tabindex="-1" role="dialog" aria-labelledby="modalClienteLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalClienteLabel">Cadastro de Cliente</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('cliente.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                        <div class="mb-3">
                            <label for="nascimento" class="form-label">Data de Nascimento</label>
                            <input type="date" class="form-control" id="nascimento" name="nascimento">
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="exemplo@dominio.com" name="email" required>
                            <span id="email-validation-message"></span>
                        </div>
                        <div class="mb-3">
                            <label for="whatsapp" class="form-label">WhatsApp</label>
                            <input type="text" class="form-control" id="whatsapp" placeholder="(99) 9XXXX-XXXX" name="whatsapp" required>
                            <span id="whatsapp-validation-message"></span>
                        </div>
                        <div class="form-group">
                            <label for="endereco">Endereço</label>
                            <input type="text" class="form-control" id="endereco" name="endereco" required>
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
    

    
    
</x-app-layout>
