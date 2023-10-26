<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Lista de Corretores -->
                <div class="p-6">                   
                    <h5>{{ __("Lista de Corretores") }}
                        <button type="button" class="btn btn-outline-dark btn-sm" data-toggle="modal" data-target="#modalCorretor">
                            Incluir +
                        </button>
                    </h5>

                    @if ($corretores->isEmpty())
                        <p>Nenhum corretor cadastrado.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>                                    
                                    <th></th>
                                    <th>Nome</th>
                                    <th>Email</th>
                                    <th>WhatsApp</th>
                                    <th>CRECI</th>
                                    <th></th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($corretores as $corretor)
                                <tr>
                                    <td>
                                        @if ($corretor->foto)
                                            <img src="{{ asset('fotos/' . $corretor->foto) }}" alt="{{ $corretor->nome }}" class="rounded-circle" width="45">
                                        @else
                                            <img src="{{ asset('caminho/para/uma/imagem/default') }}" alt="{{ $corretor->nome }}" class="rounded-circle" width="25">
                                        @endif
                                    </td>
                                    <td>                                        
                                        {{ $corretor->id . ' - ' }} {{ $corretor->nome }}
                                    </td>
                                    <td>{{ $corretor->email }}</td>
                                    <td>{{ $corretor->whatsapp }}</td>
                                    <td> {{ $corretor->creci }}</td>
                                    <td> 
                                        <a href="#" data-toggle="modal" data-target="#editarCorretorModal{{ $corretor->id }}">
                                            <i class="fas fa-edit" style="color: #2a45cc;"></i>
                                        </a>
                                    </td>
                                    <td>  
                                        <a href="#" data-toggle="modal" data-target="#excluirCorretorModal{{ $corretor->id }}">
                                            <i class="fa-solid fa-trash" style="color: #df1616;"></i>
                                        </a>
                                    </td>
                                </tr>
                                <div class="modal fade" id="editarCorretorModal{{ $corretor->id }}" tabindex="-1" role="dialog" aria-labelledby="editarCorretorModal{{ $corretor->id }}Label" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editarCorretorModal{{ $corretor->id }}Label">Editar Corretor</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <form action="{{ route('corretor.update', $corretor->id) }}" method="POST" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT') <!-- Define o método como PUT para a atualização -->
                                
                                                <div class="modal-body">
                                                    <!-- Campos do formulário (Nome, Email, WhatsApp, Foto, CRECI) preenchidos com os dados atuais -->
                                                    <div class="form-group">
                                                        <label for="nome">Nome</label>
                                                        <input type="text" class="form-control" id="nome" name="nome" value="{{ $corretor->nome }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="email">Email</label>
                                                        <input type="email" class="form-control" id="email" name="email" value="{{ $corretor->email }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="whatsapp">WhatsApp</label>
                                                        <input type="text" class="form-control" id="whatsapp" name="whatsapp" value="{{ $corretor->whatsapp }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="foto">Foto</label>
                                                        <input type="file" class="form-control" id="foto" name="foto" accept="image/*">
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="creci">CRECI</label>
                                                        <input type="text" class="form-control" id="creci" name="creci" value="{{ $corretor->creci }}" required>
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

                                <div class="modal fade" id="excluirCorretorModal{{ $corretor->id }}" tabindex="-1" role="dialog" aria-labelledby="excluirCorretorModal{{ $corretor->id }}Label" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="excluirCorretorModal{{ $corretor->id }}Label">Confirmar Exclusão</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Tem certeza de que deseja excluir o corretor {{ $corretor->nome }}?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                                <form action="{{ route('corretor.destroy', $corretor->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Excluir</button>
                                                </form>
                                            </div>
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
    <div class="modal fade" id="modalCorretor" tabindex="-1" role="dialog" aria-labelledby="modalCorretorLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCorretorLabel">Cadastro de Corretor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('corretor.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="whatsapp" class="form-label">WhatsApp</label>
                            <input type="text" class="form-control" id="whatsapp" name="whatsapp" required>
                        </div>
                        <div class="mb-3">
                            <label for="foto" class="form-label">Foto</label>
                            <input type="file" class="form-control" id="foto" name="foto" accept="image/*" required>
                        </div>
                        <div class="mb-3">
                            <label for="creci" class="form-label">CRECI</label>
                            <input type="text" class="form-control" id="creci" name="creci" required>
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
